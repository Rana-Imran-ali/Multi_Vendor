<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(private readonly PaymentGatewayInterface $gateway)
    {
    }

    /**
     * Process payment for a given order.
     * Updates payment_status and stores the transaction_id on success.
     */
    public function payForOrder(Order $order): array
    {
        try {
            $result = $this->gateway->charge(
                amount: $order->total_amount,
                currency: 'usd',
                metadata: [
                    'order_id' => $order->id,
                    'user_id'  => $order->user_id,
                ]
            );

            if ($result['success']) {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $result['transaction_id'],
                ]);

                // Cascade payment status to sub-orders
                if ($order->subOrders()->exists()) {
                    $order->subOrders()->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $result['transaction_id'],
                    ]);
                }
            }

            return $result;
        } catch (\Throwable $e) {
            return [
                'success'        => false,
                'transaction_id' => null,
                'payment_url'    => null,
                'message'        => 'Payment failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Issue a refund for a given order.
     */
    public function refundOrder(Order $order): array
    {
        if (! $order->transaction_id) {
            return ['success' => false, 'message' => 'No transaction ID found for this order.'];
        }

        $result = $this->gateway->refund($order->transaction_id);

        if ($result['success']) {
            $order->update(['payment_status' => 'refunded']);

            // Cascade refund status to sub-orders
            if ($order->subOrders()->exists()) {
                $order->subOrders()->update(['payment_status' => 'refunded']);
            }
        }

        return $result;
    }
}
