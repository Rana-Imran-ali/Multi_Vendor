@extends('layouts.app')

@section('title', 'Vendo | Premium Multi-Vendor Marketplace')

@push('styles')
<style>
    /* Home Specific Styles */
    .hero {
        position: relative;
        height: calc(100vh - var(--navbar-height));
        min-height: 600px;
        display: flex;
        align-items: center;
        background: radial-gradient(circle at top right, var(--primary-light) 0%, var(--background) 50%);
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .hero-content { max-width: 650px; z-index: 2; position: relative; }
    .hero h1 { font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.5rem; letter-spacing: -1px; }
    .hero h1 span { color: var(--primary); }
    .hero p { font-size: 1.15rem; color: var(--text-muted); margin-bottom: 2.5rem; max-width: 500px; }
    
    .hero-graphics { position: absolute; right: 5%; top: 50%; transform: translateY(-50%); width: 45%; max-width: 650px; z-index: 1; pointer-events: none; }
    .hero-graphics-placeholder { width: 100%; height: 500px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 2rem; animation: floating 6s ease-in-out infinite; filter: drop-shadow(0 25px 35px rgba(0,0,0,0.1)); display: flex; align-items: center; justify-content: center; color: white; opacity: 0.1; }
    @keyframes floating { 0% { transform: translateY(0); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0); } }

    .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; }
    .cat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem 1.5rem; text-align: center; transition: var(--transition); display: block; }
    .cat-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); background: radial-gradient(circle at top right, var(--surface) 0%, var(--primary-light) 150%); }
    .cat-icon { width: 70px; height: 70px; background: var(--primary-light); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.25rem; transition: var(--transition); }
    .cat-card:hover .cat-icon { background: var(--primary); color: #fff; transform: scale(1.1); }
    .cat-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; color: var(--text); }
    .cat-card p { font-size: 0.85rem; color: var(--text-muted); }

    .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
    
    .deals-section { background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(34, 197, 94, 0.1) 100%); padding: 6rem 0; border-radius: 2rem; margin: 5rem 0; border: 1px solid var(--primary-light); }
    .deals-content { text-align: center; max-width: 600px; margin: 0 auto; }
    .deals-content h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: var(--text); }
    .deals-content p { color: var(--text-muted); margin-bottom: 2rem; font-size: 1.1rem; }
    .countdown { display: flex; justify-content: center; gap: 1rem; margin-bottom: 2.5rem; }
    .cd-box { background: var(--surface); width: 85px; height: 85px; border-radius: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
    .cd-num { font-size: 2rem; font-weight: 800; color: var(--primary); line-height: 1; }
    .cd-text { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem; }

    .vendor-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    .vendor-card { display: flex; align-items: center; gap: 1rem; background: var(--surface); padding: 1.5rem; border: 1px solid var(--border); border-radius: 1rem; transition: var(--transition); }
    .vendor-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--primary-light); }
    .vendor-img { width: 65px; height: 65px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem; flex-shrink: 0; }
    .vendor-info h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; color: var(--text); }
    .vendor-info p { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; }
    .vendor-badge { display: inline-block; background: var(--secondary); color: white; border-radius: 2rem; padding: 0.15rem 0.6rem; font-size: 0.7rem; font-weight: bold; }

    .newsletter { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); padding: 6rem 2rem; border-radius: 2rem; margin: 6rem 0; color: #fff; text-align: center; position: relative; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.3); }
    .newsletter::after { content: ''; position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: rgba(255,255,255,0.1); border-radius: 50%; pointer-events: none; }
    .newsletter h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; position: relative; z-index: 1; }
    .newsletter p { font-size: 1.15rem; opacity: 0.9; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; position: relative; z-index: 1; }
    .nl-form { max-width: 550px; margin: 0 auto; display: flex; gap: 0.5rem; background: #fff; padding: 0.5rem; border-radius: 3rem; position: relative; z-index: 1; }
    .nl-form input { flex: 1; border: none; background: transparent; padding: 0.5rem 1.5rem; font-size: 1rem; font-family: inherit; color: var(--text); }
    .nl-form input:focus { outline: none; }
    .nl-form .btn { border-radius: 2.5rem; padding: 0.75rem 2.5rem; font-size: 1rem; }

    @media (max-width: 1024px) {
        .hero-graphics { display: none; }
        .hero-content { text-align: center; margin: 0 auto; }
        .hero { text-align: center; }
        .hero .btn-group { justify-content: center; flex-wrap: wrap; display:flex; gap:1rem; }
        .nl-form { flex-direction: column; background: transparent; padding: 0; }
        .nl-form input { background: #fff; border-radius: 1rem; padding: 1.25rem; margin-bottom: 0.5rem; }
        .nl-form .btn { border-radius: 1rem; padding: 1.25rem; width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-content fade-in">
            <h1>Discover the Best <span>Independent Sellers</span> Worldwide</h1>
            <p>Shop thousands of exclusive products from curated vendors. Electronics, fashion, home decor, and more delivered straight to your door.</p>
            <div class="btn-group">
                <a href="{{ url('/shop') }}" class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i> Shop Now</a>
                <a href="{{ url('/vendor') }}" class="btn btn-outline"><i class="fa-solid fa-shop"></i> Browse Vendors</a>
            </div>
        </div>
        <div class="hero-graphics">
            <div class="hero-graphics-placeholder"><i class="fa-solid fa-image fa-4x"></i></div>
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="section-padding container">
    <div class="section-title fade-in">Top Categories</div>
    <div class="section-subtitle fade-in">Explore our wide range of premium collections</div>
    
    <div class="category-grid">
        <a href="{{ url('/shop?category=electronics') }}" class="cat-card fade-in delay-1">
            <div class="cat-icon"><i class="fa-solid fa-headphones-simple"></i></div>
            <h3>Electronics</h3>
            <p>4,231 Products</p>
        </a>
        <a href="{{ url('/shop?category=fashion') }}" class="cat-card fade-in delay-2">
            <div class="cat-icon"><i class="fa-solid fa-shoe-prints"></i></div>
            <h3>Fashion</h3>
            <p>8,512 Products</p>
        </a>
        <a href="{{ url('/shop?category=home-decor') }}" class="cat-card fade-in delay-3">
            <div class="cat-icon"><i class="fa-solid fa-house-chimney"></i></div>
            <h3>Home Decor</h3>
            <p>1,240 Products</p>
        </a>
        <a href="{{ url('/shop?category=sports') }}" class="cat-card fade-in delay-1">
            <div class="cat-icon"><i class="fa-solid fa-dumbbell"></i></div>
            <h3>Sports</h3>
            <p>2,100 Products</p>
        </a>
    </div>
</section>

<!-- PRODUCTS GRID -->
<section class="section-padding container">
    <div class="section-title fade-in">Featured Products</div>
    <div class="section-subtitle fade-in">Handpicked items perfectly curated for you</div>

    <div class="product-grid" id="featuredProducts">
        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
            <i class="fa-solid fa-spinner fa-spin fa-2x" style="color:var(--primary)"></i>
            <p style="margin-top: 1rem; color:var(--text-muted);">Loading products...</p>
        </div>
    </div>
</section>

<!-- DEALS COUNTDOWN -->
<section class="container fade-in">
    <div class="deals-section">
        <div class="deals-content">
            <h2>Deals of the Day</h2>
            <p>Don't miss out on these exclusive offers. Limited time only up to 60% off combined with free shipping.</p>
            <div class="countdown">
                <div class="cd-box"><span class="cd-num">02</span><span class="cd-text">DAYS</span></div>
                <div class="cd-box"><span class="cd-num">14</span><span class="cd-text">HOURS</span></div>
                <div class="cd-box"><span class="cd-num">45</span><span class="cd-text">MINS</span></div>
                <div class="cd-box"><span class="cd-num" id="sec-cnt">30</span><span class="cd-text">SECS</span></div>
            </div>
            <a href="{{ url('/shop?deals=true') }}" class="btn btn-accent"><i class="fa-solid fa-bolt"></i> Shop Deals Now</a>
        </div>
    </div>
</section>

<!-- TOP VENDORS -->
<section class="section-padding container">
    <div class="section-title fade-in">Top Vendors</div>
    <div class="section-subtitle fade-in">Shop directly from our highest rated independent stores</div>
    <div class="vendor-grid">
        <a href="{{ url('/vendor/1') }}" class="vendor-card fade-in delay-1">
            <div class="vendor-img"><i class="fa-solid fa-shop"></i></div>
            <div class="vendor-info">
                <h4>TechNova Store</h4>
                <p><i class="fa-solid fa-star" style="color:var(--accent)"></i> 4.9 (1,240 Reviews)</p>
                <span class="vendor-badge">Pro Seller</span>
            </div>
        </a>
        <a href="{{ url('/vendor/2') }}" class="vendor-card fade-in delay-2">
            <div class="vendor-img"><i class="fa-solid fa-camera"></i></div>
            <div class="vendor-info">
                <h4>Camerix Photography</h4>
                <p><i class="fa-solid fa-star" style="color:var(--accent)"></i> 4.8 (850 Reviews)</p>
                <span class="vendor-badge" style="background:var(--primary)">Brand</span>
            </div>
        </a>
        <a href="{{ url('/vendor/3') }}" class="vendor-card fade-in delay-3">
            <div class="vendor-img"><i class="fa-solid fa-shirt"></i></div>
            <div class="vendor-info">
                <h4>Urban Threads</h4>
                <p><i class="fa-solid fa-star" style="color:var(--accent)"></i> 4.7 (3,400 Reviews)</p>
            </div>
        </a>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="container fade-in">
    <div class="newsletter">
        <h2>Never Miss a Deal</h2>
        <p>Subscribe to our newsletter and get exclusive access to flash sales, unique vendor drops, and 10% off your first order.</p>
        <form class="nl-form" onsubmit="event.preventDefault();">
            <input type="email" placeholder="Enter your email address..." required>
            <button type="submit" class="btn btn-accent">Subscribe</button>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Countdown Timer logic
    const secCnt = document.getElementById('sec-cnt');
    if(secCnt) {
        setInterval(() => {
            let s = parseInt(secCnt.textContent);
            if(s > 0) { secCnt.textContent = (s-1 < 10 ? '0' : '') + (s-1); } else { secCnt.textContent = '59'; }
        }, 1000);
    }

    // Fetch Products from API (Just like shop.html but limited to 6)
    document.addEventListener('DOMContentLoaded', async () => {
        const grid = document.getElementById('featuredProducts');
        try {
            const res = await fetch('/api/products');
            const json = await res.json();
            
            if (res.ok && json.data && json.data.data) {
                const products = json.data.data.slice(0, 6); // Take first 6 as featured
                
                if (products.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-muted);"><i class="fa-solid fa-box-open fa-3x" style="opacity:0.5; margin-bottom:1rem;"></i><p>No products featured yet.</p></div>';
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
