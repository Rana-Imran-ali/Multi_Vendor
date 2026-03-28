@extends('layouts.app')

@section('title', 'Shop — Browse All Products | Vendo')
@section('meta_description', 'Browse thousands of products across all categories on Vendo. Filter by price, rating, category and more.')

{{-- ============================================================
     SHOP PAGE — front/shop.blade.php
     Sections:
       - Page header breadcrumb
       - Sidebar: search, category, price, rating, brand filters
       - Product grid with sorting, view toggle, active filters
     All data is dummy — replace with controller variables.
============================================================ --}}

@php
/* ── DUMMY DATA ─────────────────────────────────────────── */
$totalResults = 284;

$categories = [
    ['name'=>'All Products',   'slug'=>'',             'count'=>284, 'active'=>true ],
    ['name'=>'Electronics',    'slug'=>'electronics',   'count'=>92,  'active'=>false],
    ['name'=>'Fashion',        'slug'=>'fashion',       'count'=>74,  'active'=>false],
    ['name'=>'Home & Living',  'slug'=>'home-living',   'count'=>48,  'active'=>false],
    ['name'=>'Beauty',         'slug'=>'beauty',        'count'=>31,  'active'=>false],
    ['name'=>'Sports',         'slug'=>'sports',        'count'=>19,  'active'=>false],
    ['name'=>'Books',          'slug'=>'books',         'count'=>12,  'active'=>false],
    ['name'=>'Automotive',     'slug'=>'automotive',    'count'=>8,   'active'=>false],
];

$brands = ['Apple','Samsung','Nike','Sony','Adidas','Xiaomi','Dyson','IKEA','L\'Oréal','Levi\'s'];

$products = [
    ['id'=>1, 'name'=>'Sony WH-1000XM5 Headphones',        'slug'=>'sony-wh-1000xm5',     'price'=>42999, 'oldPrice'=>55999, 'discount'=>23, 'rating'=>5, 'reviewsCount'=>1284,'icon'=>'fa-headphones',     'image'=>'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=400', 'badge'=>'Best Seller','badgeType'=>'hot',      'vendorId'=>10,'vendorName'=>'SoundZone PK', 'vendorSlug'=>'soundzone-pk','inStock'=>true ],
    ['id'=>2, 'name'=>'Nike Air Max 270 Running Shoes',     'slug'=>'nike-air-max-270',     'price'=>18500, 'oldPrice'=>24000, 'discount'=>23, 'rating'=>4, 'reviewsCount'=>832, 'icon'=>'fa-shoe-prints',    'image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=400', 'badge'=>'New',        'badgeType'=>'new',      'vendorId'=>11,'vendorName'=>'SportsHub',    'vendorSlug'=>'sportshub',   'inStock'=>true ],
    ['id'=>3, 'name'=>'Xiaomi 4K Android TV — 55"',         'slug'=>'xiaomi-4k-tv-55',      'price'=>89900, 'oldPrice'=>110000,'discount'=>18, 'rating'=>4, 'reviewsCount'=>521, 'icon'=>'fa-tv',             'image'=>'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&q=80&w=400', 'badge'=>'Hot Deal',   'badgeType'=>'sale',     'vendorId'=>12,'vendorName'=>'TechMart PK',  'vendorSlug'=>'techmart-pk', 'inStock'=>true ],
    ['id'=>4, 'name'=>'L\'Oréal Revitalift Serum — 30ml',   'slug'=>'loreal-revitalift',    'price'=>3200,  'oldPrice'=>4300,  'discount'=>26, 'rating'=>4, 'reviewsCount'=>378, 'icon'=>'fa-flask',          'image'=>'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&q=80&w=400', 'badge'=>'Sale',       'badgeType'=>'sale',     'vendorId'=>13,'vendorName'=>'GlowStore',   'vendorSlug'=>'glowstore',   'inStock'=>true ],
    ['id'=>5, 'name'=>'Hamilton Beach Stand Mixer 4.5 Qt',  'slug'=>'hamilton-beach-mixer', 'price'=>12800, 'oldPrice'=>null,  'discount'=>null,'rating'=>5,'reviewsCount'=>204, 'icon'=>'fa-blender',        'image'=>'https://images.unsplash.com/photo-1596738148858-6bb7f28edde2?auto=format&fit=crop&q=80&w=400', 'badge'=>'New',        'badgeType'=>'new',      'vendorId'=>14,'vendorName'=>'HomeChef',    'vendorSlug'=>'homechef',    'inStock'=>true ],
    ['id'=>6, 'name'=>'Samsung Galaxy A55 — 8/256GB',       'slug'=>'samsung-galaxy-a55',   'price'=>74999, 'oldPrice'=>82000, 'discount'=>10, 'rating'=>4, 'reviewsCount'=>967, 'icon'=>'fa-mobile-screen',  'image'=>'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&q=80&w=400', 'badge'=>'Sale',       'badgeType'=>'sale',     'vendorId'=>12,'vendorName'=>'TechMart PK',  'vendorSlug'=>'techmart-pk', 'inStock'=>true ],
    ['id'=>7, 'name'=>'IKEA ALEX Desk Drawer Unit',         'slug'=>'ikea-alex-drawer',     'price'=>24500, 'oldPrice'=>null,  'discount'=>null,'rating'=>4,'reviewsCount'=>156, 'icon'=>'fa-table-columns',  'image'=>'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&q=80&w=400', 'badge'=>null,         'badgeType'=>null,       'vendorId'=>15,'vendorName'=>'FurnishAll',  'vendorSlug'=>'furnishall',  'inStock'=>true ],
    ['id'=>8, 'name'=>'Adidas Ultraboost 22 Shoes',         'slug'=>'adidas-ultraboost-22', 'price'=>27999, 'oldPrice'=>34999, 'discount'=>20, 'rating'=>5, 'reviewsCount'=>642, 'icon'=>'fa-shoe-prints',    'image'=>'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&q=80&w=400', 'badge'=>'Featured',   'badgeType'=>'featured', 'vendorId'=>11,'vendorName'=>'SportsHub',    'vendorSlug'=>'sportshub',   'inStock'=>false],
    ['id'=>9, 'name'=>'Apple AirPods Pro 2nd Gen',          'slug'=>'airpods-pro-2',        'price'=>44999, 'oldPrice'=>64999, 'discount'=>31, 'rating'=>5, 'reviewsCount'=>2101,'icon'=>'fa-headphones',     'image'=>'https://images.unsplash.com/photo-1606220588913-b3eea405b550?auto=format&fit=crop&q=80&w=400', 'badge'=>'Flash Sale', 'badgeType'=>'hot',      'vendorId'=>12,'vendorName'=>'TechMart PK',  'vendorSlug'=>'techmart-pk', 'inStock'=>true ],
    ['id'=>10,'name'=>'Dyson V12 Detect Slim Vacuum',       'slug'=>'dyson-v12',            'price'=>78000, 'oldPrice'=>105000,'discount'=>26, 'rating'=>5, 'reviewsCount'=>894, 'icon'=>'fa-broom',          'image'=>'https://images.unsplash.com/photo-1558317374-067fb5f300cb?auto=format&fit=crop&q=80&w=400', 'badge'=>'Flash Sale', 'badgeType'=>'hot',      'vendorId'=>15,'vendorName'=>'FurnishAll',  'vendorSlug'=>'furnishall',  'inStock'=>true ],
    ['id'=>11,'name'=>'Levi\'s 511 Slim Fit Jeans',         'slug'=>'levis-511',            'price'=>6500,  'oldPrice'=>9500,  'discount'=>32, 'rating'=>4, 'reviewsCount'=>1530,'icon'=>'fa-shirt',          'image'=>'https://images.unsplash.com/photo-1542272604-78016ec485ec?auto=format&fit=crop&q=80&w=400', 'badge'=>'Flash Sale', 'badgeType'=>'hot',      'vendorId'=>11,'vendorName'=>'SportsHub',    'vendorSlug'=>'sportshub',   'inStock'=>true ],
    ['id'=>12,'name'=>'Nescafé Gold Blend — 200g Tin',      'slug'=>'nescafe-gold-200',     'price'=>1899,  'oldPrice'=>2500,  'discount'=>24, 'rating'=>4, 'reviewsCount'=>672, 'icon'=>'fa-mug-hot',        'image'=>'https://images.unsplash.com/photo-1559525839-b184a4d698c7?auto=format&fit=crop&q=80&w=400', 'badge'=>'Flash Sale', 'badgeType'=>'hot',      'vendorId'=>16,'vendorName'=>'GroceryBox',  'vendorSlug'=>'grocerybox',  'inStock'=>true ],
];

$sortOptions = [
    'featured'    => 'Featured',
    'newest'      => 'Newest First',
    'price_asc'   => 'Price: Low to High',
    'price_desc'  => 'Price: High to Low',
    'rating'      => 'Top Rated',
    'bestselling' => 'Best Selling',
];
$currentSort = request('sort', 'featured');
@endphp

@section('content')

{{-- ===== BREADCRUMB & PAGE HEADER ===== --}}
<div class="shop-header">
    <div class="container-xl">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="shop-page-title">Shop</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb shop-breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
            <div class="shop-header-right d-none d-md-flex align-items-center gap-2">
                <span class="results-badge">
                    <i class="fa fa-box-open me-1"></i>
                    <strong>{{ number_format($totalResults) }}</strong> Products Found
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ===== MAIN SHOP LAYOUT ===== --}}
<div class="shop-layout">
    <div class="container-xl">
        <div class="row g-4">

            {{-- ====================================================
                 SIDEBAR — Filters
            ==================================================== --}}
            <div class="col-12 col-lg-3" id="shopSidebar">
                <div class="sidebar-wrap">

                    {{-- ── Sidebar Header ── --}}
                    <div class="sidebar-header">
                        <span class="sidebar-title"><i class="fa fa-sliders me-2"></i>Filters</span>
                        <button class="sidebar-clear-btn" id="clearAllFilters" type="button">Clear All</button>
                    </div>

                    {{-- ── Search within results ── --}}
                    <div class="filter-block">
                        <div class="filter-search-box">
                            <i class="fa fa-magnifying-glass"></i>
                            <input
                                type="text"
                                id="productSearchInput"
                                placeholder="Search products…"
                                class="filter-search-input"
                                value="{{ request('q') }}"
                            >
                        </div>
                    </div>

                    {{-- ── Categories ── --}}
                    <div class="filter-block">
                        <button class="filter-heading" data-bs-toggle="collapse" data-bs-target="#filterCategories" aria-expanded="true">
                            <span>Category</span>
                            <i class="fa fa-chevron-down filter-chevron"></i>
                        </button>
                        <div class="collapse show" id="filterCategories">
                            <ul class="filter-category-list">
                                @foreach($categories as $cat)
                                <li>
                                    <a href="{{ url('/shop' . ($cat['slug'] ? '?category='.$cat['slug'] : '')) }}"
                                       class="filter-cat-link {{ $cat['active'] ? 'active' : '' }}">
                                        <span class="filter-cat-name">{{ $cat['name'] }}</span>
                                        <span class="filter-cat-count">{{ $cat['count'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- ── Price Range ── --}}
                    <div class="filter-block">
                        <button class="filter-heading" data-bs-toggle="collapse" data-bs-target="#filterPrice" aria-expanded="true">
                            <span>Price Range</span>
                            <i class="fa fa-chevron-down filter-chevron"></i>
                        </button>
                        <div class="collapse show" id="filterPrice">
                            <div class="price-range-wrap">
                                <div class="price-display">
                                    <div class="price-display-box">
                                        <small>Min</small>
                                        <span id="priceMinLabel">Rs 0</span>
                                    </div>
                                    <div class="price-display-sep">—</div>
                                    <div class="price-display-box">
                                        <small>Max</small>
                                        <span id="priceMaxLabel">Rs 120,000</span>
                                    </div>
                                </div>
                                <div class="range-slider-wrap">
                                    <input type="range" class="form-range price-range" id="priceMin"
                                           min="0" max="120000" step="500" value="0">
                                    <input type="range" class="form-range price-range" id="priceMax"
                                           min="0" max="120000" step="500" value="120000">
                                </div>
                                <div class="price-preset-chips">
                                    <button class="price-chip active" data-min="0"      data-max="120000">All</button>
                                    <button class="price-chip"        data-min="0"      data-max="5000">Under 5k</button>
                                    <button class="price-chip"        data-min="5000"   data-max="25000">5k–25k</button>
                                    <button class="price-chip"        data-min="25000"  data-max="75000">25k–75k</button>
                                    <button class="price-chip"        data-min="75000"  data-max="120000">75k+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Rating ── --}}
                    <div class="filter-block">
                        <button class="filter-heading" data-bs-toggle="collapse" data-bs-target="#filterRating" aria-expanded="true">
                            <span>Customer Rating</span>
                            <i class="fa fa-chevron-down filter-chevron"></i>
                        </button>
                        <div class="collapse show" id="filterRating">
                            <div class="rating-filter-list">
                                @foreach([5,4,3,2,1] as $star)
                                <label class="rating-filter-row">
                                    <input type="radio" name="rating" value="{{ $star }}" class="rating-radio">
                                    <div class="rating-stars-display">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $star ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="rating-label">{{ $star === 5 ? '5 Stars' : $star.'+ Stars' }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- ── Brands ── --}}
                    <div class="filter-block">
                        <button class="filter-heading" data-bs-toggle="collapse" data-bs-target="#filterBrands" aria-expanded="false">
                            <span>Brand</span>
                            <i class="fa fa-chevron-down filter-chevron"></i>
                        </button>
                        <div class="collapse" id="filterBrands">
                            <div class="brand-filter-list" id="brandList">
                                @foreach($brands as $index => $brand)
                                <label class="brand-checkbox-row {{ $index >= 6 ? 'brand-extra d-none' : '' }}">
                                    <input type="checkbox" class="brand-checkbox" value="{{ \Illuminate\Support\Str::slug($brand) }}">
                                    <span class="brand-checkbox-mark"></span>
                                    <span class="brand-label">{{ $brand }}</span>
                                </label>
                                @endforeach
                            </div>
                            <button class="show-more-btn" id="toggleBrands">
                                Show more <i class="fa fa-chevron-down ms-1" style="font-size:.65rem;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ── Availability ── --}}
                    <div class="filter-block border-0 pb-0">
                        <button class="filter-heading" data-bs-toggle="collapse" data-bs-target="#filterAvail" aria-expanded="true">
                            <span>Availability</span>
                            <i class="fa fa-chevron-down filter-chevron"></i>
                        </button>
                        <div class="collapse show" id="filterAvail">
                            <div class="avail-toggle-list">
                                <label class="toggle-switch-row">
                                    <span class="toggle-label">In Stock Only</span>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input avail-toggle" type="checkbox" role="switch" id="inStockToggle">
                                    </div>
                                </label>
                                <label class="toggle-switch-row">
                                    <span class="toggle-label">On Sale</span>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input avail-toggle" type="checkbox" role="switch" id="onSaleToggle">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- ── Apply Button (mobile) ── --}}
                    <div class="sidebar-apply-wrap d-lg-none">
                        <button class="btn btn-brand w-100" data-bs-dismiss="offcanvas" id="applyFiltersBtn">
                            Apply Filters
                        </button>
                    </div>

                </div>{{-- /.sidebar-wrap --}}
            </div>{{-- /sidebar col --}}


            {{-- ====================================================
                 MAIN CONTENT — Toolbar + Product Grid
            ==================================================== --}}
            <div class="col-12 col-lg-9">

                {{-- ── Toolbar ── --}}
                <div class="shop-toolbar">
                    <div class="toolbar-left">
                        {{-- Mobile filter trigger --}}
                        <button class="btn btn-outline-secondary shop-filter-toggle d-lg-none" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                            <i class="fa fa-sliders me-2"></i> Filters
                        </button>
                        {{-- Results count --}}
                        <p class="toolbar-count mb-0">
                            Showing <strong>1–{{ min(12, $totalResults) }}</strong> of <strong>{{ number_format($totalResults) }}</strong> results
                        </p>
                    </div>
                    <div class="toolbar-right">
                        {{-- Sort --}}
                        <div class="sort-wrap">
                            <label for="sortSelect" class="sort-label d-none d-md-inline">Sort:</label>
                            <select class="sort-select" id="sortSelect" name="sort">
                                @foreach($sortOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $currentSort === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- View toggle --}}
                        <div class="view-toggle-btns">
                            <button class="view-btn active" id="gridView" title="Grid View">
                                <i class="fa fa-grip"></i>
                            </button>
                            <button class="view-btn" id="listView" title="List View">
                                <i class="fa fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ── Active Filter Tags ── --}}
                <div class="active-filters" id="activeFilters">
                    <span class="active-filter-tag">
                        Electronics
                        <button type="button" class="af-remove"><i class="fa fa-xmark"></i></button>
                    </span>
                    <span class="active-filter-tag">
                        Under Rs 50,000
                        <button type="button" class="af-remove"><i class="fa fa-xmark"></i></button>
                    </span>
                    <span class="active-filter-tag">
                        4+ Stars
                        <button type="button" class="af-remove"><i class="fa fa-xmark"></i></button>
                    </span>
                    <button class="af-clear-all" type="button">Clear All</button>
                </div>

                {{-- ── PRODUCT GRID ── --}}
                <div class="row g-3 g-md-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-xl-3" id="productGrid">
                    @foreach($products as $product)
                    <div class="col product-grid-item">
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

                {{-- ── Pagination ── --}}
                <nav class="shop-pagination" aria-label="Product pages">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <span class="page-link pg-link"><i class="fa fa-chevron-left"></i></span>
                        </li>
                        <li class="page-item active"><a class="page-link pg-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link pg-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link pg-link" href="#">3</a></li>
                        <li class="page-item"><span class="page-link pg-link pg-ellipsis">…</span></li>
                        <li class="page-item"><a class="page-link pg-link" href="#">24</a></li>
                        <li class="page-item">
                            <a class="page-link pg-link" href="#"><i class="fa fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>

            </div>{{-- /main col --}}
        </div>{{-- /row --}}
    </div>{{-- /container --}}
</div>{{-- /.shop-layout --}}


{{-- ===== MOBILE FILTER OFFCANVAS ===== --}}
<div class="offcanvas offcanvas-start filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">
            <i class="fa fa-sliders me-2" style="color:var(--brand-primary);"></i>Filters
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        {{-- The sidebar content is cloned here via JS for mobile --}}
        <div id="mobileSidebarClone"></div>
    </div>
</div>

@endsection


@push('styles')
<style>

/* ============================================================
   SHOP HEADER
============================================================ */
.shop-header {
    background: linear-gradient(135deg, #fff 0%, #f7f8fa 100%);
    border-bottom: 1px solid var(--border-light);
    padding: 1.6rem 0 1.4rem;
}
.shop-page-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0 0 .3rem;
    letter-spacing: -.4px;
}
.shop-breadcrumb { --bs-breadcrumb-divider: '/'; }
.shop-breadcrumb .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }
.shop-breadcrumb a { color: var(--brand-primary); font-size: .82rem; text-decoration: none; }
.shop-breadcrumb a:hover { text-decoration: underline; }
.shop-breadcrumb .active { font-size: .82rem; color: var(--text-muted); }

.results-badge {
    background: var(--brand-light);
    border: 1.5px solid rgba(240,79,35,.2);
    color: var(--brand-primary);
    font-size: .8rem;
    font-weight: 600;
    padding: .4rem .9rem;
    border-radius: 50px;
}


/* ============================================================
   SHOP LAYOUT
============================================================ */
.shop-layout {
    padding: 2rem 0 4rem;
    background: #f7f8fa;
    min-height: 60vh;
}


/* ============================================================
   SIDEBAR
============================================================ */
.sidebar-wrap {
    background: #fff;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    overflow: hidden;
    position: sticky;
    top: 80px;
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.25rem;
    border-bottom: 1px solid var(--border-light);
}
.sidebar-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-primary);
}
.sidebar-clear-btn {
    background: none;
    border: none;
    font-size: .78rem;
    font-weight: 600;
    color: var(--brand-primary);
    cursor: pointer;
    padding: 0;
    transition: opacity .15s;
}
.sidebar-clear-btn:hover { opacity: .7; }

/* Filter blocks */
.filter-block {
    border-bottom: 1px solid var(--border-light);
    padding: 1rem 1.25rem;
}

/* Filter heading button */
.filter-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    background: none;
    border: none;
    padding: 0;
    font-size: .85rem;
    font-weight: 700;
    color: var(--text-primary);
    cursor: pointer;
    margin-bottom: .85rem;
    transition: color .15s;
}
.filter-heading:hover { color: var(--brand-primary); }
.filter-chevron {
    font-size: .65rem;
    color: var(--text-muted);
    transition: transform .25s ease;
}
.filter-heading[aria-expanded="false"] .filter-chevron { transform: rotate(-90deg); }

/* Search inside sidebar */
.filter-search-box {
    display: flex;
    align-items: center;
    gap: .6rem;
    background: #f5f6f8;
    border: 1.5px solid var(--border-light);
    border-radius: var(--radius-sm);
    padding: .5rem .85rem;
    transition: border-color .2s;
}
.filter-search-box:focus-within { border-color: var(--brand-primary); background: #fff; }
.filter-search-box > i { color: var(--text-muted); font-size: .85rem; }
.filter-search-input {
    border: none;
    background: transparent;
    outline: none;
    font-size: .85rem;
    color: var(--text-primary);
    width: 100%;
    font-family: var(--font-base);
}

/* Category filter list */
.filter-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: .2rem;
}
.filter-cat-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .45rem .7rem;
    border-radius: var(--radius-sm);
    font-size: .84rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all .18s;
}
.filter-cat-link:hover, .filter-cat-link.active {
    background: var(--brand-light);
    color: var(--brand-primary);
}
.filter-cat-link.active { font-weight: 600; }
.filter-cat-count {
    font-size: .72rem;
    color: var(--text-muted);
    background: #f0f2f5;
    padding: 1px 6px;
    border-radius: 50px;
}
.filter-cat-link.active .filter-cat-count { background: rgba(240,79,35,.12); color: var(--brand-primary); }

/* Price range */
.price-range-wrap { display: flex; flex-direction: column; gap: .85rem; }
.price-display {
    display: flex;
    align-items: center;
    gap: .5rem;
}
.price-display-box {
    flex: 1;
    background: #f5f6f8;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-sm);
    padding: .4rem .65rem;
    text-align: center;
}
.price-display-box small {
    display: block;
    font-size: .62rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 1px;
}
.price-display-box span {
    font-size: .82rem;
    font-weight: 700;
    color: var(--text-primary);
}
.price-display-sep { color: var(--text-muted); font-size: .85rem; }

.range-slider-wrap { position: relative; height: 28px; margin: .25rem 0; }
.price-range {
    position: absolute;
    width: 100%;
    pointer-events: none;
    -webkit-appearance: none;
    background: transparent;
    height: 4px;
    top: 50%;
    transform: translateY(-50%);
    accent-color: var(--brand-primary);
    pointer-events: auto;
    outline: none;
}
.price-preset-chips { display: flex; flex-wrap: wrap; gap: .35rem; }
.price-chip {
    font-size: .72rem;
    font-weight: 600;
    padding: .22rem .6rem;
    border-radius: 50px;
    border: 1.5px solid var(--border-light);
    background: transparent;
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
}
.price-chip:hover, .price-chip.active {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}

/* Rating filter */
.rating-filter-list { display: flex; flex-direction: column; gap: .3rem; }
.rating-filter-row {
    display: flex;
    align-items: center;
    gap: .6rem;
    cursor: pointer;
    padding: .35rem .5rem;
    border-radius: var(--radius-sm);
    transition: background .15s;
}
.rating-filter-row:hover { background: #f7f8fa; }
.rating-radio { accent-color: var(--brand-primary); cursor: pointer; }
.rating-stars-display { color: #f59e0b; font-size: .8rem; display: flex; gap: 1px; }
.rating-label { font-size: .8rem; color: var(--text-secondary); }

/* Brand checkboxes */
.brand-filter-list { display: flex; flex-direction: column; gap: .3rem; margin-bottom: .65rem; }
.brand-checkbox-row {
    display: flex;
    align-items: center;
    gap: .65rem;
    cursor: pointer;
    padding: .3rem .4rem;
    border-radius: var(--radius-sm);
    transition: background .15s;
}
.brand-checkbox-row:hover { background: #f7f8fa; }
.brand-checkbox { display: none; }
.brand-checkbox-mark {
    width: 16px;
    height: 16px;
    border: 1.5px solid #c8ced8;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--transition);
}
.brand-checkbox:checked + .brand-checkbox-mark {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
}
.brand-checkbox:checked + .brand-checkbox-mark::after {
    content: '\f00c';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #fff;
    font-size: .6rem;
}
.brand-label { font-size: .82rem; color: var(--text-secondary); }

.show-more-btn {
    background: none;
    border: none;
    font-size: .78rem;
    font-weight: 600;
    color: var(--brand-primary);
    cursor: pointer;
    padding: 0;
    display: block;
    margin-top: .3rem;
}
.show-more-btn:hover { text-decoration: underline; }

/* Availability toggles */
.avail-toggle-list { display: flex; flex-direction: column; gap: .5rem; }
.toggle-switch-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}
.toggle-label { font-size: .84rem; color: var(--text-secondary); }
.avail-toggle { cursor: pointer; }
.avail-toggle:checked { background-color: var(--brand-primary); border-color: var(--brand-primary); }

.sidebar-apply-wrap { padding: 1rem 1.25rem; }


/* ============================================================
   TOOLBAR
============================================================ */
.shop-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    padding: .7rem 1rem;
    margin-bottom: 1rem;
    gap: .75rem;
    flex-wrap: wrap;
}
.toolbar-left { display: flex; align-items: center; gap: .75rem; }
.toolbar-right { display: flex; align-items: center; gap: .65rem; }

.shop-filter-toggle {
    font-size: .82rem;
    font-weight: 600;
    border-radius: var(--radius-sm);
    padding: .4rem .85rem;
    border-color: var(--border-light);
    color: var(--text-secondary);
}
.toolbar-count { font-size: .84rem; color: var(--text-muted); }
.toolbar-count strong { color: var(--text-primary); }

/* Sort dropdown */
.sort-wrap { display: flex; align-items: center; gap: .5rem; }
.sort-label { font-size: .82rem; color: var(--text-muted); font-weight: 500; white-space: nowrap; }
.sort-select {
    border: 1.5px solid var(--border-light);
    border-radius: var(--radius-sm);
    padding: .35rem .75rem;
    font-size: .82rem;
    font-family: var(--font-base);
    color: var(--text-primary);
    background: #fff;
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
    appearance: auto;
}
.sort-select:focus { border-color: var(--brand-primary); }

/* View toggle */
.view-toggle-btns { display: flex; gap: .3rem; }
.view-btn {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--border-light);
    background: #fff;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    cursor: pointer;
    transition: var(--transition);
}
.view-btn.active, .view-btn:hover {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}


/* ============================================================
   ACTIVE FILTER TAGS
============================================================ */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
    margin-bottom: 1.25rem;
}
.active-filter-tag {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--brand-light);
    border: 1px solid rgba(240,79,35,.25);
    color: var(--brand-primary);
    font-size: .78rem;
    font-weight: 600;
    padding: .3rem .7rem;
    border-radius: 50px;
}
.af-remove {
    background: none;
    border: none;
    padding: 0;
    color: var(--brand-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    opacity: .7;
    font-size: .72rem;
    transition: opacity .15s;
}
.af-remove:hover { opacity: 1; }
.af-clear-all {
    background: none;
    border: none;
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0 .25rem;
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color .15s;
}
.af-clear-all:hover { color: var(--text-primary); }


/* ============================================================
   LIST VIEW (toggled)
============================================================ */
#productGrid.list-mode {
    display: flex !important;
    flex-direction: column;
    gap: 1rem;
}
#productGrid.list-mode > .col {
    flex: 0 0 100%;
    max-width: 100%;
    width: 100%;
}
#productGrid.list-mode .pc-card {
    flex-direction: row;
    height: auto;
}
#productGrid.list-mode .pc-image-wrap {
    width: 180px;
    min-width: 180px;
    aspect-ratio: 1 / 1;
    flex-shrink: 0;
    border-radius: var(--radius-md) 0 0 var(--radius-md);
}
#productGrid.list-mode .pc-body {
    flex-direction: column;
    padding: 1.1rem 1.25rem;
    justify-content: center;
}
#productGrid.list-mode .pc-product-name {
    -webkit-line-clamp: 1;
    font-size: 1rem;
}
@media (max-width: 575.98px) {
    #productGrid.list-mode .pc-image-wrap { width: 110px; min-width: 110px; }
}


/* ============================================================
   PAGINATION
============================================================ */
.shop-pagination { margin-top: 2.5rem; }
.pg-link {
    width: 38px;
    height: 38px;
    display: flex !important;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm) !important;
    font-size: .85rem;
    font-weight: 600;
    color: var(--text-secondary);
    border: 1.5px solid var(--border-light);
    background: #fff;
    transition: var(--transition);
    padding: 0;
}
.page-item.active .pg-link {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}
.pg-link:hover:not(.pg-ellipsis) {
    border-color: var(--brand-primary);
    color: var(--brand-primary);
}
.pg-ellipsis { cursor: default; border-color: transparent; background: transparent; }


/* ============================================================
   OFFCANVAS (mobile filter)
============================================================ */
.filter-offcanvas { max-width: 300px; }
.filter-offcanvas .offcanvas-header { border-bottom: 1px solid var(--border-light); }
.filter-offcanvas .offcanvas-body { overflow-y: auto; }


/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 991.98px) {
    .shop-layout { padding: 1.25rem 0 3rem; }
    #shopSidebar { display: none; }
}
@media (max-width: 575.98px) {
    .shop-toolbar { padding: .55rem .75rem; }
    .toolbar-count { display: none; }
    .active-filters { display: none; }
}
</style>
@endpush


@push('scripts')
<script>
/* ── Price Range Labels ─────────────────────────────────── */
const priceMin = document.getElementById('priceMin');
const priceMax = document.getElementById('priceMax');
const minLabel = document.getElementById('priceMinLabel');
const maxLabel = document.getElementById('priceMaxLabel');

function formatRs(val) {
    return 'Rs ' + parseInt(val).toLocaleString('en-PK');
}
function updatePriceLabels() {
    if (parseInt(priceMin.value) > parseInt(priceMax.value)) {
        priceMin.value = priceMax.value;
    }
    if (minLabel) minLabel.textContent = formatRs(priceMin.value);
    if (maxLabel) maxLabel.textContent = formatRs(priceMax.value);
}
if (priceMin) priceMin.addEventListener('input', updatePriceLabels);
if (priceMax) priceMax.addEventListener('input', updatePriceLabels);

/* Price preset chips */
document.querySelectorAll('.price-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        document.querySelectorAll('.price-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        const min = parseInt(this.dataset.min);
        const max = parseInt(this.dataset.max);
        if (priceMin) { priceMin.value = min; }
        if (priceMax) { priceMax.value = max; }
        updatePriceLabels();
    });
});

/* ── View Toggle ────────────────────────────────────────── */
const grid     = document.getElementById('productGrid');
const gridBtn  = document.getElementById('gridView');
const listBtn  = document.getElementById('listView');

if (gridBtn) gridBtn.addEventListener('click', () => {
    grid.classList.remove('list-mode');
    gridBtn.classList.add('active');
    listBtn.classList.remove('active');
    localStorage.setItem('vendoShopView', 'grid');
});
if (listBtn) listBtn.addEventListener('click', () => {
    grid.classList.add('list-mode');
    listBtn.classList.add('active');
    gridBtn.classList.remove('active');
    localStorage.setItem('vendoShopView', 'list');
});
// Restore preference
if (localStorage.getItem('vendoShopView') === 'list' && grid) {
    grid.classList.add('list-mode');
    if (listBtn) listBtn.classList.add('active');
    if (gridBtn) gridBtn.classList.remove('active');
}

/* ── Brand Show More ─────────────────────────────────────── */
const toggleBrands = document.getElementById('toggleBrands');
let brandsExpanded = false;
if (toggleBrands) {
    toggleBrands.addEventListener('click', function() {
        brandsExpanded = !brandsExpanded;
        document.querySelectorAll('.brand-extra').forEach(el => {
            el.classList.toggle('d-none', !brandsExpanded);
        });
        this.innerHTML = brandsExpanded
            ? 'Show less <i class="fa fa-chevron-up ms-1" style="font-size:.65rem;"></i>'
            : 'Show more <i class="fa fa-chevron-down ms-1" style="font-size:.65rem;"></i>';
    });
}

/* ── Active filter tag removal (demo) ───────────────────── */
document.querySelectorAll('.af-remove').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.active-filter-tag').remove();
    });
});
document.querySelectorAll('.af-clear-all, #clearAllFilters').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.active-filter-tag').forEach(t => t.remove());
    });
});

/* ── Mobile offcanvas sidebar clone ─────────────────────── */
const filterOffcanvas = document.getElementById('filterOffcanvas');
if (filterOffcanvas) {
    filterOffcanvas.addEventListener('show.bs.offcanvas', function() {
        const mobileClone = document.getElementById('mobileSidebarClone');
        const sidebarContent = document.querySelector('#shopSidebar .sidebar-wrap');
        if (mobileClone && sidebarContent && !mobileClone.hasChildNodes()) {
            mobileClone.innerHTML = sidebarContent.innerHTML;
        }
    });
}

/* ── Sort change (demo: reload with param) ───────────────── */
const sortSelect = document.getElementById('sortSelect');
if (sortSelect) {
    sortSelect.addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });
}
</script>
@endpush
