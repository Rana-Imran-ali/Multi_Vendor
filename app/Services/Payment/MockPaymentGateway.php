<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Str;

/**
 * MockPaymentGateway — used for local development and testing.
 * Simulates successful payments without hitting any real API.
 * Replace with StripePaymentGateway in production.
 */
class MockPaymentGateway implements PaymentGatewayInterface
{
    public function charge(float $amount, string $currency, array $metadata = []): array
    {
        // Simulate a successful charge
        return [
            'success'        => true,
            'transaction_id' => 'MOCK_TXN_' . strtoupper(Str::random(12)),
            'payment_url'    => null,
            'message'        => "Mock payment of {$amount} {$currency} processed successfully.",
        ];
    }

    public function refund(string $transactionId, ?float $amount = null): array
    {
        return [
            'success' => true,
            'message' => "Mock refund for transaction {$transactionId} processed successfully.",
        ];
    }

    public function verify(string $transactionId): array
    {
        return [
            'success' => true,
            'status'  => 'paid',
            'message' => "Transaction {$transactionId} is verified as paid.",
        ];
    }
}
