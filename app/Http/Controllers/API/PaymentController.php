<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    /**
     * POST /api/orders/{order}/pay
     * Process payment for a specific order owned by the authenticated user.
     */
    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized.', 403);
        }

        if ($order->payment_status === 'paid') {
            return $this->errorResponse('This order has already been paid.', 409);
        }

        $result = $this->paymentService->payForOrder($order);

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 402);
        }

        return $this->successResponse([
            'transaction_id' => $result['transaction_id'],
            'order_status'   => $order->fresh()->status,
            'payment_status' => $order->fresh()->payment_status,
        ], $result['message']);
    }

    /**
     * POST /api/admin/orders/{order}/refund
     * Issue a full refund for an order. Admin only.
     */
    public function refund(Request $request, Order $order)
    {
        if ($order->payment_status !== 'paid') {
            return $this->errorResponse('Only paid orders can be refunded.', 422);
        }

        $result = $this->paymentService->refundOrder($order);

        if (! $result['success']) {
            return $this->errorResponse($result['message'], 400);
        }

        return $this->successResponse(null, $result['message']);
    }
}
