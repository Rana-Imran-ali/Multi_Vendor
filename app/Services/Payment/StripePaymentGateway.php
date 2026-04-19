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
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(float $amount, string $currency, array $metadata = []): array
    {
        try {
            $amountInCents = (int) round($amount * 100);

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency'     => strtolower($currency),
                        'product_data' => [
                            'name' => 'Order #' . ($metadata['order_id'] ?? 'Multiple Items'),
                        ],
                        'unit_amount'  => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode'        => 'payment',
                'metadata'    => $metadata,
                'success_url' => url('/ecommerce_frontend/index.html?payment=success&order_id=' . ($metadata['order_id'] ?? '')),
                'cancel_url'  => url('/ecommerce_frontend/checkout.html?payment=cancel'),
            ]);

            return [
                'success'        => true,
                // Store checkout session ID; PaymentIntent resolved via webhook
                'transaction_id' => $session->id,
                'payment_url'    => $session->url,
                'message'        => 'Stripe Checkout Session created. Redirect user to payment_url.',
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
            // transaction_id may be a Session ID or PaymentIntent ID.
            // After webhook processing we store the PaymentIntent ID.
            // If it starts with 'cs_' it's a Session — resolve to PaymentIntent first.
            $paymentIntentId = $transactionId;
            if (str_starts_with($transactionId, 'cs_')) {
                $session         = Session::retrieve($transactionId);
                $paymentIntentId = $session->payment_intent;
            }

            $params = ['payment_intent' => $paymentIntentId];
            if ($amount) {
                $params['amount'] = (int) round($amount * 100);
            }

            $refund = Refund::create($params);

            return [
                'success' => true,
                'message' => 'Refund processed. ID: ' . $refund->id,
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
