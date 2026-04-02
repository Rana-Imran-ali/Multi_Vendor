@extends('layouts.admin')

@section('title', 'Overview')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="page-desc">Here's what's happening with your store today.</p>
    </div>
    <div>
        <button class="btn btn-sm btn-outline-secondary bg-white me-2">
            <i class="fa-regular fa-calendar me-2"></i> Last 30 Days
        </button>
        <button class="btn btn-sm btn-primary" style="background:var(--admin-primary); border:none;">
            <i class="fa-solid fa-download me-2"></i> Export Report
        </button>
    </div>
</div>

{{-- STAT CARDS --}}
{{-- ── STAT CARDS (values populated via JS from /api/admin/dashboard) ── --}}
<div class="row g-4 mb-4">

    {{-- Total Customers --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="stat-label-text">Total Customers</p>
                    <h3 class="stat-value" id="stat-users"><span class="shimmer-line" style="width:80px;"></span></h3>
                </div>
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="status-pill status-info py-1 px-2" style="font-size:.7rem;" id="stat-pending-badge">
                    <i class="fa-solid fa-clock"></i> <span id="stat-pending">—</span> pending vendors
                </span>
            </div>
        </div>
    </div>

    {{-- Total Orders --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="stat-label-text">Total Orders</p>
                    <h3 class="stat-value" id="stat-orders"><span class="shimmer-line" style="width:70px;"></span></h3>
                </div>
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="status-pill status-success py-1 px-2" style="font-size:.7rem;">
                    <i class="fa-solid fa-circle-check"></i> Live from database
                </span>
            </div>
        </div>
    </div>

    {{-- Approved Vendors --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="stat-label-text">Approved Vendors</p>
                    <h3 class="stat-value" id="stat-vendors"><span class="shimmer-line" style="width:50px;"></span></h3>
                </div>
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="status-pill status-warning py-1 px-2" style="font-size:.7rem;">
                    <i class="fa-solid fa-hourglass-half"></i> <span id="stat-pending2">—</span> awaiting review
                </span>
            </div>
        </div>
    </div>

    {{-- Total Products --}}
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="stat-label-text">Total Products</p>
                    <h3 class="stat-value" id="stat-products"><span class="shimmer-line" style="width:60px;"></span></h3>
                </div>
                <div class="icon-box bg-info bg-opacity-10 text-info">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="status-pill status-success py-1 px-2" style="font-size:.7rem;">
                    <i class="fa-solid fa-circle-check"></i> Live from database
                </span>
            </div>
        </div>
    </div>

</div>

{{-- MIDDLE CHARTS --}}
<div class="row g-4 mb-4">
    
    {{-- Main Chart (Placeholder) --}}
    <div class="col-12 col-lg-8">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark fs-6">Revenue Over Time</h5>
                <select class="form-select form-select-sm w-auto shadow-none" style="font-size:.75rem; font-weight:600; cursor:pointer;">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
            </div>
            {{-- CSS Chart Simulation --}}
            <div class="chart-container">
                <div class="y-axis">
                    <span>$50k</span><span>$40k</span><span>$30k</span><span>$20k</span><span>$10k</span><span>$0</span>
                </div>
                <div class="bars">
                    <div class="bar-wrap"><div class="bar primary" style="height:30%"></div><span class="x-label">Jan</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:45%"></div><span class="x-label">Feb</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:60%"></div><span class="x-label">Mar</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:40%"></div><span class="x-label">Apr</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:70%"></div><span class="x-label">May</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:85%"></div><span class="x-label">Jun</span></div>
                    <div class="bar-wrap"><div class="bar primary" style="height:55%"></div><span class="x-label">Jul</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products list --}}
    <div class="col-12 col-lg-4">
        <div class="saas-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark fs-6">Top Products</h5>
                <a href="{{ url('/admin/products') }}" class="text-primary text-decoration-none fs-xs fw-bold">View All</a>
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="tp-img bg-light rounded"><i class="fa fa-headphones text-primary"></i></div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-600 text-dark fs-sm">Sony WH-1000XM5</p>
                        <p class="mb-0 text-muted fs-xs">84 Sales</p>
                    </div>
                    <span class="fw-bold fs-sm">Rs 3.6M</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="tp-img bg-light rounded"><i class="fa fa-shoe-prints text-info"></i></div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-600 text-dark fs-sm">Nike Air Max 270</p>
                        <p class="mb-0 text-muted fs-xs">62 Sales</p>
                    </div>
                    <span class="fw-bold fs-sm">Rs 1.1M</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="tp-img bg-light rounded"><i class="fa fa-stopwatch text-warning"></i></div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-600 text-dark fs-sm">Apple Watch S8</p>
                        <p class="mb-0 text-muted fs-xs">45 Sales</p>
                    </div>
                    <span class="fw-bold fs-sm">Rs 4.0M</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="tp-img bg-light rounded"><i class="fa fa-laptop text-success"></i></div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-600 text-dark fs-sm">MacBook Air M2</p>
                        <p class="mb-0 text-muted fs-xs">21 Sales</p>
                    </div>
                    <span class="fw-bold fs-sm">Rs 6.3M</span>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- RECENT ORDERS TABLE --}}
<div class="saas-card p-0 overflow-hidden">
    <div class="d-flex justify-content-between align-items-center p-4 border-bottom border-light">
        <h5 class="fw-bold mb-0 text-dark fs-6">Recent Orders</h5>
        <a href="{{ url('/admin/orders') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
    </div>

    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-600 text-primary">#ORD-9021</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-primary text-white rounded-circle fs-xs d-flex align-items-center justify-content-center" style="width:28px;height:28px;">AK</div>
                            <span class="fw-500">Ali Khan</span>
                        </div>
                    </td>
                    <td class="text-muted">Today, 10:45 AM</td>
                    <td><span class="status-pill status-warning"><i class="fa-solid fa-clock"></i> Pending</span></td>
                    <td class="fw-bold">Rs 24,500</td>
                    <td class="text-end">
                        <button class="action-btn" title="View Details"><i class="fa-regular fa-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-600 text-primary">#ORD-9020</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-success text-white rounded-circle fs-xs d-flex align-items-center justify-content-center" style="width:28px;height:28px;">SR</div>
                            <span class="fw-500">Sara Raza</span>
                        </div>
                    </td>
                    <td class="text-muted">Yesterday, 04:30 PM</td>
                    <td><span class="status-pill status-info"><i class="fa-solid fa-truck-fast"></i> Shipped</span></td>
                    <td class="fw-bold">Rs 45,999</td>
                    <td class="text-end">
                        <button class="action-btn" title="View Details"><i class="fa-regular fa-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="fw-600 text-primary">#ORD-9019</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm bg-info text-white rounded-circle fs-xs d-flex align-items-center justify-content-center" style="width:28px;height:28px;">UM</div>
                            <span class="fw-500">Usman Malik</span>
                        </div>
                    </td>
                    <td class="text-muted">Mar 25, 2026</td>
                    <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check"></i> Delivered</span></td>
                    <td class="fw-bold">Rs 12,000</td>
                    <td class="text-end">
                        <button class="action-btn" title="View Details"><i class="fa-regular fa-eye"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    // ── Fetch live dashboard stats ─────────────────────────────────────────
    const token = localStorage.getItem('admin_token');

    // Shimmer animation helper
    function shimmer(id) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = '<span class="shimmer-line" style="width:70px;display:inline-block;"></span>';
    }

    // Animate count-up for a numeric value
    function countUp(id, target, duration = 800) {
        const el = document.getElementById(id);
        if (!el) return;
        const start = 0;
        const step  = target / (duration / 16);
        let   cur   = start;
        const tick  = () => {
            cur += step;
            if (cur >= target) { el.textContent = target.toLocaleString(); return; }
            el.textContent = Math.floor(cur).toLocaleString();
            requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    }

    async function loadDashboard() {
        try {
            const res = await fetch('/api/admin/dashboard', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                },
            });

            // ── Auth guard: if token is invalid/expired, redirect to login ──
            if (res.status === 401 || res.status === 403) {
                localStorage.removeItem('admin_token');
                localStorage.removeItem('admin_user');
                window.location.replace('/admin/login');
                return;
            }

            if (!res.ok) throw new Error('API error ' + res.status);

            const json = await res.json();
            const d    = json.data;

            // ── Populate stat cards with count-up animation ──
            countUp('stat-users',    d.total_users    ?? 0);
            countUp('stat-orders',   d.total_orders   ?? 0);
            countUp('stat-vendors',  d.approved_vendors ?? 0);
            countUp('stat-products', d.total_products  ?? 0);

            // ── Pending vendor badge ──
            const pending = d.pending_vendors ?? 0;
            document.getElementById('stat-pending').textContent  = pending;
            document.getElementById('stat-pending2').textContent = pending;

        } catch (err) {
            // Show error state on cards
            ['stat-users','stat-orders','stat-vendors','stat-products'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = '<span style="color:#ef4444;font-size:.85rem;"><i class="fa fa-exclamation-circle me-1"></i>Error</span>';
            });
            console.error('Dashboard fetch failed:', err);
        }
    }

    loadDashboard();
})();
</script>
@endpush

@push('styles')
<style>
/* ── Shimmer loading skeleton ── */
@keyframes shimmerMove {
    0%   { background-position: -400px 0; }
    100% { background-position:  400px 0; }
}
.shimmer-line {
    display: inline-block; height: 1.8rem; border-radius: 6px;
    background: linear-gradient(90deg, #e2e8f0 25%, #f8fafc 50%, #e2e8f0 75%);
    background-size: 800px 100%;
    animation: shimmerMove 1.4s infinite linear;
    vertical-align: middle;
}

/* ── Stat card labels ── */
.stat-label-text {
    text-transform: uppercase; font-weight: 700; font-size: .7rem;
    letter-spacing: .5px; color: var(--admin-text-sub); margin-bottom: .25rem;
}
.stat-value {
    font-size: 1.75rem; font-weight: 800; color: var(--admin-text-main);
    letter-spacing: -1px; margin: 0; min-height: 2.25rem;
}

/* Stat Cards Specific */

.icon-box {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
}

/* Chart Gen (CSS based for visual demo) */
.chart-container {
    height: 240px; display: flex; align-items: flex-end; gap: 1rem;
    padding-left: 3rem; position: relative;
}
.y-axis {
    position: absolute; left: 0; top: 0; bottom: 20px;
    display: flex; flex-direction: column; justify-content: space-between;
    font-size: 0.65rem; color: var(--admin-text-sub); font-weight: 600; text-align: right; width: 35px;
}
.bars {
    flex: 1; height: 100%; display: flex; align-items: flex-end; justify-content: space-around;
    border-bottom: 1px solid var(--admin-border); border-left: 1px solid var(--admin-border);
    padding-bottom: 0;
}
.bar-wrap { height: 100%; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; width: 8%; position: relative; }
.bar { width: 100%; border-radius: 4px 4px 0 0; transition: height 1s ease; cursor: crosshair; }
.bar.primary { background: var(--admin-primary); opacity: 0.8; }
.bar.primary:hover { opacity: 1; }
.x-label { position: absolute; bottom: -24px; font-size: 0.65rem; font-weight: 600; color: var(--admin-text-sub); }

/* Top Products */
.tp-img { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.fs-sm { font-size: 0.85rem; }
.fs-xs { font-size: 0.75rem; }
.fw-500 { font-weight: 500; }
.fw-600 { font-weight: 600; }
</style>
@endpush