@extends('layouts.app')

@section('title', 'Shop | Vendo Premium')

@push('styles')
<style>
    .shop-container { display: flex; gap: 2rem; align-items: flex-start; }
    
    /* Sidebar Filters */
    .shop-sidebar { width: 280px; flex-shrink: 0; background: var(--surface); border: 1px solid var(--border); border-radius: 1rem; padding: 1.5rem; position: sticky; top: calc(var(--navbar-height) + 2rem); }
    .filter-group { margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; }
    .filter-group:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .filter-group h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--text); }
    .filter-list li { margin-bottom: 0.75rem; }
    .filter-list label { display: flex; align-items: center; gap: 0.75rem; cursor: pointer; color: var(--text-muted); font-size: 0.95rem; transition: var(--transition); }
    .filter-list label:hover { color: var(--primary); }
    .filter-list input[type="checkbox"] { width: 1.1rem; height: 1.1rem; accent-color: var(--primary); cursor: pointer; }
    .filter-list span { margin-left: auto; background: var(--background); padding: 0.1rem 0.5rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 600; }
    
    /* Price Range */
    .range-slider { width: 100%; accent-color: var(--primary); cursor: pointer; }
    .price-inputs { display: flex; gap: 0.5rem; align-items: center; margin-top: 1rem; }
    .price-inputs input { width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--background); color: var(--text); font-size: 0.9rem; }
    .price-inputs input:focus { outline: none; border-color: var(--primary); }
    
    /* Main Grid */
    .shop-main { flex: 1; min-width: 0; }
    .shop-toolbar { display: flex; justify-content: space-between; align-items: center; background: var(--surface); border: 1px solid var(--border); border-radius: 1rem; padding: 1rem 1.5rem; margin-bottom: 2rem; }
    .shop-toolbar p { color: var(--text-muted); font-size: 0.95rem; font-weight: 500; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
    
    /* Product Card Styles */
    .product-card { background: var(--surface); border: 1px solid var(--border); border-radius: 1.25rem; overflow: hidden; transition: var(--transition); position: relative; display: flex; flex-direction: column; }
    .product-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--primary-light); }
    .product-img { position: relative; aspect-ratio: 1; background: var(--background); display: flex; align-items: center; justify-content: center; }
    .product-img i { font-size: 3rem; color: var(--border); }
    .product-badge { position: absolute; top: 1rem; left: 1rem; background: var(--accent); color: #fff; font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 0.5rem; z-index: 2; }
    .product-actions { position: absolute; top: 1rem; right: 1rem; display: flex; flex-direction: column; gap: 0.5rem; opacity: 0; transform: translateX(10px); transition: var(--transition); z-index: 2; }
    .product-card:hover .product-actions { opacity: 1; transform: translateX(0); }
    .product-action-btn { width: 36px; height: 36px; border-radius: 50%; background: var(--surface); color: var(--text); display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); transition: var(--transition); border: 1px solid var(--border); cursor: pointer; }
    .product-action-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
    .product-info { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
    .product-vendor { font-size: 0.8rem; color: var(--text-muted); font-weight: 500; margin-bottom: 0.25rem; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .product-vendor:hover { color: var(--primary); }
    .product-title { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .product-title:hover { color: var(--primary); }
    .product-rating { color: var(--accent); font-size: 0.8rem; margin-bottom: 1rem; display: flex; gap: 0.2rem; }
    .product-rating span { color: var(--text-muted); margin-left: 0.25rem; }
    .product-price-row { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
    .price-box { display: flex; align-items: baseline; gap: 0.5rem; }
    .price { font-weight: 800; font-size: 1.25rem; color: var(--primary); }
    .old-price { text-decoration: line-through; color: var(--text-muted); font-size: 0.9rem; }
    
    /* Pagination */
    .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 4rem; }
    .page-btn { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem; border: 1px solid var(--border); background: var(--surface); color: var(--text); font-weight: 600; transition: var(--transition); cursor: pointer; }
    .page-btn:hover, .page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
    
    /* Mobile Overlay */
    .mobile-filter-btn { display: none; width: 100%; margin-bottom: 1.5rem; }
    .mobile-sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 998; opacity: 0; visibility: hidden; transition: var(--transition); }
    
    @media (max-width: 1024px) {
        .shop-container { flex-direction: column; }
        .shop-sidebar { position: fixed; left: -320px; top: 0; height: 100vh; width: 300px; z-index: 999; border-radius: 0; overflow-y: auto; transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1); margin: 0; border: none; }
        .shop-sidebar.active { left: 0; }
        .mobile-filter-btn { display: flex; }
        .mobile-sidebar-overlay.active { display: block; opacity: 1; visibility: visible; }
        .shop-toolbar { flex-direction: column; gap: 1rem; align-items: flex-start; }
        .shop-toolbar select { width: 100%; }
        .shop-toolbar > div { width: 100%; justify-content: space-between; }
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="container fade-in">
        <h1>Shop All Products</h1>
        <p>Browse our extensive collection of premium items from top vendors around the world. Filter by category, price, and customer ratings.</p>
    </div>
</div>

<!-- MAIN SHOP LISTING -->
<section class="section-padding container">
    
    <!-- Mobile Filter Button -->
    <button class="btn btn-outline mobile-filter-btn" id="mobile-filter-open">
        <i class="fa-solid fa-filter"></i> Filter Products
    </button>
    <div class="mobile-sidebar-overlay" id="filter-overlay"></div>

    <div class="shop-container">
        
        <!-- SIDEBAR -->
        <aside class="shop-sidebar" id="filter-sidebar">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;" class="mobile-only">
                <h3 style="font-size:1.25rem;">Filters</h3>
                <button class="icon-btn" id="mobile-filter-close" style="background:transparent;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="filter-group">
                <h4>Categories</h4>
                <ul class="filter-list">
                    <li><label><input type="checkbox" checked> Electronics <span>120</span></label></li>
                    <li><label><input type="checkbox"> Fashion & Apparels <span>85</span></label></li>
                    <li><label><input type="checkbox"> Home & Living <span>42</span></label></li>
                    <li><label><input type="checkbox"> Sports & Outdoors <span>38</span></label></li>
                    <li><label><input type="checkbox"> Jewelry & Watches <span>15</span></label></li>
                    <li><label><input type="checkbox"> Beauty & Health <span>50</span></label></li>
                </ul>
            </div>
            
            <div class="filter-group">
                <h4>Price Range</h4>
                <input type="range" class="range-slider" min="0" max="2000" value="1000">
                <div class="price-inputs">
                    <input type="number" placeholder="Min" value="0">
                    <span style="color:var(--text-muted)">-</span>
                    <input type="number" placeholder="Max" value="1000">
                </div>
            </div>

            <div class="filter-group">
                <h4>Customer Rating</h4>
                <ul class="filter-list">
                    <li><label><input type="checkbox"> <span style="color:var(--accent);background:transparent;padding:0;font-size:0.9rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span> <span style="margin-left:auto;">24</span></label></li>
                    <li><label><input type="checkbox"> <span style="color:var(--accent);background:transparent;padding:0;font-size:0.9rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i> & up</span></label></li>
                    <li><label><input type="checkbox"> <span style="color:var(--accent);background:transparent;padding:0;font-size:0.9rem;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i> & up</span></label></li>
                </ul>
            </div>

            <div class="filter-group">
                <h4>Vendor</h4>
                <ul class="filter-list">
                    <li><label><input type="checkbox"> TechNova Store <span>18</span></label></li>
                    <li><label><input type="checkbox"> Camerix Photography <span>12</span></label></li>
                    <li><label><input type="checkbox"> Urban Threads <span>45</span></label></li>
                </ul>
            </div>
            
            <button class="btn btn-primary" style="width:100%;">Apply Filters</button>
        </aside>

        <!-- PRODUCT GRID AREA -->
        <div class="shop-main">
            <div class="shop-toolbar fade-in">
                <p>Showing 1-15 of 36 results</p>
                <div style="display:flex;gap:1rem;align-items:center;">
                    <label style="color:var(--text-muted);font-size:0.9rem;font-weight:600;">Sort by:</label>
                    <select class="form-control" style="width:auto;padding:0.5rem 1rem;cursor:pointer;border-radius:2rem;">
                        <option>Latest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Top Rated</option>
                    </select>
                </div>
            </div>

            <div class="product-grid" id="productGrid">
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                    <i class="fa-solid fa-spinner fa-spin fa-3x" style="color:var(--primary)"></i>
                    <p style="margin-top: 1rem; color:var(--text-muted); font-weight:600;">Loading shop inventory...</p>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination fade-in">
                <button class="page-btn"><i class="fa-solid fa-angle-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn"><i class="fa-solid fa-angle-right"></i></button>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Shop specific mobile filter logic
    document.addEventListener('DOMContentLoaded', () => {
        const filterOpenBtn = document.getElementById('mobile-filter-open');
        const filterCloseBtn = document.getElementById('mobile-filter-close');
        const sidebar = document.getElementById('filter-sidebar');
        const filterOverlay = document.getElementById('filter-overlay');

        if(filterOpenBtn && sidebar && filterOverlay) {
            filterOpenBtn.addEventListener('click', () => {
                sidebar.classList.add('active');
                filterOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            const closeFilter = () => {
                sidebar.classList.remove('active');
                filterOverlay.classList.remove('active');
                document.body.style.overflow = '';
            };

            if(filterCloseBtn) filterCloseBtn.addEventListener('click', closeFilter);
            filterOverlay.addEventListener('click', closeFilter);
        }
    });

    // Fetch Products from API
    document.addEventListener('DOMContentLoaded', async () => {
        const grid = document.getElementById('productGrid');
        try {
            const res = await fetch('/api/products');
            const json = await res.json();
            
            if (res.ok && json.data && json.data.data) {
                const products = json.data.data;
                
                if (products.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-muted);"><i class="fa-solid fa-box-open fa-3x" style="opacity:0.5; margin-bottom:1rem;"></i><p>No products found yet.</p></div>';
                    return;
                }
                
                let html = '';
                products.forEach(p => {
                    html += `
                    <div class="product-card fade-in">
                        <div class="product-img">
                            ${p.image ? `<img src="${p.image}" alt="${p.name}" style="width:100%; height:100%; object-fit:cover;">` : `<i class="fa-solid fa-box"></i>`}
                            <div class="product-actions">
                                <button class="product-action-btn" title="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                                <a href="/product-details/${p.id}" class="product-action-btn" title="Quick View"><i class="fa-regular fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="product-info">
                            <a href="/vendor/${p.vendor_id}" class="product-vendor">${p.vendor ? p.vendor.store_name : 'Unknown Vendor'}</a>
                            <a href="/product-details/${p.id}" class="product-title">${p.name}</a>
                            <div class="product-rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><span>(0)</span></div>
                            <div class="product-price-row">
                                <div class="price-box"><span class="price">$${parseFloat(p.price).toFixed(2)}</span></div>
                                <button class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>`;
                });
                
                grid.innerHTML = html;
            } else {
                grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color:#ef4444;"><p>Failed to load products.</p></div>';
            }
        } catch(e) {
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color:#ef4444;"><p>Error connecting to API.</p></div>';
        }
    });
</script>
@endpush
