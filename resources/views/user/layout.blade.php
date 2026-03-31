@extends('layouts.app')

@section('title', 'My Dashboard — Vendo')

@push('styles')
<style>
    /* User Dashboard specific styles */
    .user-sidebar {
        background: #fff;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        padding: 1.5rem 0;
        box-shadow: var(--shadow-sm);
    }
    .user-greeting {
        padding: 0 1.5rem 1.5rem;
        border-bottom: 1px solid var(--border-light);
        margin-bottom: 1rem;
        text-align: center;
    }
    .user-avatar-lg {
        width: 60px;
        height: 60px;
        background: var(--brand-primary);
        color: #fff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: .5rem;
    }
    .user-nav-link {
        display: flex;
        align-items: center;
        padding: .75rem 1.5rem;
        color: var(--text-secondary);
        font-weight: 500;
        transition: var(--transition);
        border-left: 3px solid transparent;
    }
    .user-nav-link i {
        width: 24px;
        font-size: 1.1rem;
        color: var(--text-muted);
        transition: var(--transition);
    }
    .user-nav-link:hover, .user-nav-link.active {
        background: var(--brand-light);
        color: var(--brand-primary);
        border-left-color: var(--brand-primary);
    }
    .user-nav-link:hover i, .user-nav-link.active i {
        color: var(--brand-primary);
    }
    
    .dashboard-card {
        background: #fff;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        padding: 1.5rem;
        height: 100%;
    }
    .dashboard-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // ── CLIENT-SIDE AUTH GUARD ──
    // Because the view routes are unprotected natively by Blade, we guard them via JS
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.Auth === 'undefined' || !window.Auth.check()) {
            // Redirect to login before the page is fully interacted with
            window.location.href = '/login';
        } else {
            // Safe to render user details
            const user = window.Auth.getUser();
            document.getElementById('sidebar-user-name').textContent = user.name;
            document.getElementById('sidebar-user-initial').textContent = user.name.charAt(0).toUpperCase();
            document.body.style.display = 'block'; // Unhide after verification if we applied body{display:none} 
        }
    });

    async function sidebarLogout() {
        if(window.Auth) {
            await window.Auth.logout();
            window.location.href = '/login';
        }
    }
</script>
@endpush

@section('content')
<section class="py-5" style="background: #f7f8fa; min-height: calc(100vh - 80px);">
    <div class="container-xl">
        <div class="row g-4">
            
            {{-- ── SIDEBAR ── --}}
            <div class="col-12 col-lg-3">
                <aside class="user-sidebar sticky-lg-top" style="top: 100px;">
                    <div class="user-greeting">
                        <div class="user-avatar-lg" id="sidebar-user-initial">U</div>
                        <h5 class="mb-0 fw-bold" id="sidebar-user-name">User...</h5>
                        <p class="text-muted fs-xs mb-0">Member</p>
                    </div>

                    <nav>
                        <a href="{{ route('user.dashboard') }}" class="user-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="fa fa-gauge"></i> Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="user-nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <i class="fa fa-user"></i> My Profile
                        </a>
                        <a href="{{ route('user.orders') }}" class="user-nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                            <i class="fa fa-box-open"></i> My Orders
                        </a>
                        <a href="{{ url('/wishlist') }}" class="user-nav-link text-muted">
                            <i class="fa-regular fa-heart"></i> Wishlist
                        </a>
                        <button type="button" class="user-nav-link border-0 bg-transparent w-100 text-start text-danger mt-3" onclick="sidebarLogout()">
                            <i class="fa fa-right-from-bracket text-danger"></i> Sign Out
                        </button>
                    </nav>
                </aside>
            </div>

            {{-- ── CONTENT AREA ── --}}
            <div class="col-12 col-lg-9">
                @yield('user_content')
            </div>

        </div>
    </div>
</section>
@endsection
