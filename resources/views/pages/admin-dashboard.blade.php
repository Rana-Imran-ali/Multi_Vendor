@extends('layouts.app')

@section('title', 'Admin Dashboard | Vendo')

@push('styles')
<style>
    .dashboard-layout { display: flex; min-height: calc(100vh - var(--navbar-height)); background: var(--background); }
    
    .dashboard-sidebar { width: 260px; background: var(--surface); border-right: 1px solid var(--border); padding: 2rem 1.5rem; display: flex; flex-direction: column; }
    .nav-item { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1rem; color: var(--text-muted); text-decoration: none; border-radius: 0.5rem; font-weight: 500; transition: var(--transition); margin-bottom: 0.5rem; }
    .nav-item:hover, .nav-item.active { background: var(--primary-light); color: var(--primary); }
    .nav-item i { font-size: 1.1rem; width: 20px; text-align: center; }
    
    .dashboard-main { flex: 1; padding: 2.5rem; overflow-y: auto; }
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .dashboard-header h1 { font-size: 1.8rem; font-weight: 800; color: var(--text); }
    
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 1.5rem; }
    .stat-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
    
    .table-container { background: var(--surface); border: 1px solid var(--border); border-radius: 1rem; overflow: hidden; box-shadow: var(--shadow-sm); }
    .table-header { padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .table-header h3 { font-size: 1.25rem; font-weight: 700; margin: 0; }
    
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid var(--border); }
    th { font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; background: rgba(0,0,0,0.02); }
    td { font-size: 0.95rem; color: var(--text); }
    tr:last-child td { border-bottom: none; }
    .badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="dashboard-layout fade-in">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; padding-left: 1rem;">Main Menu</div>
        <a href="#" class="nav-item active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-box"></i> Products</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-layer-group"></i> Categories</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-cart-shopping"></i> Orders</a>
        
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 2rem; margin-bottom: 1rem; padding-left: 1rem;">Users</div>
        <a href="#" class="nav-item"><i class="fa-solid fa-store"></i> Vendors</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-users"></i> Customers</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-cog"></i> Settings</a>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <div class="dashboard-header">
            <h1>Admin Overview</h1>
            <div style="display:flex; gap:1rem;">
                <button class="btn btn-outline"><i class="fa-solid fa-download"></i> Export Report</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);"><i class="fa-solid fa-sack-dollar"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Total Revenue</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">$45,231.89</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="fa-solid fa-cart-shopping"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Total Orders</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">1,248</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef9c3; color: #ca8a04;"><i class="fa-solid fa-store"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Total Vendors</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">84</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fee2e2; color: #ef4444;"><i class="fa-solid fa-users"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Total Users</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">8,943</div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Recent Orders</h3>
                <a href="#" style="color:var(--primary); font-weight:600; font-size:0.9rem;">View All</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong style="color:var(--text);">#ORD-9938</strong></td>
                        <td>Sarah Johnson</td>
                        <td style="color:var(--text-muted);">Today, 10:45 AM</td>
                        <td style="font-weight:700;">$1,299.00</td>
                        <td><span class="badge" style="background:#dcfce7; color:#16a34a;">Completed</span></td>
                    </tr>
                    <tr>
                        <td><strong style="color:var(--text);">#ORD-9937</strong></td>
                        <td>Michael Smith</td>
                        <td style="color:var(--text-muted);">Yesterday, 04:30 PM</td>
                        <td style="font-weight:700;">$45.50</td>
                        <td><span class="badge" style="background:#fef9c3; color:#ca8a04;">Pending</span></td>
                    </tr>
                    <tr>
                        <td><strong style="color:var(--text);">#ORD-9936</strong></td>
                        <td>Emily Davis</td>
                        <td style="color:var(--text-muted);">Oct 24, 2026</td>
                        <td style="font-weight:700;">$320.00</td>
                        <td><span class="badge" style="background:#fee2e2; color:#ef4444;">Cancelled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
