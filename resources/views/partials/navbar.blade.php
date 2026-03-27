<!-- NAVBAR -->
<nav class="navbar">
    <div class="container nav-container">
        <a href="{{ url('/') }}" class="logo">
            <i class="fa-solid fa-store"></i> <span>Vendo</span>
        </a>

        <!-- Search Bar (Desktop) -->
        <div class="nav-search desktop-only">
            <select class="search-category" style="border:none; background:transparent; font-weight:600; font-size:0.85rem; padding-right:0.5rem; border-right:1px solid var(--border); margin-right:0.5rem; color:var(--text); outline:none; cursor:pointer;">
                <option value="all">All</option>
                <option value="product">Products</option>
                <option value="category">Categories</option>
                <option value="vendor">Vendors</option>
            </select>
            <input type="text" placeholder="Smart search...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li class="dropdown">
                <a href="{{ url('/shop') }}" class="nav-link dropdown-toggle {{ request()->is('shop*') ? 'active' : '' }}">
                    Shop <i class="fa-solid fa-chevron-down fa-xs mt-1"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/shop') }}" class="dropdown-item"><i class="fa-solid fa-box-open fa-fw"></i> All Products</a></li>
                    <li><a href="{{ url('/shop') }}" class="dropdown-item"><i class="fa-solid fa-layer-group fa-fw"></i> Categories</a></li>
                    <li><a href="{{ url('/shop') }}" class="dropdown-item"><i class="fa-solid fa-bolt fa-fw" style="color:var(--accent)"></i> Hot Deals</a></li>
                </ul>
            </li>
            
            <!-- Mega Menu -->
            <li class="dropdown mega-dropdown">
                <a href="#" class="nav-link dropdown-toggle">
                    Categories <i class="fa-solid fa-chevron-down fa-xs mt-1"></i>
                </a>
                <div class="dropdown-menu mega-menu">
                    <div class="mega-menu-grid">
                        <div class="mega-col">
                            <h5><i class="fa-solid fa-laptop"></i> Electronics</h5>
                            <a href="{{ url('/shop') }}">Smartphones</a>
                            <a href="{{ url('/shop') }}">Laptops & PCs</a>
                            <a href="{{ url('/shop') }}">Cameras</a>
                            <a href="{{ url('/shop') }}">Accessories</a>
                        </div>
                        <div class="mega-col">
                            <h5><i class="fa-solid fa-shirt"></i> Fashion</h5>
                            <a href="{{ url('/shop') }}">Men's Clothing</a>
                            <a href="{{ url('/shop') }}">Women's Clothing</a>
                            <a href="{{ url('/shop') }}">Shoes</a>
                            <a href="{{ url('/shop') }}">Watches</a>
                        </div>
                        <div class="mega-col">
                            <h5><i class="fa-solid fa-house-chimney"></i> Home & Living</h5>
                            <a href="{{ url('/shop') }}">Furniture</a>
                            <a href="{{ url('/shop') }}">Decor</a>
                            <a href="{{ url('/shop') }}">Kitchenware</a>
                            <a href="{{ url('/shop') }}">Lighting</a>
                        </div>
                        <div class="mega-banner">
                            <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=500&q=80" alt="Sale" style="border-radius:0.5rem; width:100%; height:120px; object-fit:cover;">
                            <div class="mega-banner-text">Up to 50% Off</div>
                        </div>
                    </div>
                </div>
            </li>
            
            <li><a href="{{ url('/vendor') }}" class="nav-link">Vendors</a></li>
            <li><a href="{{ url('/shop') }}" class="nav-link">Deals <span style="color:var(--secondary);"><i class="fa-solid fa-fire"></i></span></a></li>
            <li><a href="{{ url('/blog') }}" class="nav-link">Blog</a></li>
            <li><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
            
            <li class="mobile-only guest-only"><a href="{{ url('/login') }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-top:1rem;"><i class="fa-regular fa-user"></i> Login / Register</a></li>
            <li class="mobile-only auth-only auth-user-only"><a href="{{ url('/register') }}" class="btn btn-accent" style="width:100%;justify-content:center;margin-top:0.5rem;"><i class="fa-solid fa-crown"></i> Become a Seller</a></li>
            <li class="mobile-only auth-only"><a href="javascript:void(0)" class="btn btn-outline mobileLogoutBtn" style="width:100%;justify-content:center;margin-top:0.5rem;color:#ef4444;border-color:#ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>

        <div class="nav-actions">
            <!-- Multi-Language Dropdown -->
            <div class="dropdown desktop-only">
                <button class="icon-btn dropdown-toggle" title="Language" style="border:none;background:transparent;display:flex;">
                    <i class="fa-solid fa-globe"></i>
                </button>
                <ul class="dropdown-menu" style="min-width:120px; right:0; left:auto;">
                    <li><a href="#" class="dropdown-item">English (EN)</a></li>
                    <li><a href="#" class="dropdown-item">Español (ES)</a></li>
                    <li><a href="#" class="dropdown-item">Français (FR)</a></li>
                </ul>
            </div>

            <a href="#" class="icon-btn theme-toggle" title="Toggle Dark Mode">
                <i class="fa-solid fa-moon"></i>
            </a>
            
            <a href="{{ url('/product-details') }}" class="icon-btn auth-only" title="Wishlist">
                <i class="fa-regular fa-heart"></i>
                <span class="badge">3</span>
            </a>
            <a href="{{ url('/cart') }}" class="icon-btn" title="Cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="badge badge-primary">2</span>
            </a>
            
            <!-- Unauthenticated Options -->
            <div class="guest-only desktop-only" style="display: flex; gap: 1rem; align-items:center;">
                <a href="{{ url('/login') }}" class="btn btn-outline">Login</a>
            </div>

            <!-- Authenticated User (Non-Vendor) Options -->
            <div class="auth-only auth-user-only desktop-only" style="display: none; gap: 1rem; align-items:center;">
                <a href="{{ url('/register') }}" class="btn btn-accent"><i class="fa-solid fa-crown"></i> Become Seller</a>
            </div>
            
            <!-- Vendor Options -->
            <div class="auth-only vendor-only desktop-only" style="display: none; gap: 1rem; align-items:center;">
                <a href="{{ url('/vendor-dashboard') }}" class="btn btn-primary"><i class="fa-solid fa-gauge"></i> Vendor Panel</a>
            </div>
            
            <!-- Admin Options -->
            <div class="auth-only admin-only desktop-only" style="display: none; gap: 1rem; align-items:center;">
                <a href="{{ url('/admin-dashboard') }}" class="btn btn-primary" style="background:#111827;border-color:#111827;"><i class="fa-solid fa-shield-halved"></i> Admin</a>
            </div>

            <!-- User Profile Dropdown -->
            <div class="dropdown auth-only desktop-only" style="display: none;">
                <a href="#" class="icon-btn dropdown-toggle" style="background:var(--primary-light); color:var(--primary);">
                    <i class="fa-regular fa-user"></i>
                </a>
                <ul class="dropdown-menu" style="right:0; left:auto; min-width:200px;">
                    <li style="padding:1rem; border-bottom:1px solid var(--border); margin-bottom:0.5rem;">
                        <strong style="display:block; color:var(--text);" class="navUserName">John Doe</strong>
                        <span style="font-size:0.8rem; color:var(--text-muted);" class="navUserRole">User</span>
                    </li>
                    <li><a href="#" class="dropdown-item"><i class="fa-solid fa-table-columns fa-fw"></i> My Dashboard</a></li>
                    <li><a href="{{ url('/orders') }}" class="dropdown-item"><i class="fa-solid fa-box fa-fw"></i> My Orders</a></li>
                    <li><a href="#" class="dropdown-item"><i class="fa-regular fa-address-card fa-fw"></i> Profile Settings</a></li>
                    <li style="border-top:1px solid var(--border); margin-top:0.5rem; padding-top:0.5rem;"><a href="javascript:void(0)" class="dropdown-item text-danger desktopLogoutBtn" style="color:#ef4444;"><i class="fa-solid fa-right-from-bracket fa-fw"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <button class="hamburger"><i class="fa-solid fa-bars-staggered"></i></button>
    </div>
</nav>
<div class="mobile-overlay"></div>
