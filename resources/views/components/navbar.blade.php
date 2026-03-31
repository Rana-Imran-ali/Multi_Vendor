{{--
    ================================================================
    COMPONENT: components/navbar.blade.php
    A sticky, responsive, production-quality navbar for Vendo.
    ================================================================
--}}

{{-- ===== SEARCH OVERLAY ===== --}}
<div class="search-overlay" id="searchOverlay">
    <div class="container-xl">
        <form action="{{ url('/shop') }}" method="GET" class="search-overlay-form">
            <div class="search-overlay-inner">
                <i class="fa fa-magnifying-glass text-muted me-3 fs-5"></i>
                <input
                    type="text"
                    name="q"
                    id="overlaySearchInput"
                    class="search-overlay-input"
                    placeholder="Search for products, brands, vendors…"
                    autocomplete="off"
                >
                <button type="button" class="search-overlay-close" onclick="closeSearch()">
                    <i class="fa fa-xmark fs-5"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MAIN NAVBAR ===== --}}
<nav id="mainNavbar" class="navbar navbar-expand-xl navbar-light vendo-navbar sticky-top">
    <div class="container-xl">

        {{-- ── LOGO ── --}}
        <a class="navbar-brand vendo-logo" href="{{ url('/') }}">
            <span class="logo-icon">
                <i class="fa fa-bag-shopping"></i>
            </span>
            <span class="logo-text">Vendo</span>
        </a>

        {{-- ── MOBILE: Cart + Toggler ── --}}
        <div class="d-flex d-xl-none align-items-center gap-2 ms-auto">
            <a href="{{ url('/cart') }}" class="nav-icon-btn position-relative">
                <i class="fa fa-bag-shopping fs-5"></i>
                <span class="cart-badge">3</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#vendoNavMenu"
                    aria-controls="vendoNavMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        {{-- ── NAV MENU ── --}}
        <div class="collapse navbar-collapse" id="vendoNavMenu">

            {{-- ── SEARCH BAR (center) ── --}}
            <div class="nav-search-wrap mx-auto d-none d-xl-flex">
                <div class="nav-search-box" onclick="openSearch()">
                    <i class="fa fa-magnifying-glass text-muted me-2"></i>
                    <span class="nav-search-placeholder">Search products, brands…</span>
                    <span class="nav-search-shortcut d-none d-xxl-inline">⌘K</span>
                </div>
            </div>

            {{-- ── NAV LINKS ── --}}
            <ul class="navbar-nav vendo-nav-links align-items-xl-center gap-xl-1 ms-xl-3">

                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        Home
                    </a>
                </li>

                {{-- Shop --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ url('/shop') }}">
                        Shop
                    </a>
                </li>

                {{-- Categories Mega Dropdown --}}
                <li class="nav-item vendo-mega-parent dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('categories*') ? 'active' : '' }}"
                       href="{{ url('/categories') }}"
                       id="megaDropToggle"
                       role="button">
                        Categories
                    </a>

                    <div class="vendo-mega-menu" aria-labelledby="megaDropToggle">
                        <div class="mega-inner container-xl">
                            <div class="row g-4">

                                <div class="col-6 col-md-3">
                                    <p class="mega-heading">Fashion</p>
                                    <ul class="mega-list">
                                        <li><a href="{{ url('/categories/mens-clothing') }}">Men's Clothing</a></li>
                                        <li><a href="{{ url('/categories/womens-clothing') }}">Women's Clothing</a></li>
                                        <li><a href="{{ url('/categories/kids-fashion') }}">Kids' Fashion</a></li>
                                        <li><a href="{{ url('/categories/footwear') }}">Footwear</a></li>
                                        <li><a href="{{ url('/categories/accessories') }}">Accessories</a></li>
                                    </ul>
                                </div>

                                <div class="col-6 col-md-3">
                                    <p class="mega-heading">Electronics</p>
                                    <ul class="mega-list">
                                        <li><a href="{{ url('/categories/mobiles') }}">Mobiles & Tablets</a></li>
                                        <li><a href="{{ url('/categories/laptops') }}">Laptops & Computers</a></li>
                                        <li><a href="{{ url('/categories/audio') }}">Audio & Headphones</a></li>
                                        <li><a href="{{ url('/categories/cameras') }}">Cameras</a></li>
                                        <li><a href="{{ url('/categories/gaming') }}">Gaming</a></li>
                                    </ul>
                                </div>

                                <div class="col-6 col-md-3">
                                    <p class="mega-heading">Home & Living</p>
                                    <ul class="mega-list">
                                        <li><a href="{{ url('/categories/furniture') }}">Furniture</a></li>
                                        <li><a href="{{ url('/categories/kitchen') }}">Kitchen & Dining</a></li>
                                        <li><a href="{{ url('/categories/bedding') }}">Bedding & Bath</a></li>
                                        <li><a href="{{ url('/categories/decor') }}">Home Décor</a></li>
                                        <li><a href="{{ url('/categories/appliances') }}">Appliances</a></li>
                                    </ul>
                                </div>

                                <div class="col-6 col-md-3">
                                    <p class="mega-heading">More</p>
                                    <ul class="mega-list">
                                        <li><a href="{{ url('/categories/beauty') }}">Beauty & Health</a></li>
                                        <li><a href="{{ url('/categories/sports') }}">Sports & Outdoors</a></li>
                                        <li><a href="{{ url('/categories/automotive') }}">Automotive</a></li>
                                        <li><a href="{{ url('/categories/books') }}">Books & Stationery</a></li>
                                        <li><a href="{{ url('/categories') }}" class="text-brand fw-600">View All <i class="fa fa-arrow-right ms-1 fs-xs"></i></a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>

                {{-- Vendors --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('vendors*') ? 'active' : '' }}" href="{{ url('/vendors') }}">
                        Vendors
                    </a>
                </li>

                {{-- Deals --}}
                <li class="nav-item">
                    <a class="nav-link deals-link {{ request()->is('deals*') ? 'active' : '' }}" href="{{ url('/deals') }}">
                        <span class="deals-badge">HOT</span>
                        Deals
                    </a>
                </li>

                {{-- Blog --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('/blog') }}">
                        Blog
                    </a>
                </li>

                {{-- About --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ url('/about') }}">
                        About
                    </a>
                </li>
            </ul>

            {{-- ── RIGHT ACTION GROUP ── --}}
            <div class="vendo-nav-actions d-flex align-items-center gap-2 ms-xl-3">

                {{-- Mobile search trigger --}}
                <button class="nav-icon-btn d-xl-none" onclick="openSearch()" title="Search">
                    <i class="fa fa-magnifying-glass fs-5"></i>
                </button>

                {{-- Wishlist --}}
                <a href="{{ url('/wishlist') }}" class="nav-icon-btn d-none d-xl-flex position-relative" title="Wishlist">
                    <i class="fa-regular fa-heart fs-5"></i>
                    <span class="cart-badge">5</span>
                </a>

                {{-- Cart --}}
                <a href="{{ url('/cart') }}" class="nav-icon-btn d-none d-xl-flex position-relative" title="Cart">
                    <i class="fa fa-bag-shopping fs-5"></i>
                    <span class="cart-badge">3</span>
                </a>

                {{-- Auth Buttons (Handled by JS) --}}
                
                {{-- Authenticated User Dropdown --}}
                    <button class="btn dropdown-toggle d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" 
                            style="background-color: #f25019; color: white; border-radius: 50px; padding: 0.25rem 0.85rem 0.25rem 0.25rem; border: none; transition: all 0.2s;">
                        <span id="nav-user-initial" style="background-color: rgba(255,255,255,0.25); color: white; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; margin-right: 0.5rem; font-size: 0.9rem;">U</span>
                        <span class="fw-bold text-uppercase" id="nav-user-name" style="letter-spacing: 0.5px; font-size: 0.85rem;">User</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown shadow border-0" style="padding: 0.5rem 0; min-width: 240px; border-radius: 8px;">
                        <li>
                            <div class="user-dropdown-header" style="padding: 1rem 1.25rem;">
                                <strong id="nav-user-full-name" style="font-size: 1rem; color: #333;">User</strong>
                                <small class="text-muted d-block" id="nav-user-email" style="font-size: 0.85rem;">email</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.dashboard') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-solid fa-palette fa-fw me-2" style="color: #6c757d;"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-solid fa-user fa-fw me-2" style="color: #6c757d;"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.orders') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-solid fa-box fa-fw me-2" style="color: #6c757d;"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('wishlist') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-regular fa-heart fa-fw me-2" style="color: #6c757d;"></i> Wishlist
                            </a>
                        </li>
                        
                        <li id="nav-vendor-link" style="display: none;">
                            <a class="dropdown-item" href="{{ url('/vendor/dashboard') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-solid fa-store fa-fw me-2" style="color: #6c757d;"></i> Vendor Dashboard
                            </a>
                        </li>
                        <li id="nav-admin-link" style="display: none;">
                            <a class="dropdown-item" href="{{ url('/admin/dashboard') }}" style="padding: 0.6rem 1.25rem;">
                                <i class="fa-solid fa-shield-halved fa-fw me-2" style="color: #6c757d;"></i> Admin Panel
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <button type="button" class="dropdown-item" onclick="handleLogout()" style="padding: 0.6rem 1.25rem; color: #dc3545;">
                                <i class="fa-solid fa-arrow-right-from-bracket fa-fw me-2" style="color: #dc3545;"></i> Sign Out
                            </button>
                        </li>
                    </ul>
                </div>

                {{-- Guest Buttons --}}
                <div id="guest-menu-container" style="display: none; gap: .5rem; align-items:center;">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-brand d-none d-xl-inline-flex">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-brand d-none d-xl-inline-flex">
                        Register
                    </a>
                    {{-- Mobile: single combined link --}}
                    <a href="{{ route('login') }}" class="nav-icon-btn d-xl-none">
                        <i class="fa-regular fa-user fs-5"></i>
                    </a>
                </div>

            </div>{{-- /.vendo-nav-actions --}}
        </div>{{-- /#vendoNavMenu --}}
    </div>{{-- /.container-xl --}}
</nav>

{{-- ===== NAVBAR CSS ===== --}}
<style>
    /* ── Navbar shell ── */
    .vendo-navbar {
        background: #fff;
        border-bottom: 1px solid var(--border-light);
        padding-top: .55rem;
        padding-bottom: .55rem;
        transition: box-shadow .25s ease, padding .25s ease;
        z-index: 1040;
    }
    .vendo-navbar.navbar-scrolled {
        box-shadow: var(--shadow-md);
        padding-top: .4rem;
        padding-bottom: .4rem;
    }

    /* ── Logo ── */
    .vendo-logo {
        display: flex;
        align-items: center;
        gap: .45rem;
        text-decoration: none;
    }
    .logo-icon {
        width: 36px;
        height: 36px;
        background: var(--brand-primary);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .logo-text {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -.5px;
    }
    .vendo-logo:hover .logo-text { color: var(--brand-primary); }
    .vendo-logo:hover .logo-icon { background: var(--brand-dark); }

    /* ── Search box (trigger) ── */
    .nav-search-wrap { width: 100%; max-width: 420px; }
    .nav-search-box {
        display: flex;
        align-items: center;
        background: #f5f6f8;
        border: 1.5px solid var(--border-light);
        border-radius: 50px;
        padding: .45rem 1rem;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
    }
    .nav-search-box:hover {
        border-color: var(--brand-primary);
        background: #fff;
    }
    .nav-search-placeholder {
        flex: 1;
        font-size: .875rem;
        color: var(--text-muted);
    }
    .nav-search-shortcut {
        font-size: .72rem;
        background: #e8eaed;
        padding: .1rem .45rem;
        border-radius: 4px;
        color: var(--text-muted);
    }

    /* ── Nav links ── */
    .vendo-nav-links .nav-link {
        font-size: .875rem;
        font-weight: 500;
        color: var(--text-primary);
        padding: .45rem .7rem;
        border-radius: var(--radius-sm);
        position: relative;
        transition: var(--transition);
    }
    .vendo-nav-links .nav-link:hover,
    .vendo-nav-links .nav-link.active {
        color: var(--brand-primary);
        background: var(--brand-light);
    }
    .vendo-nav-links .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: var(--brand-primary);
        border-radius: 4px;
    }

    /* Deals badge */
    .deals-link .deals-badge {
        display: inline-block;
        background: var(--brand-primary);
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 1px 5px;
        border-radius: 4px;
        vertical-align: middle;
        margin-right: 3px;
        line-height: 1.6;
    }

    /* Mega dropdown parent */
    .vendo-mega-parent { position: static; }
    .vendo-mega-parent > .nav-link::after {
        display: inline-block;
        content: '';
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 5px solid currentColor;
        margin-left: .45rem;
        vertical-align: .15em;
        transition: transform .2s ease;
    }
    .vendo-mega-parent:hover > .nav-link::after { transform: rotate(180deg); }

    /* Mega dropdown panel */
    .vendo-mega-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        width: 100%;
        background: #fff;
        border-top: 2px solid var(--brand-primary);
        border-bottom: 1px solid var(--border-light);
        box-shadow: var(--shadow-lg);
        z-index: 1050;
        animation: megaFadeIn .2s ease;
    }
    .vendo-mega-parent:hover .vendo-mega-menu { display: block; }
    .mega-inner { padding: 1.75rem 0; }
    .mega-heading {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text-muted);
        margin-bottom: .75rem;
    }
    .mega-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .mega-list li { margin-bottom: .35rem; }
    .mega-list a {
        font-size: .875rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        padding: .22rem 0;
        transition: color .18s ease;
    }
    .mega-list a:hover { color: var(--brand-primary); }
    .text-brand { color: var(--brand-primary) !important; }
    .fw-600 { font-weight: 600; }
    .fs-xs { font-size: .7rem; }

    @keyframes megaFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Icon buttons ── */
    .nav-icon-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--text-primary);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        flex-shrink: 0;
    }
    .nav-icon-btn:hover {
        background: var(--brand-light);
        color: var(--brand-primary);
    }

    /* Cart badge */
    .cart-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: var(--brand-primary);
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        border: 1.5px solid #fff;
    }

    /* ── User avatar button ── */
    .vendo-user-btn {
        display: flex;
        align-items: center;
        background: var(--brand-light);
        border: 1.5px solid #f5cfc4;
        color: var(--brand-primary);
        border-radius: 50px;
        padding: .3rem .7rem;
        font-weight: 600;
        font-size: .85rem;
        transition: var(--transition);
    }
    .vendo-user-btn:hover, .vendo-user-btn:focus {
        background: var(--brand-primary);
        color: #fff;
        border-color: var(--brand-primary);
    }
    .user-avatar {
        width: 26px;
        height: 26px;
        background: var(--brand-primary);
        color: #fff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .vendo-user-btn:hover .user-avatar,
    .vendo-user-btn:focus .user-avatar {
        background: rgba(255,255,255,.25);
    }

    /* ── User dropdown ── */
    .user-dropdown {
        min-width: 220px;
        border-radius: var(--radius-md) !important;
        padding: .25rem .25rem;
        margin-top: .5rem !important;
        border: 1px solid var(--border-light) !important;
    }
    .user-dropdown-header {
        padding: .75rem 1rem;
    }
    .user-dropdown .dropdown-item {
        font-size: .875rem;
        border-radius: var(--radius-sm);
        padding: .5rem .85rem;
        color: var(--text-primary);
        transition: background .15s ease;
    }
    .user-dropdown .dropdown-item:hover {
        background: var(--brand-light);
        color: var(--brand-primary);
    }
    .user-dropdown .dropdown-item.text-danger:hover {
        background: #fff0f0;
    }

    /* ── Search Overlay ── */
    .search-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.6);
        backdrop-filter: blur(4px);
        z-index: 2000;
        display: none;
        align-items: flex-start;
        padding-top: 60px;
    }
    .search-overlay.active {
        display: flex;
    }
    .search-overlay-form { width: 100%; }
    .search-overlay-inner {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow-lg);
        animation: overlaySlideDown .2s ease;
    }
    @keyframes overlaySlideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to   { transform: translateY(0);     opacity: 1; }
    }
    .search-overlay-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1.1rem;
        font-family: var(--font-base);
        color: var(--text-primary);
        background: transparent;
    }
    .search-overlay-close {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0 .25rem;
        transition: color .15s;
    }
    .search-overlay-close:hover { color: var(--text-primary); }

    /* ── Mobile nav tweaks ── */
    @media (max-width: 1199.98px) {
        .vendo-mega-menu {
            position: static;
            border: none;
            border-left: 3px solid var(--brand-light);
            box-shadow: none;
            display: none;
            animation: none;
            padding: .5rem 0 .5rem .75rem;
        }
        .vendo-mega-parent:hover .vendo-mega-menu { display: none; }
        .vendo-mega-parent.open .vendo-mega-menu { display: block; }
        .mega-inner { padding: .75rem 0; }
        .vendo-nav-links .nav-link { padding: .6rem .5rem; }
        .vendo-nav-links .nav-link.active::after { display: none; }
        .vendo-nav-actions {
            padding: .75rem 0;
            border-top: 1px solid var(--border-light);
            margin-top: .5rem;
            flex-wrap: wrap;
        }
        .vendo-nav-actions a,
        .vendo-nav-actions button { width: 100%; justify-content: center; }
        #vendoNavMenu { padding: .5rem 0; }
    }
</style>

{{-- ===== NAVBAR JS ===== --}}
<script>
    // Search overlay
    function openSearch() {
        document.getElementById('searchOverlay').classList.add('active');
        setTimeout(() => document.getElementById('overlaySearchInput').focus(), 50);
        document.body.style.overflow = 'hidden';
    }
    function closeSearch() {
        document.getElementById('searchOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.getElementById('searchOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeSearch();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSearch();
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
    });

    // Mobile: toggle mega dropdown on click
    document.querySelectorAll('.vendo-mega-parent > .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth < 1200) {
                e.preventDefault();
                this.closest('.vendo-mega-parent').classList.toggle('open');
            }
        });
    });

    // ── AUTH RENDERING SCRIPT ──
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.Auth === 'undefined') return;

        const authMenu = document.getElementById('auth-menu-container');
        const guestMenu = document.getElementById('guest-menu-container');

        if (window.Auth.check()) {
            const user = window.Auth.getUser();
            
            // Show Auth Menu, Hide Guest Menu
            authMenu.style.display = 'inline-block';
            guestMenu.style.display = 'none';
            
            // Update User Labels
            document.getElementById('nav-user-initial').textContent = user.name.charAt(0).toUpperCase();
            document.getElementById('nav-user-name').textContent = user.name.split(' ')[0];
            document.getElementById('nav-user-full-name').textContent = user.name;
            document.getElementById('nav-user-email').textContent = user.email;
            
            // Show role-based links
            if (user.role === 'vendor') {
                document.getElementById('nav-vendor-link').style.display = 'block';
            }
            if (user.role === 'admin') {
                document.getElementById('nav-admin-link').style.display = 'block';
            }
        } else {
            // Show Guest Menu, Hide Auth Menu
            guestMenu.style.display = 'flex';
            authMenu.style.display = 'none';
        }
    });

    // API Logout Handler
    async function handleLogout() {
        if (typeof window.Auth !== 'undefined') {
            await window.Auth.logout();
            window.location.href = '/login';
        }
    }
</script>
