<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | Vendo</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 & FontAwesome 6 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* SaaS Admin Theme Tokens */
            --admin-bg: #f8fafc;
            --admin-surface: #ffffff;
            --admin-sidebar-bg: #0f172a;
            --admin-sidebar-text: #94a3b8;
            --admin-sidebar-hover: #1e293b;
            --admin-sidebar-active: #38bdf8;
            --admin-primary: #3b82f6;
            --admin-primary-hover: #2563eb;
            --admin-text-main: #1e293b;
            --admin-text-sub: #64748b;
            --admin-border: #e2e8f0;
            --admin-radius-sm: 6px;
            --admin-radius: 10px;
            --admin-radius-lg: 16px;
            --admin-shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --admin-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.03);
            --sidebar-width: 260px;
            --header-height: 70px;
            --font-base: 'Inter', sans-serif;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: var(--font-base); background: var(--admin-bg);
            color: var(--admin-text-main); font-size: .875rem;
            margin: 0; padding: 0; overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: var(--sidebar-width); height: 100vh;
            background: var(--admin-sidebar-bg);
            position: fixed; left: 0; top: 0; z-index: 1000;
            display: flex; flex-direction: column;
            transition: transform 0.3s ease;
        }
        
        .sidebar-brand {
            height: var(--header-height); display: flex; align-items: center;
            padding: 0 1.5rem; font-size: 1.5rem; font-weight: 800;
            color: #fff; text-decoration: none; letter-spacing: -0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand span { color: var(--admin-sidebar-active); }
        .sidebar-brand:hover { color: #fff; }

        .sidebar-menu {
            flex: 1; overflow-y: auto; padding: 1.5rem 1rem;
            display: flex; flex-direction: column; gap: 0.25rem;
        }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        /* Navigation Links */
        .sidebar-label {
            font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: rgba(148,163,184,0.6);
            margin: 1rem 0 0.5rem 0.75rem;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: 0.85rem;
            padding: 0.65rem 0.85rem; border-radius: var(--admin-radius-sm);
            color: var(--admin-sidebar-text); text-decoration: none;
            font-weight: 500; font-size: 0.9rem; transition: var(--transition);
        }
        .sidebar-link i.icon { width: 20px; text-align: center; font-size: 1.1rem; }
        .sidebar-link .badge { margin-left: auto; }
        
        .sidebar-link:hover {
            background: var(--admin-sidebar-hover); color: #fff;
        }
        .sidebar-link.active {
            background: var(--admin-sidebar-hover); color: var(--admin-sidebar-active);
            position: relative; font-weight: 600;
        }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: -1rem; top: 50%;
            transform: translateY(-50%); height: 60%; width: 4px;
            background: var(--admin-sidebar-active); border-radius: 0 4px 4px 0;
        }

        /* ── Main Wrapper ── */
        .admin-main {
            margin-left: var(--sidebar-width); min-height: 100vh;
            display: flex; flex-direction: column; transition: margin 0.3s ease;
        }

        /* ── Top Header ── */
        .admin-header {
            height: var(--header-height); background: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; position: sticky; top: 0; z-index: 999;
        }

        .header-left { display: flex; align-items: center; gap: 1.5rem; }
        .mobile-toggle {
            display: none; background: none; border: none; font-size: 1.25rem;
            color: var(--admin-text-sub); cursor: pointer; padding: 0.5rem;
            border-radius: var(--admin-radius-sm); transition: var(--transition);
        }
        .mobile-toggle:hover { background: var(--admin-bg); color: var(--admin-text-main); }
        
        .header-search { position: relative; width: 300px; display: none; }
        @media (min-width: 768px) { .header-search { display: block; } }
        .header-search i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--admin-text-sub); }
        .header-search input {
            width: 100%; padding: 0.55rem 1rem 0.55rem 2.5rem;
            border: 1px solid var(--admin-border); border-radius: 50px;
            font-size: 0.85rem; background: var(--admin-bg); transition: var(--transition);
        }
        .header-search input:focus { outline: none; border-color: var(--admin-primary); background: #fff; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

        .header-right { display: flex; align-items: center; gap: 1rem; }
        
        /* Action Buttons */
        .header-btn {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid transparent; background: transparent;
            color: var(--admin-text-sub); font-size: 1.1rem;
            cursor: pointer; position: relative; transition: var(--transition);
        }
        .header-btn:hover { background: var(--admin-bg); color: var(--admin-text-main); border-color: var(--admin-border); }
        .header-btn .badge-dot {
            position: absolute; top: 8px; right: 8px; width: 8px; height: 8px;
            background: #ef4444; border-radius: 50%; border: 2px solid #fff;
        }

        /* Profile Dropdown */
        .profile-trigger {
            display: flex; align-items: center; gap: 0.75rem; cursor: pointer;
            padding: 0.35rem 0.5rem 0.35rem 0.35rem; border-radius: 50px;
            border: 1px solid transparent; transition: var(--transition);
        }
        .profile-trigger:hover { background: var(--admin-bg); border-color: var(--admin-border); }
        .profile-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--admin-primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem; box-shadow: 0 2px 5px rgba(59,130,246,0.3);
        }
        .profile-info { display: none; flex-direction: column; }
        @media (min-width: 576px) { .profile-info { display: flex; } }
        .p-name { font-weight: 600; color: var(--admin-text-main); font-size: 0.85rem; line-height: 1.2; }
        .p-role { font-size: 0.75rem; color: var(--admin-text-sub); }

        /* ── Content Area ── */
        .admin-content { padding: 2rem; flex: 1; }
        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--admin-text-main); margin: 0; letter-spacing: -0.3px; }
        .page-desc { font-size: 0.875rem; color: var(--admin-text-sub); margin: 0.25rem 0 0; }

        /* ── Utility Classes for Views ── */
        .saas-card {
            background: var(--admin-surface); border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius); box-shadow: var(--admin-shadow-sm);
            padding: 1.5rem; overflow: hidden;
        }
        .table-responsive { border: 1px solid var(--admin-border); border-radius: var(--admin-radius-sm); }
        .saas-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; }
        .saas-table th {
            background: var(--admin-bg); padding: 1rem 1.25rem; font-size: 0.75rem;
            text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;
            color: var(--admin-text-sub); border-bottom: 1px solid var(--admin-border);
            text-align: left; white-space: nowrap;
        }
        .saas-table td {
            padding: 1rem 1.25rem; border-bottom: 1px solid var(--admin-border);
            vertical-align: middle; font-size: 0.875rem; color: var(--admin-text-main);
        }
        .saas-table tr:last-child td { border-bottom: none; }
        .saas-table tbody tr:hover { background: #fdfdfd; }

        /* Pills & Badges */
        .status-pill {
            display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.25rem 0.75rem;
            border-radius: 50px; font-size: 0.75rem; font-weight: 600; border: 1px solid transparent;
        }
        .status-success { background: #f0fdf4; color: #16a34a; border-color: #dcfce7; }
        .status-warning { background: #fffbeb; color: #d97706; border-color: #fef3c7; }
        .status-danger  { background: #fef2f2; color: #dc2626; border-color: #fee2e2; }
        .status-info    { background: #eff6ff; color: #3b82f6; border-color: #dbeafe; }

        /* Actions */
        .action-btn {
            background: none; border: none; color: var(--admin-text-sub);
            padding: 0.4rem; border-radius: 4px; transition: var(--transition); cursor: pointer;
        }
        .action-btn:hover { background: var(--admin-bg); color: var(--admin-primary); }
        .action-btn.delete:hover { color: #dc2626; background: #fef2f2; }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .admin-main { margin-left: 0; }
            .mobile-toggle { display: block; }
            
            /* Sidebar Overlay */
            .sidebar-overlay {
                display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.4);
                backdrop-filter: blur(2px); z-index: 999;
            }
            .sidebar-overlay.show { display: block; }
            .admin-header { padding: 0 1rem; }
            .admin-content { padding: 1.5rem 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- ── GLOBAL AUTH GUARD ── --}}
    {{-- Runs before any paint; redirects to login if no admin token found --}}
    <script>
    (function () {
        var token = localStorage.getItem('admin_token');
        if (!token) { window.location.replace('/admin/login'); }
    })();
    </script>

    {{-- SIDEBAR OVERLAY --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar" id="sidebar">
        <a href="{{ url('/admin/dashboard') }}" class="sidebar-brand">
            Vendo<span>.</span>
        </a>

        <div class="sidebar-menu">
            <span class="sidebar-label">Main</span>
            <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie icon"></i> Dashboard
            </a>

            <span class="sidebar-label">E-Commerce</span>
            <a href="{{ url('/admin/orders') }}" class="sidebar-link {{ request()->is('admin/orders') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping icon"></i> Orders
                <span class="badge bg-danger rounded-pill">12</span>
            </a>
            <a href="{{ url('/admin/products') }}" class="sidebar-link {{ request()->is('admin/products') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open icon"></i> Products
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-tags icon"></i> Categories
            </a>

            <span class="sidebar-label">Network</span>
            <a href="{{ url('/admin/vendors') }}" class="sidebar-link {{ request()->is('admin/vendors') ? 'active' : '' }}">
                <i class="fa-solid fa-store icon"></i> Vendors
            </a>
            <a href="{{ url('/admin/users') }}" class="sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="fa-solid fa-users icon"></i> Customers
            </a>

            <span class="sidebar-label">Settings</span>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-sliders icon"></i> Store Setup
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-paint-roller icon"></i> Appearance
            </a>

            <span class="sidebar-label">Page Management</span>
            <a href="{{ route('admin.pages.home') }}" class="sidebar-link {{ request()->is('admin/pages/home') ? 'active' : '' }}">
                <i class="fa-solid fa-house icon"></i> Home Page
            </a>
            <a href="{{ route('admin.pages.shop') }}" class="sidebar-link {{ request()->is('admin/pages/shop') ? 'active' : '' }}">
                <i class="fa-solid fa-store icon"></i> Shop Page
            </a>
            <a href="{{ route('admin.pages.vendor') }}" class="sidebar-link {{ request()->is('admin/pages/vendor') ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie icon"></i> Vendor Page
            </a>
            <a href="{{ route('admin.pages.seller') }}" class="sidebar-link {{ request()->is('admin/pages/seller') ? 'active' : '' }}">
                <i class="fa-solid fa-handshake icon"></i> Become a Seller
            </a>
            <a href="{{ route('admin.pages.blog') }}" class="sidebar-link {{ request()->is('admin/pages/blog') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper icon"></i> Blog Page
            </a>
            <a href="{{ route('admin.pages.contact') }}" class="sidebar-link {{ request()->is('admin/pages/contact') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope icon"></i> Contact Page
            </a>
            <a href="{{ route('admin.pages.auth') }}" class="sidebar-link {{ request()->is('admin/pages/auth') ? 'active' : '' }}">
                <i class="fa-solid fa-lock icon"></i> Auth Pages
            </a>
        </div>

        {{-- Bottom Logout --}}
        <div style="padding: 1rem; border-top: 1px solid rgba(255,255,255,0.08);">
            <a href="{{ url('/') }}" class="sidebar-link text-muted" style="color:#64748b !important;">
                <i class="fa-solid fa-arrow-right-from-bracket icon"></i> Visit Store
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT WRAPPER --}}
    <main class="admin-main">
        
        {{-- HEADER --}}
        <header class="admin-header">
            <div class="header-left">
                <button class="mobile-toggle" id="mobileToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="header-search">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search orders, products, users...">
                </div>
            </div>

            <div class="header-right">
                <button class="header-btn" title="View Store">
                    <i class="fa-brands fa-chrome"></i>
                </button>
                <div class="dropdown">
                    <button class="header-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-bell"></i>
                        <span class="badge-dot"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="width: 300px;">
                        <li><h6 class="dropdown-header text-uppercase fw-bold">Notifications</h6></li>
                        <li><a class="dropdown-item py-2 border-bottom" href="#">
                            <div class="d-flex gap-2">
                                <i class="fa-solid fa-cart-shopping text-primary mt-1"></i>
                                <div>
                                    <span class="d-block fw-semibold" style="font-size:.85rem;">New Order #9021</span>
                                    <span class="text-muted" style="font-size:.75rem;">Just now</span>
                                </div>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item py-2 text-center text-primary fw-600" href="#" style="font-size:.8rem;">View All</a></li>
                    </ul>
                </div>

                <div class="dropdown ms-2">
                    <button type="button" class="profile-trigger bg-transparent" style="cursor:pointer; outline:none;" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-info text-end">
                            <span class="p-name" id="adminName">Admin</span>
                            <span class="p-role">Administrator</span>
                        </div>
                        <div class="profile-avatar" id="adminInitials">A</div>
                        <i class="fa-solid fa-chevron-down text-muted ms-1 fs-xs"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user me-2 text-muted"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2 text-muted"></i> Settings</a></li>
                        <li><hr class="dropdown-divider border-light"></li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" id="logoutBtn">
                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="admin-content">
            @yield('content')
        </div>

    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ── Sidebar Toggle ──────────────────────────────────────────────
        const toggleBtn = document.getElementById('mobileToggle');
        const sidebar   = document.getElementById('sidebar');
        const overlay   = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }
        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // ── Active sidebar link ─────────────────────────────────────────
        document.querySelectorAll('.sidebar-link').forEach(link => {
            if (window.location.href.includes(link.getAttribute('href'))) {
                document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });

        // ── Populate admin profile from localStorage ────────────────────
        (function () {
            try {
                const user = JSON.parse(localStorage.getItem('admin_user') || '{}');
                if (user.name) {
                    document.getElementById('adminName').textContent = user.name;
                    const initials = user.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
                    document.getElementById('adminInitials').textContent = initials;
                }
            } catch (e) { /* silently fail */ }
        })();

        // ── Logout ─────────────────────────────────────────────────────
        document.getElementById('logoutBtn').addEventListener('click', async function () {
            const token = localStorage.getItem('admin_token');
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Logging out...';
            try {
                if (token) {
                    await fetch('/api/logout', {
                        method:  'POST',
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                    });
                }
            } catch (e) { /* still clear local state even on network error */ }
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            window.location.replace('/admin/login');
        });
    </script>
    @stack('scripts')
</body>
</html>
