@extends('layouts.app')

@section('title', 'Vendor Dashboard | Vendo')

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
        <div style="display:flex; align-items:center; gap:1rem; padding: 0 1rem 2rem 1rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem;">
            <div style="width:50px; height:50px; background:var(--primary-light); color:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.5rem;"><i class="fa-solid fa-store"></i></div>
            <div>
                <h4 style="font-size:1.1rem; font-weight:800; margin:0;" class="navUserName">My Store</h4>
                <div style="font-size:0.8rem; color:var(--text-muted);">Pro Seller</div>
            </div>
        </div>

        <a href="#" class="nav-item active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-box"></i> My Products</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-plus-circle"></i> Add Product</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-cart-shopping"></i> Store Orders</a>
        
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 2rem; margin-bottom: 1rem; padding-left: 1rem;">Settings</div>
        <a href="#" class="nav-item"><i class="fa-regular fa-address-card"></i> Profile</a>
        <a href="#" class="nav-item"><i class="fa-solid fa-building-columns"></i> Payouts</a>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <div class="dashboard-header">
            <h1>Vendor Dashboard</h1>
            <div style="display:flex; gap:1rem;">
                <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Product</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);"><i class="fa-solid fa-wallet"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Store Balance</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">$4,231.50</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="fa-solid fa-box-open"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Active Products</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">142</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef9c3; color: #ca8a04;"><i class="fa-solid fa-star"></i></div>
                <div>
                    <h4 style="color:var(--text-muted); font-size:0.9rem; margin-bottom:0.25rem; font-weight:600;">Store Rating</h4>
                    <div style="font-size:1.5rem; font-weight:800; color:var(--text);">4.9/5</div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Latest Orders</h3>
                <a href="#" style="color:var(--primary); font-weight:600; font-size:0.9rem;">View All</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong style="color:var(--text);">#ORD-8821</strong></td>
                        <td>Gaming Keyboard RGB</td>
                        <td style="color:var(--text-muted);">Today, 09:12 AM</td>
                        <td style="font-weight:700;">$89.99</td>
                        <td><span class="badge" style="background:#fef9c3; color:#ca8a04;">Pending Shipping</span></td>
                    </tr>
                    <tr>
                        <td><strong style="color:var(--text);">#ORD-8810</strong></td>
                        <td>Wireless Mouse</td>
                        <td style="color:var(--text-muted);">Yesterday, 02:40 PM</td>
                        <td style="font-weight:700;">$45.00</td>
                        <td><span class="badge" style="background:#dcfce7; color:#16a34a;">Shipped</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
