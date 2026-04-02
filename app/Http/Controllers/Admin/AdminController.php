<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        return response()->json([
            'status' => 'success',
            'data'   => [
                'total_users'        => User::where('role', User::ROLE_CUSTOMER)->count(),
                'total_vendors'      => User::where('role', User::ROLE_VENDOR)->count(),
                'pending_vendors'    => Vendor::where('status', Vendor::STATUS_PENDING)->count(),
                'approved_vendors'   => Vendor::where('status', Vendor::STATUS_APPROVED)->count(),
                'rejected_vendors'   => Vendor::where('status', Vendor::STATUS_REJECTED)->count(),
                'total_products'     => Product::count(),
                'total_orders'       => Order::count(),
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

        return response()->json([
            'status'  => 'success',
            'message' => "Vendor application {$action} successfully.",
            'data'    => $vendor->fresh('user'),
        ]);
    }
}
