<?php

namespace App\Http\Controllers\Admin;

use App\Events\VendorStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────────

    /**
     * GET /api/admin/dashboard
     * Returns platform-wide statistics for the admin dashboard.
     */
    public function dashboard(): JsonResponse
    {
        // Revenue: sum of paid parent orders
        $totalRevenue = (float) Order::whereNull('parent_id')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Monthly revenue for last 6 months (SQLite-safe)
        $monthlyRevenue = DB::table('orders')
            ->whereNull('parent_id')
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("strftime('%Y-%m', created_at) as month, SUM(total_amount) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Order breakdown
        $ordersByStatus = Order::whereNull('parent_id')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Recent orders (last 10)
        $recentOrders = Order::whereNull('parent_id')
            ->with(['user:id,name,email', 'subOrders'])
            ->latest()
            ->limit(10)
            ->get();

        // Top Vendors by Completed Order Revenue
        $topVendors = DB::table('orders')
            ->join('vendors', 'orders.vendor_id', '=', 'vendors.id')
            ->whereNotNull('orders.vendor_id')
            ->where('orders.status', 'delivered') // only count delivered ones
            ->selectRaw('vendors.id, vendors.store_name, vendors.logo, SUM(orders.total_amount) as total_sales, COUNT(orders.id) as orders_count')
            ->groupBy('vendors.id', 'vendors.store_name', 'vendors.logo')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        // Top Products by Quantity Sold
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('products.id, products.name, SUM(order_items.quantity) as qty_sold, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty_sold')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                // User & vendor counts
                'total_users'        => User::where('role', User::ROLE_CUSTOMER)->count(),
                'total_vendors'      => User::where('role', User::ROLE_VENDOR)->count(),
                'pending_vendors'    => Vendor::where('status', Vendor::STATUS_PENDING)->count(),
                'approved_vendors'   => Vendor::where('status', Vendor::STATUS_APPROVED)->count(),
                'rejected_vendors'   => Vendor::where('status', Vendor::STATUS_REJECTED)->count(),
                // Product counts
                'total_products'     => Product::count(),
                'pending_products'   => Product::where('status', 'pending')->count(),
                'active_products'    => Product::where('status', 'active')->count(),
                // Order & revenue
                'total_orders'       => Order::whereNull('parent_id')->count(),
                'orders_by_status'   => $ordersByStatus,
                'total_revenue'      => $totalRevenue,
                'monthly_revenue'    => $monthlyRevenue,
                'recent_orders'      => $recentOrders,
                'top_vendors'        => $topVendors,
                'top_products'       => $topProducts,
            ],
        ]);
    }

    // ─── User Management (CRUD) ───────────────────────────────────────────────

    /**
     * GET /api/admin/users
     * List all users with optional role filter and pagination.
     */
    public function users(Request $request): JsonResponse
    {
        $request->validate([
            'role'     => ['nullable', Rule::in(['admin', 'vendor', 'customer'])],
            'per_page' => 'nullable|integer|min:5|max:100',
            'search'   => 'nullable|string|max:100',
        ]);

        $query = User::query()
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest();

        $users = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'status' => 'success',
            'data'   => $users,
        ]);
    }

    /**
     * GET /api/admin/users/{id}
     * Show a single user with their vendor profile (if any).
     */
    public function show(int $id): JsonResponse
    {
        $user = User::with('vendor')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $user,
        ]);
    }

    /**
     * POST /api/admin/users
     * Admin creates a new user (can assign any role, including admin).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => ['required', Rule::in(['admin', 'vendor', 'customer'])],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'User created successfully.',
            'data'    => $user,
        ], 201);
    }

    /**
     * PUT /api/admin/users/{id}
     * Admin updates a user's name, email, or role.
     * Password change is optional; requires confirmation if provided.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['sometimes', 'required', Rule::in(['admin', 'vendor', 'customer'])],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        // Only update password if explicitly provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'User updated successfully.',
            'data'    => $user->fresh(),
        ]);
    }

    /**
     * DELETE /api/admin/users/{id}
     * Admin deletes a user. Prevents self-deletion.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        if ($request->user()->id === $id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User deleted successfully.',
        ]);
    }

    // ─── Vendor Approval System ───────────────────────────────────────────────

    /**
     * GET /api/admin/vendors
     * List all vendor applications with optional status filter.
     */
    public function vendors(Request $request): JsonResponse
    {
        $request->validate([
            'status'   => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
            'per_page' => 'nullable|integer|min:5|max:100',
        ]);

        $vendors = Vendor::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'status' => 'success',
            'data'   => $vendors,
        ]);
    }

    /**
     * GET /api/admin/vendors/{id}
     * Show a specific vendor application with user and products.
     */
    public function showVendor(int $id): JsonResponse
    {
        $vendor = Vendor::with(['user', 'products'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $vendor,
        ]);
    }

    /**
     * PUT /api/admin/vendors/{id}/review
     * Approve or reject a vendor application.
     *
     * Body: { "status": "approved" | "rejected", "rejection_reason": "..." }
     *
     * On approval  → vendor status = approved, user role = vendor
     * On rejection → vendor status = rejected, reason stored, user role stays customer
     */
    public function reviewVendor(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status'           => ['required', Rule::in(['approved', 'rejected'])],
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $vendor = Vendor::with('user')->findOrFail($id);

        if ($vendor->status !== Vendor::STATUS_PENDING) {
            return response()->json([
                'status'  => 'error',
                'message' => "This vendor application has already been {$vendor->status}.",
            ], 422);
        }

        $vendor->update([
            'status'           => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        if ($validated['status'] === Vendor::STATUS_APPROVED) {
            $vendor->user->update(['role' => User::ROLE_VENDOR]);
        }

        $action = $validated['status'] === Vendor::STATUS_APPROVED ? 'approved' : 'rejected';

        // Fire event instead of direct notification
        Event::dispatch(new VendorStatusUpdated($vendor->fresh(), $validated['status']));

        return response()->json([
            'status'  => 'success',
            'message' => "Vendor application {$action} successfully.",
            'data'    => $vendor->fresh('user'),
        ]);
    }
    // ─── Product Moderation ───────────────────────────────────────────────────

    /**
     * GET /api/admin/products
     * List all products platform-wide with optional status filter.
     */
    public function products(Request $request): JsonResponse
    {
        $request->validate([
            'status'   => ['nullable', Rule::in(['pending', 'active', 'suspended', 'rejected'])],
            'per_page' => 'nullable|integer|min:5|max:100',
        ]);

        $products = Product::with(['vendor', 'category'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'status' => 'success',
            'data'   => $products,
        ]);
    }

    /**
     * PUT /api/admin/products/{id}/status
     * Admin modifies a product's visibility/status.
     */
    public function updateProductStatus(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'active', 'suspended', 'rejected'])],
        ]);

        $product = Product::findOrFail($id);
        $product->update(['status' => $validated['status']]);

        return response()->json([
            'status'  => 'success',
            'message' => "Product status updated to {$validated['status']}.",
            'data'    => $product->fresh(['vendor', 'category']),
        ]);
    }
}
