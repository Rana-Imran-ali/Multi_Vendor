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

        // Sales stats
        $totalOrders = Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))->count();

        $totalRevenue = (float) DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.vendor_id', $vendorId)
            ->whereIn('orders.status', ['delivered', 'processing', 'shipped'])
            ->sum(DB::raw('order_items.price * order_items.quantity'));

        $pendingOrders = Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))
            ->where('status', 'pending')
            ->count();

        // Product stats
        $totalProducts  = Product::where('vendor_id', $vendorId)->count();
        $activeProducts = Product::where('vendor_id', $vendorId)->where('status', 'active')->count();
        $lowStockCount  = Product::where('vendor_id', $vendorId)->where('stock', '<=', 5)->where('stock', '>', 0)->count();
        $outOfStock     = Product::where('vendor_id', $vendorId)->where('stock', 0)->count();

        // Recent orders (last 5)
        $recentOrders = Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))
            ->with(['user:id,name,email', 'items.product:id,name,vendor_id'])
            ->latest()
            ->limit(5)
            ->get();

        // Monthly revenue for the last 6 months
        $monthlyRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.vendor_id', $vendorId)
            ->whereIn('orders.status', ['delivered', 'processing', 'shipped'])
            ->where('orders.created_at', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m') as month, SUM(order_items.price * order_items.quantity) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'overview' => [
                'total_orders'   => $totalOrders,
                'pending_orders' => $pendingOrders,
                'total_revenue'  => $totalRevenue,
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'low_stock'      => $lowStockCount,
                'out_of_stock'   => $outOfStock,
            ],
            'recent_orders'  => $recentOrders,
            'monthly_revenue' => $monthlyRevenue,
        ];
    }
}
