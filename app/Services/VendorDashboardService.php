<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorDashboardService
{
    /**
     * Build full dashboard statistics for a vendor.
     */
    public function getStats(Vendor $vendor): array
    {
        $vendorId = $vendor->id;

        // Sub-orders (child orders) are now scoped to vendor_id directly
        $baseQuery = fn() => Order::where('vendor_id', $vendorId);

        $totalOrders   = $baseQuery()->count();
        $pendingOrders = $baseQuery()->where('status', 'pending')->count();
        $totalRevenue  = (float) $baseQuery()
            ->whereIn('status', ['delivered', 'processing', 'shipped'])
            ->sum('total_amount');

        // Product stats
        $totalProducts  = Product::where('vendor_id', $vendorId)->count();
        $activeProducts = Product::where('vendor_id', $vendorId)->where('status', 'active')->count();
        $lowStockCount  = Product::where('vendor_id', $vendorId)->whereBetween('stock', [1, 5])->count();
        $outOfStock     = Product::where('vendor_id', $vendorId)->where('stock', 0)->count();

        // Recent sub-orders (last 5)
        $recentOrders = $baseQuery()
            ->with(['user:id,name,email', 'items.product:id,name'])
            ->latest()
            ->limit(5)
            ->get();

        // Monthly revenue last 6 months (SQLite-compatible strftime; MySQL use DATE_FORMAT)
        $monthlyRevenue = DB::table('orders')
            ->where('vendor_id', $vendorId)
            ->whereIn('status', ['delivered', 'processing', 'shipped'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("strftime('%Y-%m', created_at) as month, SUM(total_amount) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'overview' => [
                'total_orders'    => $totalOrders,
                'pending_orders'  => $pendingOrders,
                'total_revenue'   => $totalRevenue,
                'total_products'  => $totalProducts,
                'active_products' => $activeProducts,
                'low_stock'       => $lowStockCount,
                'out_of_stock'    => $outOfStock,
            ],
            'recent_orders'   => $recentOrders,
            'monthly_revenue' => $monthlyRevenue,
        ];
    }
}
