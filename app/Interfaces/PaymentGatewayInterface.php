<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    /**
     * Process a payment intent.
     *
     * @param float  $amount   Amount in the smallest currency unit (e.g. cents)
     * @param string $currency ISO 4217 currency code (e.g. "usd")
     * @param array  $metadata Arbitrary key-value metadata (order_id, user_id, etc.)
     *
     * @return array{
     *     success: bool,
     *     transaction_id: string|null,
     *     payment_url: string|null,
     *     message: string
     * }
     */
    public function charge(float $amount, string $currency, array $metadata = []): array;

    /**
     * Refund a previously captured transaction.
     *
     * @param string $transactionId
     * @param float|null $amount Partial refund amount; null = full refund
     *
     * @return array{success: bool, message: string}
     */
    public function refund(string $transactionId, ?float $amount = null): array;

    /**
     * Verify payment status by transaction ID.
     *
     * @return array{success: bool, status: string, message: string}
     */
    public function verify(string $transactionId): array;
}
