@extends('layouts.app')

@section('title', 'Vendo — Modern Multi-Vendor Marketplace')
@section('meta_description', 'Discover thousands of products from trusted local and international vendors on Vendo.')

{{-- ============================================================
     HOME PAGE — home.blade.php
     Sections:
       1. Hero Banner (slider)
       2. Categories Grid
       3. Featured Products
       4. Top Vendors
       5. Deals / Flash Sale
     All data is dummy — replace arrays with controller variables.
============================================================ --}}

@php
/* ── DUMMY DATA ────────────────────────────────────────────── */

$categories = [
    ['id'=>1, 'name'=>'Electronics',    'icon'=>'fa-microchip',         'color'=>'#4f46e5','bg'=>'#ede9fe','count'=>'2.4k+ items', 'image'=>'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&q=80&w=400'],
    ['id'=>2, 'name'=>'Fashion',        'icon'=>'fa-shirt',             'color'=>'#db2777','bg'=>'#fce7f3','count'=>'5.1k+ items', 'image'=>'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&q=80&w=400'],
    ['id'=>3, 'name'=>'Home & Living',  'icon'=>'fa-couch',             'color'=>'#059669','bg'=>'#d1fae5','count'=>'1.8k+ items', 'image'=>'https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e?auto=format&fit=crop&q=80&w=400'],
    ['id'=>4, 'name'=>'Beauty',         'icon'=>'fa-face-smile-beam',   'color'=>'#d97706','bg'=>'#fef3c7','count'=>'900+ items', 'image'=>'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&q=80&w=400'],
    ['id'=>5, 'name'=>'Sports',         'icon'=>'fa-dumbbell',          'color'=>'#0891b2','bg'=>'#cffafe','count'=>'1.2k+ items', 'image'=>'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&q=80&w=400'],
    ['id'=>6, 'name'=>'Books',          'icon'=>'fa-book-open',         'color'=>'#7c3aed','bg'=>'#ede9fe','count'=>'3.5k+ items', 'image'=>'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&q=80&w=400'],
    ['id'=>7, 'name'=>'Automotive',     'icon'=>'fa-car',               'color'=>'#dc2626','bg'=>'#fee2e2','count'=>'640+ items', 'image'=>'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&q=80&w=400'],
    ['id'=>8, 'name'=>'Groceries',      'icon'=>'fa-basket-shopping',   'color'=>'#16a34a','bg'=>'#dcfce7','count'=>'2.9k+ items', 'image'=>'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=400'],
];

$featuredProducts = [
    ['id'=>1,'name'=>'Sony WH-1000XM5 Noise Cancelling Headphones','slug'=>'sony-wh-1000xm5','price'=>42999,'oldPrice'=>55999,'discount'=>23,'rating'=>5,'reviewsCount'=>1284,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=400','badge'=>'Best Seller','badgeType'=>'hot','vendorId'=>10,'vendorName'=>'SoundZone PK','vendorSlug'=>'soundzone-pk','inStock'=>true],
    ['id'=>2,'name'=>'Nike Air Max 270 — Men\'s Running Shoes','slug'=>'nike-air-max-270','price'=>18500,'oldPrice'=>24000,'discount'=>23,'rating'=>4,'reviewsCount'=>832,'icon'=>'fa-shoe-prints','image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=400','badge'=>'New','badgeType'=>'new','vendorId'=>11,'vendorName'=>'SportsHub','vendorSlug'=>'sportshub','inStock'=>true],
    ['id'=>3,'name'=>'Xiaomi Smart 4K Android TV — 55 Inch','slug'=>'xiaomi-4k-tv-55','price'=>89900,'oldPrice'=>110000,'discount'=>18,'rating'=>4,'reviewsCount'=>521,'icon'=>'fa-tv','image'=>'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&q=80&w=400','badge'=>'Hot Deal','badgeType'=>'sale','vendorId'=>12,'vendorName'=>'TechMart PK','vendorSlug'=>'techmart-pk','inStock'=>true],
    ['id'=>4,'name'=>'L\'Oréal Paris Revitalift Serum — 30ml','slug'=>'loreal-revitalift-serum','price'=>3200,'oldPrice'=>4300,'discount'=>26,'rating'=>4,'reviewsCount'=>378,'icon'=>'fa-flask','image'=>'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&q=80&w=400','badge'=>'Sale','badgeType'=>'sale','vendorId'=>13,'vendorName'=>'GlowStore','vendorSlug'=>'glowstore','inStock'=>true],
    ['id'=>5,'name'=>'Hamilton Beach Stand Mixer — 4.5 Qt','slug'=>'hamilton-beach-mixer','price'=>12800,'oldPrice'=>null,'discount'=>null,'rating'=>5,'reviewsCount'=>204,'icon'=>'fa-blender','image'=>'https://images.unsplash.com/photo-1596738148858-6bb7f28edde2?auto=format&fit=crop&q=80&w=400','badge'=>'New','badgeType'=>'new','vendorId'=>14,'vendorName'=>'HomeChef','vendorSlug'=>'homechef','inStock'=>true],
    ['id'=>6,'name'=>'Samsung Galaxy A55 — 8/256GB','slug'=>'samsung-galaxy-a55','price'=>74999,'oldPrice'=>82000,'discount'=>10,'rating'=>4,'reviewsCount'=>967,'icon'=>'fa-mobile-screen','image'=>'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&q=80&w=400','badge'=>'Sale','badgeType'=>'sale','vendorId'=>12,'vendorName'=>'TechMart PK','vendorSlug'=>'techmart-pk','inStock'=>true],
    ['id'=>7,'name'=>'IKEA ALEX Desk Drawer Unit — White','slug'=>'ikea-alex-drawer','price'=>24500,'oldPrice'=>null,'discount'=>null,'rating'=>4,'reviewsCount'=>156,'icon'=>'fa-table-columns','image'=>'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&q=80&w=400','badge'=>null,'badgeType'=>null,'vendorId'=>15,'vendorName'=>'FurnishAll','vendorSlug'=>'furnishall','inStock'=>true],
    ['id'=>8,'name'=>'Adidas Ultraboost 22 Running Shoes','slug'=>'adidas-ultraboost-22','price'=>27999,'oldPrice'=>34999,'discount'=>20,'rating'=>5,'reviewsCount'=>642,'icon'=>'fa-shoe-prints','image'=>'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&q=80&w=400','badge'=>'Featured','badgeType'=>'featured','vendorId'=>11,'vendorName'=>'SportsHub','vendorSlug'=>'sportshub','inStock'=>false],
];

$vendors = [
    ['id'=>10,'name'=>'SoundZone PK',  'slug'=>'soundzone-pk', 'category'=>'Electronics & Audio','rating'=>4.9,'sales'=>12400,'icon'=>'fa-headphones','color'=>'#4f46e5','initials'=>'SZ'],
    ['id'=>11,'name'=>'SportsHub',     'slug'=>'sportshub',    'category'=>'Sports & Fitness',    'rating'=>4.8,'sales'=>8900, 'icon'=>'fa-dumbbell',   'color'=>'#0891b2','initials'=>'SH'],
    ['id'=>12,'name'=>'TechMart PK',   'slug'=>'techmart-pk',  'category'=>'Mobiles & Gadgets',   'rating'=>4.7,'sales'=>21300,'icon'=>'fa-mobile-screen','color'=>'#7c3aed','initials'=>'TM'],
    ['id'=>13,'name'=>'GlowStore',     'slug'=>'glowstore',    'category'=>'Beauty & Skincare',   'rating'=>4.9,'sales'=>6700, 'icon'=>'fa-face-smile-beam','color'=>'#db2777','initials'=>'GS'],
    ['id'=>14,'name'=>'HomeChef',      'slug'=>'homechef',     'category'=>'Kitchen & Dining',    'rating'=>4.6,'sales'=>4300, 'icon'=>'fa-blender',    'color'=>'#059669','initials'=>'HC'],
    ['id'=>15,'name'=>'FurnishAll',    'slug'=>'furnishall',   'category'=>'Home & Furniture',    'rating'=>4.8,'sales'=>9100, 'icon'=>'fa-couch',      'color'=>'#d97706','initials'=>'FA'],
];

$deals = [
    ['id'=>20,'name'=>'Apple AirPods Pro 2nd Gen','slug'=>'airpods-pro-2','price'=>44999,'oldPrice'=>64999,'discount'=>31,'rating'=>5,'reviewsCount'=>2101,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1606220588913-b3eea405b550?auto=format&fit=crop&q=80&w=400','badge'=>'Flash Sale','badgeType'=>'hot','vendorId'=>12,'vendorName'=>'TechMart PK','vendorSlug'=>'techmart-pk','inStock'=>true,'endsAt'=>'+8 hours'],
    ['id'=>21,'name'=>'Dyson V12 Detect Slim Vacuum','slug'=>'dyson-v12','price'=>78000,'oldPrice'=>105000,'discount'=>26,'rating'=>5,'reviewsCount'=>894,'icon'=>'fa-broom','image'=>'https://images.unsplash.com/photo-1558317374-067fb5f300cb?auto=format&fit=crop&q=80&w=400','badge'=>'Flash Sale','badgeType'=>'hot','vendorId'=>15,'vendorName'=>'FurnishAll','vendorSlug'=>'furnishall','inStock'=>true,'endsAt'=>'+8 hours'],
    ['id'=>22,'name'=>'Levi\'s 511 Slim Fit Jeans — Men','slug'=>'levis-511','price'=>6500,'oldPrice'=>9500,'discount'=>32,'rating'=>4,'reviewsCount'=>1530,'icon'=>'fa-shirt','image'=>'https://images.unsplash.com/photo-1542272604-78016ec485ec?auto=format&fit=crop&q=80&w=400','badge'=>'Flash Sale','badgeType'=>'hot','vendorId'=>11,'vendorName'=>'SportsHub','vendorSlug'=>'sportshub','inStock'=>true,'endsAt'=>'+8 hours'],
    ['id'=>23,'name'=>'Nescafé Gold Blend — 200g Premium Tin','slug'=>'nescafe-gold-200','price'=>1899,'oldPrice'=>2500,'discount'=>24,'rating'=>4,'reviewsCount'=>672,'icon'=>'fa-mug-hot','image'=>'https://images.unsplash.com/photo-1559525839-b184a4d698c7?auto=format&fit=crop&q=80&w=400','badge'=>'Flash Sale','badgeType'=>'hot','vendorId'=>16,'vendorName'=>'GroceryBox','vendorSlug'=>'grocerybox','inStock'=>true,'endsAt'=>'+8 hours'],
];
@endphp

@section('content')

<!-- ============================================================
     §1  HERO BANNER
============================================================ -->
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">

        {{-- Indicators --}}
        <div class="carousel-indicators hero-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            {{-- Slide 1 --}}
            <div class="carousel-item active">
                <div class="hero-slide hero-slide--1">
                    <div class="container-xl">
                        <div class="row align-items-center min-vh-hero">
                            <div class="col-lg-6" data-aos="fade-right">
                                <span class="hero-eyebrow">🔥 New Season Sale — Up to 50% Off</span>
                                <h1 class="hero-headline">Discover Products<br><span class="hero-highlight">You'll Love</span></h1>
                                <p class="hero-sub">Thousands of trusted vendors. One seamless marketplace. Shop smarter, not harder.</p>
                                <div class="hero-cta-group">
                                    <a href="{{ url('/shop') }}" class="btn btn-brand btn-lg hero-btn-primary">
                                        Shop Now <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                    <a href="{{ url('/deals') }}" class="btn btn-outline-light btn-lg hero-btn-secondary">
                                        View Deals
                                    </a>
                                </div>
                                <div class="hero-stats">
                                    <div class="hero-stat"><strong>50K+</strong><span>Products</span></div>
                                    <div class="hero-stat-div"></div>
                                    <div class="hero-stat"><strong>2K+</strong><span>Vendors</span></div>
                                    <div class="hero-stat-div"></div>
                                    <div class="hero-stat"><strong>200K+</strong><span>Customers</span></div>
                                </div>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <div class="hero-illustration hero-illustration--1">
                                    <i class="fa fa-bag-shopping"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="carousel-item">
                <div class="hero-slide hero-slide--2">
                    <div class="container-xl">
                        <div class="row align-items-center min-vh-hero">
                            <div class="col-lg-6">
                                <span class="hero-eyebrow">💻 Tech Deals — Week Exclusive</span>
                                <h1 class="hero-headline">Power Up with<br><span class="hero-highlight">Latest Tech</span></h1>
                                <p class="hero-sub">Mobiles, laptops, audio and more from Pakistan's top gadget vendors.</p>
                                <div class="hero-cta-group">
                                    <a href="{{ url('/categories/electronics') }}" class="btn btn-brand btn-lg hero-btn-primary">
                                        Explore Electronics <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="carousel-item">
                <div class="hero-slide hero-slide--3">
                    <div class="container-xl">
                        <div class="row align-items-center min-vh-hero">
                            <div class="col-lg-6">
                                <span class="hero-eyebrow">🛍️ Fashion Forward</span>
                                <h1 class="hero-headline">Style That<br><span class="hero-highlight">Speaks for You</span></h1>
                                <p class="hero-sub">Curated fashion from top local and international brands. New drops every week.</p>
                                <div class="hero-cta-group">
                                    <a href="{{ url('/categories/fashion') }}" class="btn btn-brand btn-lg hero-btn-primary">
                                        Shop Fashion <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /.carousel-inner --}}

        {{-- Prev/Next controls --}}
        <button class="carousel-control-prev hero-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="hero-ctrl-icon"><i class="fa fa-chevron-left"></i></span>
        </button>
        <button class="carousel-control-next hero-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="hero-ctrl-icon"><i class="fa fa-chevron-right"></i></span>
        </button>

    </div>{{-- /#heroCarousel --}}
</section>


<!-- ============================================================
     §2  CATEGORIES GRID
============================================================ -->
<section class="section-pad bg-white">
    <div class="container-xl">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Browse by</span>
                <h2 class="section-title">Popular Categories</h2>
            </div>
            <a href="{{ url('/categories') }}" class="section-link">
                View All <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 row-cols-xl-8">
            @foreach($categories as $cat)
            <div class="col">
                <a href="{{ url('/categories/' . \Illuminate\Support\Str::slug($cat['name'])) }}"
                   class="category-card"
                   style="--cat-color: {{ $cat['color'] }}; --cat-bg: {{ $cat['bg'] }};">
                    <div class="category-icon-wrap">
                        <i class="fa {{ $cat['icon'] }}"></i>
                    </div>
                    <span class="category-name">{{ $cat['name'] }}</span>
                    <span class="category-count">{{ $cat['count'] }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ============================================================
     §3  FEATURED PRODUCTS
============================================================ -->
<section class="section-pad" style="background:#f7f8fa;">
    <div class="container-xl">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Handpicked for you</span>
                <h2 class="section-title">Featured Products</h2>
            </div>
            <div class="d-flex align-items-center gap-3">
                {{-- Filter tabs --}}
                <div class="product-tabs d-none d-md-flex">
                    <button class="product-tab active" data-filter="all">All</button>
                    <button class="product-tab" data-filter="electronics">Electronics</button>
                    <button class="product-tab" data-filter="fashion">Fashion</button>
                    <button class="product-tab" data-filter="home">Home</button>
                </div>
                <a href="{{ url('/shop') }}" class="section-link">
                    View All <i class="fa fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @foreach($featuredProducts as $product)
            <div class="col">
                <x-product-card
                    :id="$product['id']"
                    :name="$product['name']"
                    :slug="$product['slug']"
                    :price="$product['price']"
                    :oldPrice="$product['oldPrice'] ?? null"
                    :discount="$product['discount'] ?? null"
                    :rating="$product['rating']"
                    :reviewsCount="$product['reviewsCount']"
                    :icon="$product['icon']"
                    :badge="$product['badge'] ?? null"
                    :badgeType="$product['badgeType'] ?? 'sale'"
                    :vendorId="$product['vendorId']"
                    :vendorName="$product['vendorName']"
                    :vendorSlug="$product['vendorSlug']"
                    :inStock="$product['inStock']"
                />
            </div>
            @endforeach
        </div>

        {{-- Load more --}}
        <div class="text-center mt-5">
            <a href="{{ url('/shop') }}" class="btn btn-outline-brand btn-lg px-5">
                Explore All Products <i class="fa fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<!-- ============================================================
     §4  TOP VENDORS
============================================================ -->
<section class="section-pad bg-white">
    <div class="container-xl">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">Trusted sellers</span>
                <h2 class="section-title">Top Vendors</h2>
            </div>
            <a href="{{ url('/vendors') }}" class="section-link">
                All Vendors <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-3 row-cols-lg-6">
            @foreach($vendors as $vendor)
            <div class="col">
                <a href="{{ url('/vendors/' . $vendor['slug']) }}" class="vendor-card"
                   style="--vendor-color: {{ $vendor['color'] }};">
                    <div class="vendor-avatar">
                        <span class="vendor-initials" style="background: {{ $vendor['color'] }};">
                            {{ $vendor['initials'] }}
                        </span>
                        <span class="vendor-verified" title="Verified Vendor">
                            <i class="fa fa-circle-check"></i>
                        </span>
                    </div>
                    <p class="vendor-name">{{ $vendor['name'] }}</p>
                    <p class="vendor-cat">{{ $vendor['category'] }}</p>
                    <div class="vendor-meta">
                        <span class="vendor-rating">
                            <i class="fa fa-star text-warning" style="font-size:.72rem;"></i>
                            {{ number_format($vendor['rating'], 1) }}
                        </span>
                        <span class="vendor-sep">·</span>
                        <span class="vendor-sales">{{ number_format($vendor['sales'] / 1000, 1) }}k sales</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Sell on Vendo promo bar --}}
        <div class="sell-promo-bar mt-5">
            <div class="row align-items-center gy-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-3">
                        <div class="sell-promo-icon">
                            <i class="fa fa-store"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-700">Ready to grow your business?</h5>
                            <p class="mb-0 text-muted small">Join 2,000+ vendors already selling on Vendo. Start for free.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <a href="{{ url('/become-seller') }}" class="btn btn-brand px-4">
                        Start Selling Today <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ============================================================
     §5  FLASH DEALS / DISCOUNT SECTION
============================================================ -->
<section class="section-pad deals-section">
    <div class="container-xl">
        <div class="section-header">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div>
                    <span class="section-eyebrow" style="color:rgba(255,255,255,.65);">Limited time</span>
                    <h2 class="section-title text-white">Flash Deals 🔥</h2>
                </div>
                {{-- Countdown Timer --}}
                <div class="deals-countdown">
                    <span class="countdown-label">Ends in</span>
                    <div class="countdown-timer">
                        <div class="countdown-unit">
                            <span id="ctHours">07</span>
                            <small>hrs</small>
                        </div>
                        <span class="countdown-colon">:</span>
                        <div class="countdown-unit">
                            <span id="ctMins">58</span>
                            <small>min</small>
                        </div>
                        <span class="countdown-colon">:</span>
                        <div class="countdown-unit">
                            <span id="ctSecs">43</span>
                            <small>sec</small>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ url('/deals') }}" class="section-link text-white" style="border-color:rgba(255,255,255,.3);">
                All Deals <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-2 row-cols-lg-4">
            @foreach($deals as $product)
            <div class="col">
                <x-product-card
                    :id="$product['id']"
                    :name="$product['name']"
                    :slug="$product['slug']"
                    :price="$product['price']"
                    :oldPrice="$product['oldPrice']"
                    :discount="$product['discount']"
                    :rating="$product['rating']"
                    :reviewsCount="$product['reviewsCount']"
                    :icon="$product['icon']"
                    :badge="$product['badge']"
                    :badgeType="$product['badgeType']"
                    :vendorId="$product['vendorId']"
                    :vendorName="$product['vendorName']"
                    :vendorSlug="$product['vendorSlug']"
                    :inStock="$product['inStock']"
                />
            </div>
            @endforeach
        </div>

    </div>
</section>


<!-- ============================================================
     §6  TRUST / USP BANNER
============================================================ -->
<section class="usp-section">
    <div class="container-xl">
        <div class="row g-0 usp-row">
            <div class="col-6 col-md-3 usp-item">
                <i class="fa fa-truck-fast usp-icon"></i>
                <div>
                    <h6 class="usp-title">Fast Delivery</h6>
                    <p class="usp-desc">Same-day in major cities</p>
                </div>
            </div>
            <div class="col-6 col-md-3 usp-item">
                <i class="fa fa-rotate-left usp-icon"></i>
                <div>
                    <h6 class="usp-title">Easy Returns</h6>
                    <p class="usp-desc">30-day hassle-free returns</p>
                </div>
            </div>
            <div class="col-6 col-md-3 usp-item">
                <i class="fa fa-lock usp-icon"></i>
                <div>
                    <h6 class="usp-title">Secure Payments</h6>
                    <p class="usp-desc">SSL encrypted checkout</p>
                </div>
            </div>
            <div class="col-6 col-md-3 usp-item border-end-0">
                <i class="fa fa-headset usp-icon"></i>
                <div>
                    <h6 class="usp-title">24/7 Support</h6>
                    <p class="usp-desc">Live chat & call support</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


<!-- ============================================================
     PAGE STYLES
============================================================ -->
@push('styles')
<style>

/* ── Shared section utilities ── */
.section-pad { padding: 5rem 0; }

.section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
}
.section-eyebrow {
    display: block;
    font-size: .73rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .9px;
    color: var(--brand-primary);
    margin-bottom: .3rem;
}
.section-title {
    font-size: clamp(1.4rem, 2.5vw, 1.9rem);
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
    letter-spacing: -.4px;
}
.section-link {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .875rem;
    font-weight: 600;
    color: var(--brand-primary);
    text-decoration: none;
    border: 1.5px solid rgba(240,79,35,.25);
    border-radius: 50px;
    padding: .35rem .9rem;
    white-space: nowrap;
    transition: var(--transition);
}
.section-link:hover {
    background: var(--brand-primary);
    color: #fff;
    border-color: var(--brand-primary);
}


/* ── §1 HERO ── */
.hero-section { background: #0f0f1a; }
.hero-carousel { max-height: 580px; overflow: hidden; }

.hero-slide {
    min-height: 580px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.min-vh-hero { min-height: 480px; }

.hero-slide--1 {
    background: linear-gradient(135deg, #0f0f1a 0%, #1a1a35 40%, #0f1a2e 100%);
}
.hero-slide--2 {
    background: linear-gradient(135deg, #0f1a0f 0%, #0a2a1a 50%, #061a0f 100%);
}
.hero-slide--3 {
    background: linear-gradient(135deg, #1a0f1a 0%, #2a0a2a 50%, #1a061a 100%);
}

/* Decorative circles */
.hero-slide::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(240,79,35,.12) 0%, transparent 70%);
    right: -100px;
    top: -150px;
    pointer-events: none;
}
.hero-slide::after {
    content: '';
    position: absolute;
    width: 350px;
    height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(240,79,35,.08) 0%, transparent 70%);
    left: -50px;
    bottom: -100px;
    pointer-events: none;
}

.hero-eyebrow {
    display: inline-block;
    background: rgba(240,79,35,.15);
    border: 1px solid rgba(240,79,35,.3);
    color: #ff7f5e;
    font-size: .8rem;
    font-weight: 600;
    padding: .35rem .9rem;
    border-radius: 50px;
    margin-bottom: 1.25rem;
    letter-spacing: .3px;
}
.hero-headline {
    font-size: clamp(2rem, 5vw, 3.4rem);
    font-weight: 900;
    line-height: 1.18;
    color: #fff;
    margin-bottom: 1rem;
    letter-spacing: -.8px;
}
.hero-highlight {
    background: linear-gradient(90deg, var(--brand-primary), #ff9a6c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-sub {
    font-size: 1.05rem;
    color: rgba(255,255,255,.6);
    max-width: 460px;
    line-height: 1.7;
    margin-bottom: 2rem;
}
.hero-cta-group { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2.5rem; }
.hero-btn-primary { border-radius: 50px; padding: .7rem 1.75rem; font-weight: 700; }
.hero-btn-secondary {
    border-radius: 50px;
    padding: .7rem 1.75rem;
    font-weight: 600;
    border-color: rgba(255,255,255,.25);
    color: rgba(255,255,255,.8);
}
.hero-btn-secondary:hover { background: rgba(255,255,255,.1); color: #fff; border-color: rgba(255,255,255,.5); }

/* Stats */
.hero-stats { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
.hero-stat { text-align: left; }
.hero-stat strong { display: block; font-size: 1.4rem; font-weight: 800; color: #fff; line-height: 1.1; }
.hero-stat span { font-size: .78rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .5px; }
.hero-stat-div { width: 1px; height: 40px; background: rgba(255,255,255,.15); }

/* Hero illustration */
.hero-illustration {
    width: 360px;
    height: 360px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(240,79,35,.15), rgba(240,79,35,.05));
    border: 1px solid rgba(240,79,35,.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 9rem;
    color: rgba(240,79,35,.5);
    margin: auto;
    animation: floatAnim 4s ease-in-out infinite;
}
@keyframes floatAnim {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-16px); }
}

/* Carousel controls */
.hero-control { width: 46px; }
.hero-ctrl-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,.12);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .85rem;
    border: 1px solid rgba(255,255,255,.15);
    transition: background .2s;
}
.hero-control:hover .hero-ctrl-icon { background: var(--brand-primary); }

/* Custom indicators */
.hero-indicators [data-bs-slide-to] {
    width: 28px;
    height: 3px;
    border-radius: 2px;
    background: rgba(255,255,255,.3);
    border: none;
    opacity: 1;
    transition: all .3s ease;
}
.hero-indicators [data-bs-slide-to].active {
    width: 48px;
    background: var(--brand-primary);
}


/* ── §2 CATEGORIES ── */
.category-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.25rem .75rem;
    border-radius: var(--radius-md);
    border: 1.5px solid var(--border-light);
    background: #fff;
    text-decoration: none;
    transition: var(--transition);
    gap: .5rem;
}
.category-card:hover {
    border-color: var(--cat-color);
    box-shadow: 0 6px 24px rgba(0,0,0,.08);
    transform: translateY(-4px);
}
.category-icon-wrap {
    width: 54px;
    height: 54px;
    border-radius: var(--radius-md);
    background: var(--cat-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: var(--cat-color);
    transition: var(--transition);
}
.category-card:hover .category-icon-wrap {
    background: var(--cat-color);
    color: #fff;
}
.category-name {
    font-size: .82rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.3;
}
.category-count {
    font-size: .7rem;
    color: var(--text-muted);
}


/* ── Product filter tabs ── */
.product-tabs { display: flex; gap: .35rem; background: #f0f2f5; padding: .3rem; border-radius: 50px; }
.product-tab {
    border: none;
    background: transparent;
    font-size: .8rem;
    font-weight: 600;
    color: var(--text-secondary);
    padding: .3rem .85rem;
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition);
}
.product-tab.active, .product-tab:hover {
    background: #fff;
    color: var(--brand-primary);
    box-shadow: var(--shadow-sm);
}


/* ── §4 VENDORS ── */
.vendor-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1.4rem 1rem;
    border-radius: var(--radius-md);
    border: 1.5px solid var(--border-light);
    background: #fff;
    text-decoration: none;
    transition: var(--transition);
    gap: .4rem;
}
.vendor-card:hover {
    border-color: var(--vendor-color);
    box-shadow: 0 6px 24px rgba(0,0,0,.09);
    transform: translateY(-4px);
}
.vendor-avatar { position: relative; margin-bottom: .25rem; }
.vendor-initials {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    letter-spacing: -.5px;
}
.vendor-verified {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 20px;
    height: 20px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #22c55e;
    font-size: .75rem;
}
.vendor-name {
    font-size: .875rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
}
.vendor-cat {
    font-size: .72rem;
    color: var(--text-muted);
    margin: 0;
}
.vendor-meta {
    display: flex;
    align-items: center;
    gap: .35rem;
    font-size: .72rem;
    color: var(--text-secondary);
}
.vendor-sep { color: var(--border-light); }

/* Sell promo bar */
.sell-promo-bar {
    background: linear-gradient(135deg, var(--brand-light), #fff);
    border: 1.5px solid rgba(240,79,35,.2);
    border-radius: var(--radius-lg);
    padding: 1.5rem 2rem;
}
.sell-promo-icon {
    width: 52px;
    height: 52px;
    background: var(--brand-primary);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.3rem;
    flex-shrink: 0;
}


/* ── §5 DEALS ── */
.deals-section {
    background: linear-gradient(135deg, #0f0f1a 0%, #1a1a35 60%, #0f0f1a 100%);
    position: relative;
    overflow: hidden;
}
.deals-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='1' fill='rgba(255,255,255,.04)'/%3E%3C/svg%3E");
    pointer-events: none;
}
.deals-section .section-title { color: #fff; }

/* Countdown */
.deals-countdown {
    display: flex;
    align-items: center;
    gap: .75rem;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: var(--radius-md);
    padding: .5rem 1rem;
}
.countdown-label {
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .7px;
    color: rgba(255,255,255,.5);
    font-weight: 600;
}
.countdown-timer { display: flex; align-items: center; gap: .3rem; }
.countdown-unit {
    text-align: center;
    min-width: 38px;
    background: rgba(240,79,35,.2);
    border: 1px solid rgba(240,79,35,.3);
    border-radius: 6px;
    padding: .25rem .4rem;
}
.countdown-unit span {
    display: block;
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.countdown-unit small {
    font-size: .58rem;
    color: rgba(255,255,255,.5);
    text-transform: uppercase;
    letter-spacing: .4px;
}
.countdown-colon {
    color: rgba(255,255,255,.4);
    font-size: 1.1rem;
    font-weight: 700;
}


/* ── §6 USP SECTION ── */
.usp-section {
    background: #fff;
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
}
.usp-row { border: 1px solid var(--border-light); border-radius: var(--radius-lg); overflow: hidden; }
.usp-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.6rem 1.5rem;
    border-right: 1px solid var(--border-light);
    transition: background .2s ease;
}
.usp-item:hover { background: var(--brand-light); }
.usp-icon {
    font-size: 1.75rem;
    color: var(--brand-primary);
    flex-shrink: 0;
}
.usp-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 .15rem;
}
.usp-desc { font-size: .78rem; color: var(--text-muted); margin: 0; }

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .section-pad { padding: 3.25rem 0; }
    .hero-carousel { max-height: 480px; }
    .hero-slide { min-height: 480px; }
    .hero-headline { font-size: 1.9rem; }
    .deals-countdown { display: none; }
    .sell-promo-bar { padding: 1.25rem; }
    .usp-item { padding: 1.1rem 1rem; gap: .7rem; border-right: none; border-bottom: 1px solid var(--border-light); }
    .usp-icon { font-size: 1.35rem; }
}
@media (max-width: 991.98px) {
    .product-tabs { display: none; }
    .row-cols-xl-8 > * { flex: 0 0 25%; max-width: 25%; }
}
</style>
@endpush


<!-- ============================================================
     PAGE SCRIPTS
============================================================ -->
@push('scripts')
<script>
/* ── Countdown Timer ── */
(function() {
    // Set end time: 8 hours from now
    const endTime = new Date(Date.now() + 8 * 60 * 60 * 1000);

    function updateCountdown() {
        const now  = new Date();
        const diff = Math.max(0, endTime - now);

        const h = String(Math.floor(diff / 3600000)).padStart(2, '0');
        const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
        const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');

        const hEl = document.getElementById('ctHours');
        const mEl = document.getElementById('ctMins');
        const sEl = document.getElementById('ctSecs');

        if (hEl) hEl.textContent = h;
        if (mEl) mEl.textContent = m;
        if (sEl) sEl.textContent = s;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
})();

/* ── Product Filter Tabs (client-side demo) ── */
document.querySelectorAll('.product-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.product-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        // In a real app: AJAX request or Livewire call here
    });
});
</script>
@endpush
