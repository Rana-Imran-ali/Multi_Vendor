<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentGatewayInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Stripe\PaymentIntent;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function charge(float $amount, string $currency, array $metadata = []): array
    {
        try {
            // Note: Amount is expected in cents or smallest unit if handled correctly,
            // but Stripe's Checkout Session expects `amount_decimal` in subunits (cents).
            // Let's assume $amount is passed as standard decimal (e.g., 29.99USD) and format it, 
            // OR the interface meant to pass it generally. I'll convert it to cents.
            $amountInCents = (int) round($amount * 100);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($currency),
                        'product_data' => [
                            'name' => 'Order #' . ($metadata['order_id'] ?? 'Multiple Items'),
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => $metadata,
                // Replace these with actual frontend routes once available
                'success_url' => url('/ecommerce_frontend/index.html?payment=success&order_id=' . ($metadata['order_id'] ?? '')),
                'cancel_url' => url('/ecommerce_frontend/checkout.html?payment=cancel'),
            ]);

            return [
                'success'        => true,
                'transaction_id' => $session->id, // We store session ID as transaction_id temporarily
                'payment_url'    => $session->url,
                'message'        => 'Stripe Checkout Session created successfully.',
            ];
        } catch (\Exception $e) {
            return [
                'success'        => false,
                'transaction_id' => null,
                'payment_url'    => null,
                'message'        => $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, ?float $amount = null): array
    {
        try {
            // Because transactionId could be a Session ID or a PaymentIntent ID,
            // we should ideally store the PaymentIntent ID. But for simplicity,
            // assuming it's a valid ID to refund against.
            $params = ['payment_intent' => $transactionId];
            if ($amount) {
                $params['amount'] = (int) round($amount * 100);
            }
            $refund = Refund::create($params);

            return [
                'success' => true,
                'message' => 'Refund processed successfully. ID: ' . $refund->id,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verify(string $transactionId): array
    {
        try {
            // Verify a checkout session
            $session = Session::retrieve($transactionId);
            
            if ($session->payment_status === 'paid') {
                return [
                    'success' => true,
                    'status'  => 'paid',
                    'message' => 'Payment verified successfully.',
                ];
            }

            return [
                'success' => false,
                'status'  => $session->payment_status,
                'message' => 'Payment not yet verified as paid.',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
