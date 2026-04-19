<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhook events.
     * This endpoint must be excluded from CSRF verification.
     * Stripe signs every payload — we verify the signature before doing anything.
     */
    public function handle(Request $request)
    {
        $payload    = $request->getContent();
        $sigHeader  = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        // ── 1. Verify Stripe signature ─────────────────────────────────────────
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe Webhook: Invalid payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe Webhook: Signature mismatch', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // ── 2. Route to correct handler ────────────────────────────────────────
        Log::info('Stripe Webhook received', ['type' => $event->type]);

        match ($event->type) {
            'checkout.session.completed'    => $this->handleCheckoutSessionCompleted($event->data->object),
            'payment_intent.payment_failed' => $this->handlePaymentFailed($event->data->object),
            'charge.refunded'               => $this->handleRefunded($event->data->object),
            default                         => null, // Silently ignore unhandled event types
        };

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Stripe fires this after the customer completes payment on the hosted checkout page.
     * We update the order payment_status to 'paid' and store the PaymentIntent ID.
     */
    private function handleCheckoutSessionCompleted(object $session): void
    {
        $orderId       = $session->metadata->order_id ?? null;
        $paymentIntent = $session->payment_intent;

        if (! $orderId) {
            Log::warning('Stripe Webhook: checkout.session.completed missing order_id in metadata');
            return;
        }

        $order = Order::find($orderId);

        if (! $order) {
            Log::warning("Stripe Webhook: Order {$orderId} not found");
            return;
        }

        // Update parent order
        $order->update([
            'payment_status' => 'paid',
            'transaction_id' => $paymentIntent, // Store PaymentIntent ID (needed for refunds)
            'status'         => 'processing',
        ]);

        // Cascade to all sub-orders
        if ($order->subOrders()->exists()) {
            $order->subOrders()->update([
                'payment_status' => 'paid',
                'transaction_id' => $paymentIntent,
                'status'         => 'processing',
            ]);
        }

        Log::info("Stripe Webhook: Order {$orderId} marked as paid. PI: {$paymentIntent}");
    }

    /**
     * Fired when a PaymentIntent fails (card declined, insufficient funds, etc.)
     * We mark the order as failed so the customer knows to retry.
     */
    private function handlePaymentFailed(object $paymentIntent): void
    {
        // PaymentIntent metadata may contain order_id if we attached it
        $orderId = $paymentIntent->metadata->order_id ?? null;

        if (! $orderId) {
            // Try to look up by transaction_id (session ID stored before webhook arrived)
            Log::warning('Stripe Webhook: payment_intent.payment_failed missing order_id in metadata');
            return;
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update(['payment_status' => 'failed']);

            if ($order->subOrders()->exists()) {
                $order->subOrders()->update(['payment_status' => 'failed']);
            }

            Log::info("Stripe Webhook: Order {$orderId} payment failed.");
        }
    }

    /**
     * Fired after a successful refund on a charge.
     * We mark the order as refunded if it was previously paid.
     */
    private function handleRefunded(object $charge): void
    {
        $paymentIntentId = $charge->payment_intent ?? null;

        if (! $paymentIntentId) {
            return;
        }

        $order = Order::where('transaction_id', $paymentIntentId)->first();

        if ($order) {
            $order->update(['payment_status' => 'refunded']);

            if ($order->subOrders()->exists()) {
                $order->subOrders()->update(['payment_status' => 'refunded']);
            }

            Log::info("Stripe Webhook: Order {$order->id} marked as refunded.");
        }
    }
}
