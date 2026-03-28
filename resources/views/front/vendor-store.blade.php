@extends('layouts.app')

@section('title', 'Shop with SoundZone PK — Vendo')
@section('meta_description', 'Discover premium electronics and accessories from SoundZone PK on Vendo.')

@php
/* ── DUMMY VENDOR DATA ── */
$vendor = [
    'id'          => 10,
    'name'        => 'SoundZone PK',
    'slug'        => 'soundzone-pk',
    'avatar'      => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=200',
    'banner'      => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&q=80&w=1200',
    'verified'    => true,
    'rating'      => 4.9,
    'reviewsCount'=> 3240,
    'joinedDate'  => 'March 2022',
    'totalSales'  => 12450,
    'productsAmt' => 142,
    'followers'   => 8500,
    'responseRate'=> '98%',
    'shipTime'    => '24 Hours',
    'description' => 'Your ultimate destination for premium audio gear in Pakistan. Official distributors for Sony, JBL, and Bose. We guarantee 100% authentic products with official brand warranties.',
    'categories'  => ['Headphones', 'Speakers', 'Earbuds', 'Microphones', 'Accessories'],
];

/* ── DUMMY PRODUCTS ── */
$products = [
    ['id'=>1, 'name'=>'Sony WH-1000XM5 Headphones','slug'=>'sony-wh-1000xm5','price'=>42999,'oldPrice'=>55999,'discount'=>23,'rating'=>4.8,'reviewsCount'=>1284,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=400','color'=>'#4f46e5','badge'=>'Bestseller','badgeType'=>'hot','inStock'=>true],
    ['id'=>2, 'name'=>'Sony WF-1000XM4 Earbuds','slug'=>'sony-wf-1000xm4','price'=>32000,'oldPrice'=>40000,'discount'=>20,'rating'=>4.7,'reviewsCount'=>432,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&q=80&w=400','color'=>'#0891b2','badge'=>'Sale','badgeType'=>'sale','inStock'=>true],
    ['id'=>3, 'name'=>'JBL Charge 5 Bluetooth Speaker','slug'=>'jbl-charge-5','price'=>28500,'oldPrice'=>null,'discount'=>null,'rating'=>4.9,'reviewsCount'=>890,'icon'=>'fa-speaker-deck','image'=>'https://images.unsplash.com/photo-1608043152269-41fa42981329?auto=format&fit=crop&q=80&w=400','color'=>'#dc2626','badge'=>null,'badgeType'=>null,'inStock'=>true],
    ['id'=>4, 'name'=>'Bose QuietComfort 45','slug'=>'bose-qc45','price'=>49999,'oldPrice'=>58000,'discount'=>14,'rating'=>4.6,'reviewsCount'=>788,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=400','color'=>'#16a34a','badge'=>null,'badgeType'=>null,'inStock'=>true],
    ['id'=>5, 'name'=>'JBL Tune 770NC Headphones','slug'=>'jbl-tune-770nc','price'=>14500,'oldPrice'=>18000,'discount'=>19,'rating'=>4.5,'reviewsCount'=>234,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&q=80&w=400','color'=>'#7c3aed','badge'=>'New','badgeType'=>'new','inStock'=>true],
    ['id'=>6, 'name'=>'Sony SRS-XB13 Portable Speaker','slug'=>'sony-srs-xb13','price'=>8500,'oldPrice'=>10500,'discount'=>19,'rating'=>4.7,'reviewsCount'=>512,'icon'=>'fa-speaker-deck','image'=>'https://images.unsplash.com/photo-1614169552197-0368ee7f0aa9?auto=format&fit=crop&q=80&w=400','color'=>'#eab308','badge'=>null,'badgeType'=>null,'inStock'=>true],
    ['id'=>7, 'name'=>'Bose SoundLink Flex','slug'=>'bose-soundlink-flex','price'=>24000,'oldPrice'=>27500,'discount'=>12,'rating'=>4.8,'reviewsCount'=>345,'icon'=>'fa-speaker-deck','image'=>'https://images.unsplash.com/photo-1612082823620-3b2d125fc7f1?auto=format&fit=crop&q=80&w=400','color'=>'#0284c7','badge'=>null,'badgeType'=>null,'inStock'=>false],
    ['id'=>8, 'name'=>'Sony Inzone H9 Gaming Headset','slug'=>'sony-inzone-h9','price'=>45000,'oldPrice'=>null,'discount'=>null,'rating'=>4.4,'reviewsCount'=>120,'icon'=>'fa-headset','image'=>'https://images.unsplash.com/photo-1615663245857-3205b90b1350?auto=format&fit=crop&q=80&w=400','color'=>'#ea580c','badge'=>'Gaming','badgeType'=>'hot','inStock'=>true],
];

@endphp

@section('content')

{{-- VENDOR BANNER --}}
<div class="vs-banner-section">
    {{-- Background Image/Gradient --}}
    <div class="vs-cover-img" 
         @if($vendor['banner']) 
         style="background-image:url('{{ asset($vendor['banner']) }}');" 
         @else 
         style="background: linear-gradient(135deg, var(--brand-dark), var(--brand-primary));"
         @endif>
    </div>

    <div class="container-xl">
        <div class="vs-profile-card">
            
            {{-- Avatar & Core Info --}}
            <div class="vs-avatar-col">
                <div class="vs-avatar" style="background:#4f46e5;">
                    @if($vendor['avatar'])
                        <img src="{{ asset($vendor['avatar']) }}" alt="{{ $vendor['name'] }}">
                    @else
                        SZ
                    @endif
                </div>
                <div class="vs-info-main">
                    <h1 class="vs-store-name">
                        {{ $vendor['name'] }}
                        @if($vendor['verified'])
                        <i class="fa fa-circle-check text-success ms-2 fs-6" title="Verified Seller"></i>
                        @endif
                    </h1>
                    <div class="vs-store-meta">
                        <span class="text-warning">
                            <i class="fa-solid fa-star"></i> {{ number_format($vendor['rating'], 1) }}
                        </span>
                        <span class="text-muted ms-1">({{ number_format($vendor['reviewsCount']) }} Reviews)</span>
                        <span class="vs-sep">·</span>
                        <span class="text-secondary"><i class="fa fa-users me-1"></i>{{ number_format($vendor['followers']) }} Followers</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="vs-actions-col">
                <button class="btn btn-brand vs-follow-btn" id="followBtn" onclick="toggleFollow(this)">
                    <i class="fa fa-plus me-2"></i> Follow Store
                </button>
                <button class="btn btn-outline-secondary vs-chat-btn">
                    <i class="fa-regular fa-comment-dots me-2"></i> Chat
                </button>
            </div>

        </div>
    </div>
</div>

{{-- VENDOR STATS BAR --}}
<div class="vs-stats-bar">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-4 g-3 g-md-0 text-center text-md-start">
            <div class="col vs-stat-item border-md-end">
                <i class="fa fa-box-open text-muted mb-1 mb-md-0 me-md-2 fs-5"></i>
                <div>
                    <strong class="d-block text-dark">{{ $vendor['productsAmt'] }}</strong>
                    <span class="text-muted fs-xs text-uppercase">Products</span>
                </div>
            </div>
            <div class="col vs-stat-item border-md-end">
                <i class="fa fa-reply text-muted mb-1 mb-md-0 me-md-2 fs-5"></i>
                <div>
                    <strong class="d-block text-dark">{{ $vendor['responseRate'] }}</strong>
                    <span class="text-muted fs-xs text-uppercase">Chat Response</span>
                </div>
            </div>
            <div class="col vs-stat-item border-md-end">
                <i class="fa fa-truck-fast text-muted mb-1 mb-md-0 me-md-2 fs-5"></i>
                <div>
                    <strong class="d-block text-dark">{{ $vendor['shipTime'] }}</strong>
                    <span class="text-muted fs-xs text-uppercase">Avg Ship Time</span>
                </div>
            </div>
            <div class="col vs-stat-item">
                <i class="fa fa-calendar-alt text-muted mb-1 mb-md-0 me-md-2 fs-5"></i>
                <div>
                    <strong class="d-block text-dark">{{ $vendor['joinedDate'] }}</strong>
                    <span class="text-muted fs-xs text-uppercase">Member Since</span>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MAIN CONTENT --}}
<section class="vs-content-section py-5">
    <div class="container-xl">
        
        <div class="row g-4 g-xl-5">

            {{-- ══ LEFT SIDEBAR: STORE INFO & FILTERS ══ --}}
            <div class="col-12 col-lg-3">
                
                {{-- Store About --}}
                <div class="vs-sidebar-box mb-4">
                    <h5 class="vs-sb-title">About Store</h5>
                    <p class="vs-sb-text">{{ $vendor['description'] }}</p>
                    <hr class="my-3 border-light">
                    <div class="d-flex align-items-center text-secondary fs-sm mb-2">
                        <i class="fa fa-chart-line w-20px text-center me-2"></i> 
                        {{ number_format($vendor['totalSales']) }} Total Sales
                    </div>
                    <div class="d-flex align-items-center text-secondary fs-sm">
                        <i class="fa fa-shield-halved w-20px text-center me-2"></i> 
                        100% Authentic Brands
                    </div>
                </div>

                {{-- Search Store --}}
                <div class="vs-sidebar-box mb-4">
                    <h5 class="vs-sb-title">Search Store</h5>
                    <div class="position-relative">
                        <input type="text" class="form-control vs-search-input" placeholder="Search products...">
                        <i class="fa fa-search vs-search-icon"></i>
                    </div>
                </div>

                {{-- Categories --}}
                <div class="vs-sidebar-box">
                    <h5 class="vs-sb-title">Store Categories</h5>
                    <ul class="vs-cat-list">
                        <li>
                            <a href="#" class="active"><i class="fa-solid fa-angle-right me-2"></i>All Products</a>
                        </li>
                        @foreach($vendor['categories'] as $cat)
                        <li>
                            <a href="#"><i class="fa-solid fa-angle-right me-2"></i>{{ $cat }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            {{-- ══ RIGHT SIDE: PRODUCTS ══ --}}
            <div class="col-12 col-lg-9">
                
                {{-- Toolbar --}}
                <div class="vs-toolbar d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-4 gap-3">
                    <h3 class="fs-5 fw-800 text-dark mb-0">All Products <span class="text-muted fw-normal fs-6">({{ count($products) }})</span></h3>
                    
                    <div class="d-flex align-items-center gap-3">
                        <select class="form-select form-select-sm vs-sort-select" style="min-width:160px;">
                            <option value="featured">Sort by: Featured</option>
                            <option value="newest">Sort by: Newest Arrivals</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="rating">Top Rated</option>
                        </select>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-md-4">
                    @foreach($products as $prod)
                    <div class="col">
                        <x-product-card
                            :id="$prod['id']" :name="$prod['name']" :slug="$prod['slug']"
                            :price="$prod['price']" :oldPrice="$prod['oldPrice']??null"
                            :discount="$prod['discount']??null" :rating="$prod['rating']"
                            :reviewsCount="$prod['reviewsCount']" :icon="$prod['icon']"
                            :badge="$prod['badge']??null" :badgeType="$prod['badgeType']??'sale'"
                            :vendorId="$vendor['id']" :vendorName="$vendor['name']"
                            :vendorSlug="$vendor['slug']" :inStock="$prod['inStock']"
                        />
                    </div>
                    @endforeach
                </div>

                {{-- Pagination (Placeholder) --}}
                <div class="d-flex justify-content-center mt-5">
                    <button class="btn btn-outline-brand px-4 py-2 fw-bold">Load More Products</button>
                </div>

            </div>

        </div>{{-- /row --}}

    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Store Banner ── */
.vs-banner-section { position: relative; background: #fdfdfd; margin-bottom: 2rem; }

.vs-cover-img {
    height: 220px; width: 100%;
    background-size: cover; background-position: center;
    position: relative;
}
/* Overlay for contrast */
.vs-cover-img::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%);
}

.vs-profile-card {
    background: #fff; border-radius: var(--radius-lg);
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 1.5rem 2rem;
    position: relative; z-index: 10; margin-top: -60px;
    display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem;
}

.vs-avatar-col { display: flex; align-items: center; gap: 1.5rem; flex: 1; min-width: 300px; }
.vs-avatar {
    width: 90px; height: 90px; border-radius: 50%;
    border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,.1);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 2rem; font-weight: 800; overflow: hidden;
    flex-shrink: 0;
}
.vs-avatar img { width: 100%; height: 100%; object-fit: cover; }

.vs-info-main { display: flex; flex-direction: column; gap: .25rem; }
.vs-store-name { font-size: 1.6rem; font-weight: 800; color: var(--text-primary); margin: 0; letter-spacing: -.5px; }
.vs-store-meta { font-size: .85rem; font-weight: 600; display: flex; align-items: center; flex-wrap: wrap; gap: .4rem; }
.vs-sep { color: var(--border-light); margin: 0 .25rem; }

.vs-actions-col { display: flex; gap: .75rem; }
.vs-follow-btn { width: 140px; font-weight: 700; transition: var(--transition); }
.vs-follow-btn.following { background: #f0fdf4; color: #16a34a; border: 1px solid #16a34a; box-shadow: none; }
.vs-chat-btn { font-weight: 600; }

/* ── Store Stats Bar ── */
.vs-stats-bar { background: #fff; border-bottom: 1px solid var(--border-light); padding: 1.25rem 0; margin-top: -2rem; }
.vs-stat-item { display: flex; align-items: center; justify-content: center; padding: 0 1rem; }
.border-md-end { border-right: 1px solid var(--border-light); }
.fs-xs { font-size: .7rem; }

/* ── Content Area ── */
.vs-content-section { background: #f7f8fa; }

/* Sidebar */
.vs-sidebar-box {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-md); padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,.02);
}
.vs-sb-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem; }
.vs-sb-text { font-size: .85rem; color: var(--text-secondary); line-height: 1.6; margin: 0; }

/* Search Input */
.vs-search-input {
    padding: .65rem 1rem .65rem 2.5rem; border: 1.5px solid var(--border-light);
    font-size: .85rem; border-radius: 50px; outline: none; transition: border-color .2s;
}
.vs-search-input:focus { border-color: var(--brand-primary); box-shadow: none; }
.vs-search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: .85rem; }

/* Cat List */
.vs-cat-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .5rem; }
.vs-cat-list li a {
    display: flex; align-items: center; font-size: .85rem; font-weight: 600;
    color: var(--text-secondary); text-decoration: none; padding: .4rem 0;
    transition: var(--transition);
}
.vs-cat-list li a i { font-size: .7rem; opacity: .5; transition: transform .2s; }
.vs-cat-list li a:hover { color: var(--brand-primary); }
.vs-cat-list li a:hover i { transform: translateX(4px); opacity: 1; color: var(--brand-primary); }
.vs-cat-list li a.active { color: var(--brand-primary); font-weight: 700; }
.vs-cat-list li a.active i { opacity: 1; color: var(--brand-primary); }

/* Toolbar */
.vs-toolbar {
    background: #fff; padding: 1rem 1.25rem;
    border: 1px solid var(--border-light); border-radius: var(--radius-md);
    box-shadow: 0 2px 10px rgba(0,0,0,.02);
}
.vs-sort-select {
    border: 1px solid var(--border-light); font-size: .85rem; font-weight: 600;
    color: var(--text-secondary); cursor: pointer; background-color:#f9fafb;
}
.vs-sort-select:focus { border-color: var(--brand-primary); box-shadow: none; }


/* ── Responsive ── */
@media (max-width: 991.98px) {
    .vs-profile-card { margin-top: -40px; }
    .vs-stats-bar { margin-top: -1rem; }
}

@media (max-width: 767.98px) {
    .vs-stat-item { flex-direction: column; text-align: center; gap: .5rem; padding: 1rem; }
    .border-md-end { border-right: none; }
    .vs-stats-bar .row > div:nth-child(1), .vs-stats-bar .row > div:nth-child(2) { border-bottom: 1px solid var(--border-light); }
    .vs-stats-bar .row > div:nth-child(odd) { border-right: 1px solid var(--border-light); }
    
    .vs-actions-col { width: 100%; }
    .vs-actions-col button { flex: 1; }
}
</style>
@endpush

@push('scripts')
<script>
function toggleFollow(btn) {
    const isFollowing = btn.classList.contains('following');
    if (isFollowing) {
        btn.classList.remove('following');
        btn.innerHTML = '<i class="fa fa-plus me-2"></i> Follow Store';
    } else {
        btn.classList.add('following');
        btn.innerHTML = '<i class="fa fa-check me-2"></i> Following';
    }
}
</script>
@endpush
