<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $customer;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        $token = $this->admin->createToken('test')->plainTextToken;
        $this->headers = [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ];

        // Create random Customer
        $this->customer = User::create([
            'name' => 'Test Customer',
            'email' => 'test.customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);
    }

    // ─── 1. Access Control Tests ──────────────────────────────────────────────

    public function test_non_admin_cannot_access_admin_routes()
    {
        $customerToken = $this->customer->createToken('test')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer $customerToken",
            'Accept'        => 'application/json',
        ])->get('/api/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_analytics()
    {
        // Setup some dummy data
        $vendorUser = User::create([
            'name' => 'Vendor Test',
            'email' => 'vendor.dashboard@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor'
        ]);
        
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'store_name' => 'Dash Store',
            'slug' => 'dash-store',
            'status' => 'approved'
        ]);
        
        $category = Category::create([
            'name' => 'Dash Cat',
            'slug' => 'dash-cat'
        ]);
        
        $product = Product::create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'name' => 'Dash Prod',
            'slug' => 'dash-prod',
            'price' => 250,
            'stock' => 10,
            'status' => 'active'
        ]);
        
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'ORD-1234',
            'status' => 'delivered',
            'payment_status' => 'paid',
            'vendor_id' => $vendor->id,
            'total_amount' => 500,
            'shipping_address' => '123 Test St'
        ]);
        
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 2,
            'price' => 250
        ]);

        $response = $this->withHeaders($this->headers)->getJson('/api/admin/dashboard');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'total_users',
                         'total_vendors',
                         'top_vendors',
                         'top_products',
                         'total_revenue',
                     ]
                 ]);
    }

    // ─── 2. User Management Tests ─────────────────────────────────────────────

    public function test_admin_can_list_users()
    {
        User::create([
            'name' => 'Customer 1',
            'email' => 'c1@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);

        $response = $this->withHeaders($this->headers)->getJson('/api/admin/users');

        $response->assertStatus(200)
                 ->assertJsonPath('status', 'success');
        $this->assertGreaterThanOrEqual(1, count($response->json('data.data')));
    }

    public function test_admin_can_create_new_user()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'vendor'
        ];

        $response = $this->withHeaders($this->headers)->postJson('/api/admin/users', $userData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'newuser@example.com', 'role' => 'vendor']);
                 
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com', 'role' => 'vendor']);
    }

    public function test_admin_can_update_user_role()
    {
        $userToUpdate = User::create([
            'name' => 'Update Me',
            'email' => 'update@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);

        $response = $this->withHeaders($this->headers)->putJson("/api/admin/users/{$userToUpdate->id}", [
            'role' => 'admin'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $userToUpdate->id, 'role' => 'admin']);
    }

    public function test_admin_can_delete_user()
    {
        $userToDelete = User::create([
            'name' => 'Delete Me',
            'email' => 'delete@example.com',
            'password' => Hash::make('pwd')
        ]);

        $response = $this->withHeaders($this->headers)->deleteJson("/api/admin/users/{$userToDelete->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_admin_cannot_delete_self()
    {
        $response = $this->withHeaders($this->headers)->deleteJson("/api/admin/users/{$this->admin->id}");

        $response->assertStatus(422)
                 ->assertJsonFragment(['message' => 'You cannot delete your own account.']);
    }

    // ─── 3. Vendor Approval Tests ─────────────────────────────────────────────

    public function test_admin_can_approve_vendor()
    {
        $vendorUser = User::create([
            'name' => 'Approve Vendor User',
            'email' => 'appr.vendor@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);
        
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'store_name' => 'Approve Store',
            'slug' => 'approve-store',
            'status' => 'pending'
        ]);

        $response = $this->withHeaders($this->headers)->putJson("/api/admin/vendors/{$vendor->id}/review", [
            'status' => 'approved'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('vendors', ['id' => $vendor->id, 'status' => 'approved']);
        $this->assertDatabaseHas('users', ['id' => $vendorUser->id, 'role' => 'vendor']);
    }

    public function test_admin_can_reject_vendor_with_reason()
    {
        $vendorUser2 = User::create([
            'name' => 'Reject Vendor User',
            'email' => 'rej.vendor@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer'
        ]);
        
        $vendor = Vendor::create([
            'user_id' => $vendorUser2->id,
            'store_name' => 'Reject Store',
            'slug' => 'reject-store',
            'status' => 'pending'
        ]);

        $response = $this->withHeaders($this->headers)->putJson("/api/admin/vendors/{$vendor->id}/review", [
            'status' => 'rejected',
            'rejection_reason' => 'Store name violates policy.'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('vendors', [
            'id' => $vendor->id, 
            'status' => 'rejected',
            'rejection_reason' => 'Store name violates policy.'
        ]);
        $this->assertDatabaseHas('users', ['id' => $vendorUser2->id, 'role' => 'customer']); // Ensure role didn't upgrade
    }

    // ─── 4. Product Moderation Tests ──────────────────────────────────────────

    public function test_admin_can_list_products()
    {
        $vendorUser3 = User::create([
            'name' => 'Prod Vendor User',
            'email' => 'prod.vendor@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor'
        ]);
        
        $vendor = Vendor::create([
            'user_id' => $vendorUser3->id,
            'store_name' => 'Prod Store',
            'slug' => 'prod-store',
            'status' => 'approved'
        ]);
        
        $category = Category::create([
            'name' => 'Prod Cat',
            'slug' => 'prod-cat'
        ]);
        
        Product::create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'name' => 'Pending Prod',
            'slug' => 'pending-prod',
            'price' => 10,
            'stock' => 1,
            'status' => 'pending'
        ]);

        $response = $this->withHeaders($this->headers)->getJson('/api/admin/products');

        $response->assertStatus(200)->assertJsonPath('status', 'success');
        $this->assertGreaterThanOrEqual(1, count($response->json('data.data')));
    }

    public function test_admin_can_suspend_product()
    {
        $vendorUser4 = User::create([
            'name' => 'Susp Vendor User',
            'email' => 'susp.vendor@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor'
        ]);
        
        $vendor = Vendor::create([
            'user_id' => $vendorUser4->id,
            'store_name' => 'Susp Store',
            'slug' => 'susp-store',
            'status' => 'approved'
        ]);
        
        $category = Category::create([
            'name' => 'Susp Cat',
            'slug' => 'susp-cat'
        ]);
        
        $product = Product::create([
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'name' => 'Active Prod',
            'slug' => 'active-prod',
            'price' => 10,
            'stock' => 1,
            'status' => 'active'
        ]);

        $response = $this->withHeaders($this->headers)->putJson("/api/admin/products/{$product->id}/status", [
            'status' => 'suspended'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'suspended']);
    }
}
