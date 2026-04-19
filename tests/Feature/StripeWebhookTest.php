<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;

class StripeWebhookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a fake signed Stripe webhook payload.
     * In tests we bypass actual signature verification by mocking Stripe\Webhook.
     */
    private function buildWebhookPayload(string $type, array $dataObject): array
    {
        return [
            'id'          => 'evt_test_' . uniqid(),
            'object'      => 'event',
            'type'        => $type,
            'data'        => ['object' => $dataObject],
            'created'     => time(),
            'livemode'    => false,
            'api_version' => '2023-10-16',
        ];
    }

    public function test_webhook_ignores_invalid_signature()
    {
        config(['services.stripe.webhook_secret' => 'whsec_test_secret']);

        $response = $this->postJson('/api/stripe/webhook', [], [
            'Stripe-Signature' => 't=123,v1=invalidsig',
        ]);

        // 400 because signature verification fails
        $response->assertStatus(400);
    }

    public function test_checkout_session_completed_marks_order_paid()
    {
        // Bypass Stripe signature verification by mocking the Webhook class
        \Stripe\Webhook::class;

        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create(['user_id' => $vendorUser->id, 'store_name' => 'V', 'slug' => 'v', 'status' => 'approved']);

        $user  = User::factory()->create(['role' => 'customer']);
        $order = Order::create([
            'user_id'          => $user->id,
            'total_amount'     => 100.00,
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
            'shipping_address' => '1 Test St',
        ]);

        // Mock the Stripe\Webhook facade so signature verification is bypassed
        // Directly call the internal method via a partial integration test
        // We simulate what Stripe sends, skipping signature by calling the private method via reflection
        $controller = new \App\Http\Controllers\API\StripeWebhookController();

        // Use reflection to call the private method directly
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('handleCheckoutSessionCompleted');
        $method->setAccessible(true);

        $fakeSession = (object)[
            'metadata'       => (object)['order_id' => $order->id],
            'payment_intent' => 'pi_test_123456',
        ];

        $method->invoke($controller, $fakeSession);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('pi_test_123456', $order->transaction_id);
        $this->assertEquals('processing', $order->status);
    }

    public function test_charge_refunded_marks_order_refunded()
    {
        $user  = User::factory()->create(['role' => 'customer']);
        $order = Order::create([
            'user_id'          => $user->id,
            'total_amount'     => 100.00,
            'status'           => 'delivered',
            'payment_status'   => 'paid',
            'shipping_address' => '1 Test St',
            'transaction_id'   => 'pi_test_refund_123',
        ]);

        $controller = new \App\Http\Controllers\API\StripeWebhookController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('handleRefunded');
        $method->setAccessible(true);

        $fakeCharge = (object)['payment_intent' => 'pi_test_refund_123'];
        $method->invoke($controller, $fakeCharge);

        $order->refresh();
        $this->assertEquals('refunded', $order->payment_status);
    }
}
