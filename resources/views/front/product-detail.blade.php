@extends('layouts.app')

@section('title', 'Sony WH-1000XM5 Headphones — Vendo')
@section('meta_description', 'Buy Sony WH-1000XM5 Noise Cancelling Headphones at the best price on Vendo.')

@php
/* ── DUMMY PRODUCT DATA ── */
$product = [
    'id'          => 1,
    'name'        => 'Sony WH-1000XM5 Wireless Noise Cancelling Headphones',
    'slug'        => 'sony-wh-1000xm5',
    'sku'         => 'SNY-WH1000XM5-BLK',
    'price'       => 42999,
    'oldPrice'    => 55999,
    'discount'    => 23,
    'rating'      => 4.8,
    'reviewsCount'=> 1284,
    'stock'       => 14,
    'description' => 'Industry-leading noise canceling with Speak-to-Chat technology. Two processors control noise cancellation and produce exceptional sound. Up to 30-hour battery life with quick charging (3 min charge = 3 hours playback).',
    'features'    => [
        'Industry-leading noise canceling (ANC)',
        'Up to 30 hours battery life',
        'Multipoint connection — 2 devices simultaneously',
        'Touch sensor controls on ear cup',
        '360 Reality Audio certified',
        'Foldable design with carry case included',
    ],
    'specs' => [
        'Driver Size'       => '30mm',
        'Frequency Response'=> '4 Hz – 40,000 Hz',
        'Battery Life'      => '30 hours (ANC on)',
        'Charging Time'     => '3.5 hours (USB-C)',
        'Weight'            => '250 g',
        'Colors Available'  => 'Black, Silver',
        'Connectivity'      => 'Bluetooth 5.2, 3.5mm',
        'Warranty'          => '1 Year Sony Official',
    ],
    'colors'    => ['Midnight Black', 'Platinum Silver'],
    'vendorId'  => 10,
    'vendorName'=> 'SoundZone PK',
    'vendorSlug'=> 'soundzone-pk',
    'vendorRating' => 4.9,
    'vendorSales'  => 12400,
    'images'    => [
        'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1572536147248-ac59a8abfa4b?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&q=80&w=800',
    ],
    'category'  => 'Electronics',
    'brand'     => 'Sony',
    'tags'      => ['Headphones','Wireless','Noise Cancelling','Sony','Audio'],
];

$reviews = [
    ['id'=>1,'author'=>'Ahmed R.','avatar'=>'AR','rating'=>5,'date'=>'March 20, 2026','title'=>'Absolutely worth it!','body'=>'Crystal-clear audio, unbelievable noise cancellation. Wore these on a 10-hour flight and couldn\'t hear anything but my music. Build quality is premium.','helpful'=>48],
    ['id'=>2,'author'=>'Sara K.',  'avatar'=>'SK','rating'=>5,'date'=>'March 15, 2026','title'=>'Best headphones I\'ve ever owned','body'=>'Comfort is on another level — wore for 6 hours straight with zero fatigue. Touch controls are very intuitive. Highly recommend.','helpful'=>31],
    ['id'=>3,'author'=>'Bilal M.', 'avatar'=>'BM','rating'=>4,'date'=>'March 10, 2026','title'=>'Great but pricey','body'=>'Sound and ANC are top-notch. Battery life is impressive. Docking two devices at once is super handy. Only 4 stars because the case feels a bit flimsy.','helpful'=>22],
    ['id'=>4,'author'=>'Zara T.',  'avatar'=>'ZT','rating'=>5,'date'=>'March 5, 2026', 'title'=>'Exceeded expectations','body'=>'Compared with Bose QC45 and Sony wins for me. The Speak-to-Chat feature is a game changer. Packaging was lovely too.','helpful'=>17],
];

$ratingBreakdown = [5=>72, 4=>18, 3=>6, 2=>3, 1=>1];

$relatedProducts = [
    ['id'=>9, 'name'=>'Apple AirPods Pro 2nd Gen','slug'=>'airpods-pro-2','price'=>44999,'oldPrice'=>64999,'discount'=>31,'rating'=>5,'reviewsCount'=>2101,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1606220588913-b3eea405b550?auto=format&fit=crop&q=80&w=400','badge'=>'Flash Sale','badgeType'=>'hot','vendorId'=>12,'vendorName'=>'TechMart PK','vendorSlug'=>'techmart-pk','inStock'=>true],
    ['id'=>20,'name'=>'Sony WF-1000XM4 Earbuds','slug'=>'sony-wf-1000xm4','price'=>32000,'oldPrice'=>40000,'discount'=>20,'rating'=>4,'reviewsCount'=>432,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&q=80&w=400','badge'=>'Sale','badgeType'=>'sale','vendorId'=>10,'vendorName'=>'SoundZone PK','vendorSlug'=>'soundzone-pk','inStock'=>true],
    ['id'=>21,'name'=>'Bose QuietComfort 45','slug'=>'bose-qc45','price'=>49999,'oldPrice'=>58000,'discount'=>14,'rating'=>4,'reviewsCount'=>788,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=400','badge'=>null,'badgeType'=>null,'vendorId'=>12,'vendorName'=>'TechMart PK','vendorSlug'=>'techmart-pk','inStock'=>true],
    ['id'=>22,'name'=>'JBL Tune 770NC Headphones','slug'=>'jbl-tune-770nc','price'=>14500,'oldPrice'=>18000,'discount'=>19,'rating'=>4,'reviewsCount'=>234,'icon'=>'fa-headphones','image'=>'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=400','badge'=>'New','badgeType'=>'new','vendorId'=>10,'vendorName'=>'SoundZone PK','vendorSlug'=>'soundzone-pk','inStock'=>true],
];
@endphp

@section('content')

{{-- BREADCRUMB --}}
<div class="pd-breadcrumb-bar">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 pd-bc">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/categories/electronics') }}">{{ $product['category'] }}</a></li>
                <li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($product['name'], 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- MAIN PRODUCT SECTION --}}
<section class="pd-section">
    <div class="container-xl">
        <div class="row g-4 g-xl-5">

            {{-- ══ LEFT: IMAGE GALLERY ══ --}}
            <div class="col-12 col-lg-5">
                <div class="pd-gallery">

                    {{-- Main Image --}}
                    <div class="pd-main-img" id="pdMainImg">
                        <img src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}" id="pdMainImgTag" class="w-100 h-100 object-fit-cover">

                        {{-- Badges --}}
                        <div class="pd-img-badges">
                            @if($product['discount'])
                            <span class="pd-badge-discount">-{{ $product['discount'] }}%</span>
                            @endif
                            @if($product['stock'] > 0 && $product['stock'] <= 5)
                            <span class="pd-badge-low">Only {{ $product['stock'] }} left</span>
                            @endif
                        </div>

                        {{-- Fullscreen btn --}}
                        <button class="pd-fullscreen-btn" title="Zoom"><i class="fa fa-expand"></i></button>
                    </div>

                    {{-- Thumbnails --}}
                    <div class="pd-thumbs">
                        @foreach($product['images'] as $i => $img)
                        <button class="pd-thumb {{ $i===0?'active':'' }}"
                                onclick="switchImg(this, '{{ $img }}')"
                                style="padding:0; overflow:hidden;">
                            <img src="{{ $img }}" class="w-100 h-100 object-fit-cover border-0">
                        </button>
                        @endforeach
                    </div>

                    {{-- Share & Save --}}
                    <div class="pd-share-row">
                        <button class="pd-share-btn"><i class="fa-regular fa-heart me-1"></i> Save to Wishlist</button>
                        <button class="pd-share-btn"><i class="fa fa-share-nodes me-1"></i> Share</button>
                        <button class="pd-share-btn"><i class="fa fa-scale-balanced me-1"></i> Compare</button>
                    </div>
                </div>
            </div>

            {{-- ══ RIGHT: PRODUCT INFO ══ --}}
            <div class="col-12 col-lg-7">
                <div class="pd-info">

                    {{-- Brand + Category --}}
                    <div class="pd-meta-top">
                        <span class="pd-brand-tag">{{ $product['brand'] }}</span>
                        <span class="pd-sku">SKU: {{ $product['sku'] }}</span>
                    </div>

                    {{-- Product Name --}}
                    <h1 class="pd-product-name">{{ $product['name'] }}</h1>

                    {{-- Rating Row --}}
                    <div class="pd-rating-row">
                        <div class="pd-stars">
                            @for($i=1;$i<=5;$i++)
                                <i class="fa-{{ $i <= round($product['rating']) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="pd-rating-num">{{ number_format($product['rating'],1) }}</span>
                        <a href="#reviews" class="pd-review-link">{{ number_format($product['reviewsCount']) }} Reviews</a>
                        <span class="pd-sep">·</span>
                        <span class="pd-stock-tag {{ $product['stock']>0?'in-stock':'out-stock' }}">
                            <i class="fa fa-circle-dot me-1" style="font-size:.65rem;"></i>
                            {{ $product['stock']>0 ? 'In Stock ('.$product['stock'].' available)' : 'Out of Stock' }}
                        </span>
                    </div>

                    <hr class="pd-divider">

                    {{-- Pricing --}}
                    <div class="pd-pricing-block">
                        <div class="pd-price-main">Rs {{ number_format($product['price']) }}</div>
                        @if($product['oldPrice'])
                        <div class="pd-price-sub">
                            <span class="pd-old-price">Rs {{ number_format($product['oldPrice']) }}</span>
                            <span class="pd-saving-tag">You save Rs {{ number_format($product['oldPrice']-$product['price']) }} ({{ $product['discount'] }}%)</span>
                        </div>
                        @endif
                        <p class="pd-price-note"><i class="fa fa-tag me-1"></i>Inclusive of all taxes. Free delivery on orders over Rs 2,000</p>
                    </div>

                    <hr class="pd-divider">

                    {{-- Color Selector --}}
                    <div class="pd-option-row">
                        <p class="pd-option-label">Color: <strong id="selectedColor">{{ $product['colors'][0] }}</strong></p>
                        <div class="pd-color-btns">
                            @foreach($product['colors'] as $color)
                            <button class="pd-color-btn {{ $loop->first?'active':'' }}"
                                    onclick="selectColor(this,'{{ $color }}')">
                                {{ $color }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="pd-option-row">
                        <p class="pd-option-label">Quantity:</p>
                        <div class="pd-qty-wrap">
                            <button class="pd-qty-btn" id="qtyMinus" onclick="changeQty(-1)"><i class="fa fa-minus"></i></button>
                            <input type="number" id="qtyInput" class="pd-qty-input" value="1" min="1" max="{{ $product['stock'] }}">
                            <button class="pd-qty-btn" id="qtyPlus" onclick="changeQty(1)"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="pd-cta-group">
                        <button class="pd-btn-cart {{ $product['stock']<=0?'disabled':'' }}" {{ $product['stock']<=0?'disabled':'' }}>
                            <i class="fa fa-cart-plus me-2"></i>
                            {{ $product['stock']>0?'Add to Cart':'Out of Stock' }}
                        </button>
                        <button class="pd-btn-buy {{ $product['stock']<=0?'disabled':'' }}" {{ $product['stock']<=0?'disabled':'' }}>
                            <i class="fa fa-bolt me-2"></i> Buy Now
                        </button>
                    </div>

                    {{-- Delivery info --}}
                    <div class="pd-delivery-cards">
                        <div class="pd-delivery-card">
                            <i class="fa fa-truck-fast"></i>
                            <div>
                                <strong>Fast Delivery</strong>
                                <small>Order before 2 PM — delivered today</small>
                            </div>
                        </div>
                        <div class="pd-delivery-card">
                            <i class="fa fa-rotate-left"></i>
                            <div>
                                <strong>30-Day Returns</strong>
                                <small>Hassle-free return policy</small>
                            </div>
                        </div>
                        <div class="pd-delivery-card">
                            <i class="fa fa-shield-halved"></i>
                            <div>
                                <strong>1 Year Warranty</strong>
                                <small>Official Sony Pakistan warranty</small>
                            </div>
                        </div>
                    </div>

                    {{-- Vendor Card --}}
                    <div class="pd-vendor-card">
                        <div class="pd-vendor-avatar" style="background:#4f46e5;">SZ</div>
                        <div class="pd-vendor-info">
                            <a href="{{ url('/vendors/'.$product['vendorSlug']) }}" class="pd-vendor-name">
                                {{ $product['vendorName'] }}
                                <i class="fa fa-circle-check ms-1 text-success" style="font-size:.8rem;" title="Verified Vendor"></i>
                            </a>
                            <div class="pd-vendor-meta">
                                <span><i class="fa fa-star text-warning" style="font-size:.7rem;"></i> {{ $product['vendorRating'] }}</span>
                                <span class="pd-sep">·</span>
                                <span>{{ number_format($product['vendorSales']) }}+ sales</span>
                            </div>
                        </div>
                        <a href="{{ url('/vendors/'.$product['vendorSlug']) }}" class="pd-visit-store-btn">Visit Store</a>
                    </div>

                </div>
            </div>
        </div>{{-- /row --}}
    </div>
</section>


{{-- TAB SECTION: Description / Specs / Reviews --}}
<section class="pd-tabs-section">
    <div class="container-xl">

        {{-- Tab Nav --}}
        <ul class="nav pd-tab-nav" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="pd-tab-btn active" id="tab-desc" data-bs-toggle="tab" data-bs-target="#tabDesc" type="button" role="tab">
                    Description
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="pd-tab-btn" id="tab-specs" data-bs-toggle="tab" data-bs-target="#tabSpecs" type="button" role="tab">
                    Specifications
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="pd-tab-btn" id="tab-reviews" data-bs-toggle="tab" data-bs-target="#tabReviews" type="button" role="tab">
                    Reviews <span class="pd-tab-badge">{{ number_format($product['reviewsCount']) }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content pd-tab-content" id="productTabsContent">

            {{-- ── Description ── --}}
            <div class="tab-pane fade show active" id="tabDesc" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-7">
                        <h4 class="pd-content-heading">About this product</h4>
                        <p class="pd-body-text">{{ $product['description'] }}</p>
                        <h5 class="pd-content-heading mt-4">Key Features</h5>
                        <ul class="pd-feature-list">
                            @foreach($product['features'] as $feat)
                            <li><i class="fa fa-circle-check me-2"></i>{{ $feat }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <div class="pd-tags-block">
                            <p class="pd-option-label mb-2">Tags</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product['tags'] as $tag)
                                <a href="{{ url('/shop?tag='.\Illuminate\Support\Str::slug($tag)) }}" class="pd-tag">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Specifications ── --}}
            <div class="tab-pane fade" id="tabSpecs" role="tabpanel">
                <h4 class="pd-content-heading mb-3">Technical Specifications</h4>
                <div class="pd-specs-table-wrap">
                    <table class="pd-specs-table">
                        <tbody>
                            @foreach($product['specs'] as $key => $val)
                            <tr>
                                <th>{{ $key }}</th>
                                <td>{{ $val }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── Reviews ── --}}
            <div class="tab-pane fade" id="tabReviews" role="tabpanel" id="reviews">
                <div class="row g-4">

                    {{-- Rating Summary --}}
                    <div class="col-12 col-md-4">
                        <div class="rv-summary-box">
                            <div class="rv-overall">
                                <span class="rv-big-num">{{ number_format($product['rating'],1) }}</span>
                                <div>
                                    <div class="rv-big-stars">
                                        @for($i=1;$i<=5;$i++)
                                            <i class="fa-{{ $i<=round($product['rating'])?'solid':'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted mb-0" style="font-size:.8rem;">{{ number_format($product['reviewsCount']) }} reviews</p>
                                </div>
                            </div>
                            <div class="rv-breakdown">
                                @foreach($ratingBreakdown as $star => $pct)
                                <div class="rv-bar-row">
                                    <span class="rv-bar-label">{{ $star }}★</span>
                                    <div class="rv-bar-track">
                                        <div class="rv-bar-fill" style="width:{{ $pct }}%;"></div>
                                    </div>
                                    <span class="rv-bar-pct">{{ $pct }}%</span>
                                </div>
                                @endforeach
                            </div>
                            <a href="#writeReview" class="btn btn-brand w-100 mt-3">
                                <i class="fa fa-pen me-2"></i> Write a Review
                            </a>
                        </div>
                    </div>

                    {{-- Review List --}}
                    <div class="col-12 col-md-8">
                        <div class="rv-filter-row mb-3">
                            <span class="rv-filter-label">Filter:</span>
                            <div class="rv-filter-chips">
                                <button class="rv-chip active">All</button>
                                <button class="rv-chip">5★</button>
                                <button class="rv-chip">4★</button>
                                <button class="rv-chip">With Photos</button>
                                <button class="rv-chip">Verified</button>
                            </div>
                        </div>

                        <div class="rv-list">
                            @foreach($reviews as $rv)
                            <div class="rv-card">
                                <div class="rv-card-header">
                                    <div class="rv-author-avatar">{{ $rv['avatar'] }}</div>
                                    <div class="rv-author-info">
                                        <strong class="rv-author-name">{{ $rv['author'] }}</strong>
                                        <div class="rv-stars-row">
                                            @for($i=1;$i<=5;$i++)
                                                <i class="fa-{{ $i<=$rv['rating']?'solid':'regular' }} fa-star"></i>
                                            @endfor
                                            <span class="rv-date ms-2">{{ $rv['date'] }}</span>
                                        </div>
                                    </div>
                                    <span class="rv-verified-badge"><i class="fa fa-circle-check me-1"></i>Verified</span>
                                </div>
                                <h6 class="rv-title">{{ $rv['title'] }}</h6>
                                <p class="rv-body">{{ $rv['body'] }}</p>
                                <div class="rv-helpful">
                                    <span class="text-muted" style="font-size:.8rem;">Was this helpful?</span>
                                    <button class="rv-helpful-btn"><i class="fa-regular fa-thumbs-up me-1"></i>Yes ({{ $rv['helpful'] }})</button>
                                    <button class="rv-helpful-btn"><i class="fa-regular fa-thumbs-down me-1"></i>No</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-3">
                            <button class="btn btn-outline-brand px-4">Load More Reviews</button>
                        </div>
                    </div>

                    {{-- Write a Review Form --}}
                    <div class="col-12" id="writeReview">
                        <div class="rv-write-box">
                            <h5 class="pd-content-heading">Write a Review</h5>
                            <form>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label rv-form-label">Your Rating</label>
                                    <div class="rv-star-picker" id="starPicker">
                                        @for($i=1;$i<=5;$i++)
                                        <button type="button" class="rv-star-pick" data-val="{{ $i }}">
                                            <i class="fa-regular fa-star"></i>
                                        </button>
                                        @endfor
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label rv-form-label">Your Name</label>
                                        <input type="text" class="pd-form-input" placeholder="e.g. Ahmed R.">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label rv-form-label">Review Title</label>
                                        <input type="text" class="pd-form-input" placeholder="Summarise your review">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label rv-form-label">Review</label>
                                        <textarea class="pd-form-input" rows="4" placeholder="Share your experience with this product…"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-brand mt-3 px-4">
                                    <i class="fa fa-paper-plane me-2"></i> Submit Review
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- /tab-content --}}
    </div>
</section>


{{-- RELATED PRODUCTS --}}
<section class="pd-related-section">
    <div class="container-xl">
        <div class="section-header mb-4">
            <div>
                <span class="section-eyebrow">You may also like</span>
                <h2 class="section-title">Related Products</h2>
            </div>
            <a href="{{ url('/shop') }}" class="section-link">View All <i class="fa fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-3 g-md-4 row-cols-2 row-cols-md-4">
            @foreach($relatedProducts as $rp)
            <div class="col">
                <x-product-card
                    :id="$rp['id']" :name="$rp['name']" :slug="$rp['slug']"
                    :price="$rp['price']" :oldPrice="$rp['oldPrice']??null"
                    :discount="$rp['discount']??null" :rating="$rp['rating']"
                    :reviewsCount="$rp['reviewsCount']" :icon="$rp['icon']"
                    :badge="$rp['badge']??null" :badgeType="$rp['badgeType']??'sale'"
                    :vendorId="$rp['vendorId']" :vendorName="$rp['vendorName']"
                    :vendorSlug="$rp['vendorSlug']" :inStock="$rp['inStock']"
                />
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection


@push('styles')
<style>
/* ── Breadcrumb ── */
.pd-breadcrumb-bar {
    background: #fff;
    border-bottom: 1px solid var(--border-light);
    padding: .85rem 0;
}
.pd-bc { --bs-breadcrumb-divider: '/'; }
.pd-bc a { font-size:.8rem; color:var(--brand-primary); text-decoration:none; }
.pd-bc .breadcrumb-item.active { font-size:.8rem; color:var(--text-muted); }

/* ── Product Section ── */
.pd-section {
    background: #fff;
    padding: 2.5rem 0;
}

/* ── Gallery ── */
.pd-gallery { display:flex; flex-direction:column; gap:1rem; position:sticky; top:80px; }

.pd-main-img {
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-light);
    aspect-ratio: 1/1;
    overflow: hidden;
    position: relative;
    cursor: zoom-in;
    background: #f7f8fa;
}
.pd-main-placeholder {
    width:100%; height:100%;
    display:flex; align-items:center; justify-content:center;
    font-size: 7rem;
    transition: transform .4s ease;
}
.pd-main-img:hover .pd-main-placeholder { transform: scale(1.04); }

.pd-img-badges {
    position: absolute; top:14px; left:14px;
    display:flex; flex-direction:column; gap:6px; z-index:2;
}
.pd-badge-discount {
    background: var(--brand-primary); color:#fff;
    font-size:.72rem; font-weight:700; padding:3px 10px;
    border-radius:4px; letter-spacing:.3px;
}
.pd-badge-low {
    background:#ef4444; color:#fff;
    font-size:.68rem; font-weight:700; padding:3px 8px;
    border-radius:4px;
}
.pd-fullscreen-btn {
    position:absolute; bottom:12px; right:12px;
    width:34px; height:34px; border-radius:50%;
    background:rgba(255,255,255,.85);
    border:1px solid var(--border-light);
    display:flex; align-items:center; justify-content:center;
    font-size:.8rem; color:var(--text-secondary); cursor:pointer;
    transition: var(--transition);
}
.pd-fullscreen-btn:hover { background:var(--brand-primary); color:#fff; }

.pd-thumbs { display:flex; gap:.6rem; }
.pd-thumb {
    width:72px; height:72px; border-radius:var(--radius-sm);
    border:2px solid var(--border-light);
    display:flex; align-items:center; justify-content:center;
    font-size:1.6rem; cursor:pointer;
    transition: var(--transition); flex-shrink:0;
}
.pd-thumb.active, .pd-thumb:hover { border-color:var(--brand-primary); }

.pd-share-row { display:flex; gap:.5rem; flex-wrap:wrap; }
.pd-share-btn {
    background:none; border:1.5px solid var(--border-light);
    border-radius:50px; font-size:.78rem; font-weight:600;
    color:var(--text-secondary); padding:.3rem .85rem; cursor:pointer;
    transition: var(--transition);
}
.pd-share-btn:hover { border-color:var(--brand-primary); color:var(--brand-primary); }

/* ── Product Info ── */
.pd-info { display:flex; flex-direction:column; gap:.15rem; }
.pd-meta-top { display:flex; align-items:center; gap:1rem; margin-bottom:.5rem; }
.pd-brand-tag {
    background:var(--brand-light); color:var(--brand-primary);
    font-size:.72rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.6px; padding:3px 10px; border-radius:4px;
}
.pd-sku { font-size:.75rem; color:var(--text-muted); }

.pd-product-name {
    font-size: clamp(1.3rem,2.5vw,1.7rem);
    font-weight:800; color:var(--text-primary);
    line-height:1.3; margin-bottom:.65rem; letter-spacing:-.3px;
}

/* Rating */
.pd-rating-row { display:flex; align-items:center; flex-wrap:wrap; gap:.5rem; margin-bottom:.5rem; }
.pd-stars { color:#f59e0b; font-size:.9rem; display:flex; gap:1px; }
.pd-rating-num { font-size:.9rem; font-weight:700; color:var(--text-primary); }
.pd-review-link { font-size:.82rem; color:var(--brand-primary); text-decoration:none; }
.pd-review-link:hover { text-decoration:underline; }
.pd-sep { color:var(--border-light); }
.pd-stock-tag { font-size:.8rem; font-weight:600; display:flex; align-items:center; }
.pd-stock-tag.in-stock  { color:#16a34a; }
.pd-stock-tag.out-stock { color:#dc2626; }

.pd-divider { border-color: var(--border-light); margin:.85rem 0; }

/* Pricing */
.pd-pricing-block { display:flex; flex-direction:column; gap:.3rem; }
.pd-price-main { font-size:2rem; font-weight:900; color:var(--text-primary); line-height:1; letter-spacing:-.5px; }
.pd-price-sub  { display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; }
.pd-old-price { font-size:.95rem; color:var(--text-muted); text-decoration:line-through; }
.pd-saving-tag {
    background:#f0fdf4; border:1px solid #bbf7d0;
    color:#16a34a; font-size:.78rem; font-weight:700;
    padding:2px 10px; border-radius:4px;
}
.pd-price-note { font-size:.78rem; color:var(--text-muted); margin:0; }

/* Options */
.pd-option-row { margin-bottom:.85rem; }
.pd-option-label { font-size:.84rem; font-weight:600; color:var(--text-secondary); margin-bottom:.5rem; }
.pd-option-label strong { color:var(--text-primary); }

.pd-color-btns { display:flex; flex-wrap:wrap; gap:.5rem; }
.pd-color-btn {
    padding:.35rem .9rem; border:1.5px solid var(--border-light);
    border-radius:50px; font-size:.82rem; font-weight:600;
    color:var(--text-secondary); background:#fff; cursor:pointer;
    transition: var(--transition);
}
.pd-color-btn.active, .pd-color-btn:hover {
    border-color:var(--brand-primary); color:var(--brand-primary);
    background:var(--brand-light);
}

/* Quantity */
.pd-qty-wrap { display:flex; align-items:center; gap:0; width:fit-content; }
.pd-qty-btn {
    width:38px; height:38px; border:1.5px solid var(--border-light);
    background:#fff; color:var(--text-primary); cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem; transition: var(--transition);
}
.pd-qty-btn:first-child { border-radius:var(--radius-sm) 0 0 var(--radius-sm); }
.pd-qty-btn:last-child  { border-radius:0 var(--radius-sm) var(--radius-sm) 0; }
.pd-qty-btn:hover { background:var(--brand-light); color:var(--brand-primary); border-color:var(--brand-primary); }
.pd-qty-input {
    width:56px; height:38px;
    border:1.5px solid var(--border-light); border-left:none; border-right:none;
    text-align:center; font-size:.9rem; font-weight:700;
    color:var(--text-primary); outline:none; font-family:var(--font-base);
}

/* CTAs */
.pd-cta-group { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.pd-btn-cart, .pd-btn-buy {
    flex:1; min-width:140px; padding:.75rem 1.5rem;
    border-radius:var(--radius-md); font-size:.95rem; font-weight:700;
    cursor:pointer; border:none; transition: var(--transition);
    display:flex; align-items:center; justify-content:center; gap:.35rem;
}
.pd-btn-cart {
    background:var(--brand-light); color:var(--brand-primary);
    border:2px solid rgba(240,79,35,.3);
}
.pd-btn-cart:hover { background:var(--brand-primary); color:#fff; border-color:var(--brand-primary); }
.pd-btn-buy  {
    background:var(--brand-primary); color:#fff;
    box-shadow: 0 4px 16px rgba(240,79,35,.35);
}
.pd-btn-buy:hover  { background:var(--brand-dark); }
.pd-btn-cart.disabled, .pd-btn-buy.disabled {
    background:#f3f4f6; color:var(--text-muted);
    border-color:transparent; cursor:not-allowed; box-shadow:none;
}

/* Delivery cards */
.pd-delivery-cards { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.pd-delivery-card {
    display:flex; align-items:center; gap:.75rem;
    background:#f7f8fa; border:1px solid var(--border-light);
    border-radius:var(--radius-md); padding:.75rem 1rem;
    flex:1; min-width:160px;
}
.pd-delivery-card i { font-size:1.3rem; color:var(--brand-primary); flex-shrink:0; }
.pd-delivery-card strong { display:block; font-size:.82rem; font-weight:700; color:var(--text-primary); }
.pd-delivery-card small { font-size:.72rem; color:var(--text-muted); }

/* Vendor card */
.pd-vendor-card {
    display:flex; align-items:center; gap:1rem;
    background:#f7f8fa; border:1px solid var(--border-light);
    border-radius:var(--radius-md); padding:1rem 1.1rem;
}
.pd-vendor-avatar {
    width:44px; height:44px; border-radius:50%;
    color:#fff; font-size:.9rem; font-weight:800;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pd-vendor-info { flex:1; }
.pd-vendor-name { font-size:.9rem; font-weight:700; color:var(--text-primary); text-decoration:none; }
.pd-vendor-name:hover { color:var(--brand-primary); }
.pd-vendor-meta { font-size:.75rem; color:var(--text-muted); display:flex; align-items:center; gap:.4rem; }
.pd-visit-store-btn {
    background:none; border:1.5px solid var(--brand-primary);
    color:var(--brand-primary); font-size:.8rem; font-weight:600;
    border-radius:50px; padding:.35rem .9rem; text-decoration:none;
    transition: var(--transition); white-space:nowrap;
}
.pd-visit-store-btn:hover { background:var(--brand-primary); color:#fff; }


/* ── TABS ── */
.pd-tabs-section {
    background:#f7f8fa; border-top:1px solid var(--border-light);
    padding:2rem 0 3rem;
}
.pd-tab-nav {
    border-bottom:2px solid var(--border-light);
    gap:.25rem; margin-bottom:2rem; flex-wrap:wrap;
}
.pd-tab-btn {
    border:none; background:none;
    font-size:.9rem; font-weight:600; color:var(--text-secondary);
    padding:.65rem 1.25rem; border-radius:0; cursor:pointer;
    border-bottom:2px solid transparent; margin-bottom:-2px;
    transition: var(--transition); display:flex; align-items:center; gap:.5rem;
}
.pd-tab-btn:hover, .pd-tab-btn.active {
    color:var(--brand-primary); border-bottom-color:var(--brand-primary);
}
.pd-tab-badge {
    background:var(--brand-primary); color:#fff;
    font-size:.65rem; font-weight:700; padding:2px 7px; border-radius:50px;
}
.pd-tab-content { background:#fff; border-radius:var(--radius-lg); padding:2rem; border:1px solid var(--border-light); }

.pd-content-heading { font-size:1.05rem; font-weight:700; color:var(--text-primary); }
.pd-body-text { font-size:.9rem; color:var(--text-secondary); line-height:1.75; }
.pd-feature-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:.5rem; }
.pd-feature-list li { font-size:.875rem; color:var(--text-secondary); display:flex; align-items:flex-start; gap:.5rem; }
.pd-feature-list li i { color:#22c55e; margin-top:2px; flex-shrink:0; }

.pd-tag {
    font-size:.75rem; font-weight:600; padding:.3rem .75rem;
    background:#f0f2f5; border:1px solid var(--border-light);
    border-radius:50px; color:var(--text-secondary); text-decoration:none;
    transition: var(--transition);
}
.pd-tag:hover { background:var(--brand-light); color:var(--brand-primary); border-color:rgba(240,79,35,.25); }

/* Specs table */
.pd-specs-table-wrap { overflow-x:auto; }
.pd-specs-table { width:100%; border-collapse:collapse; }
.pd-specs-table tr { border-bottom:1px solid var(--border-light); }
.pd-specs-table th {
    width:35%; padding:.75rem 1rem; font-size:.84rem; font-weight:600;
    color:var(--text-secondary); background:#f7f8fa; text-align:left;
}
.pd-specs-table td { padding:.75rem 1rem; font-size:.875rem; color:var(--text-primary); }
.pd-specs-table tr:last-child { border-bottom:none; }
.pd-specs-table tr:hover td, .pd-specs-table tr:hover th { background:var(--brand-light); }

/* Reviews */
.rv-summary-box {
    background:#f7f8fa; border:1px solid var(--border-light);
    border-radius:var(--radius-md); padding:1.5rem;
}
.rv-overall { display:flex; align-items:center; gap:1rem; margin-bottom:1.25rem; }
.rv-big-num { font-size:3rem; font-weight:900; color:var(--text-primary); line-height:1; }
.rv-big-stars { color:#f59e0b; font-size:1.1rem; display:flex; gap:2px; margin-bottom:.25rem; }
.rv-breakdown { display:flex; flex-direction:column; gap:.5rem; }
.rv-bar-row { display:flex; align-items:center; gap:.6rem; }
.rv-bar-label { font-size:.75rem; color:var(--text-secondary); width:20px; text-align:right; }
.rv-bar-track { flex:1; height:6px; background:#e8eaed; border-radius:4px; overflow:hidden; }
.rv-bar-fill  { height:100%; background:#f59e0b; border-radius:4px; transition:width .6s ease; }
.rv-bar-pct   { font-size:.72rem; color:var(--text-muted); width:28px; }

.rv-filter-row { display:flex; align-items:center; gap:.6rem; flex-wrap:wrap; }
.rv-filter-label { font-size:.8rem; font-weight:600; color:var(--text-muted); }
.rv-filter-chips { display:flex; flex-wrap:wrap; gap:.4rem; }
.rv-chip {
    font-size:.75rem; font-weight:600; padding:.28rem .7rem;
    border:1.5px solid var(--border-light); border-radius:50px;
    background:#fff; color:var(--text-secondary); cursor:pointer; transition:var(--transition);
}
.rv-chip.active, .rv-chip:hover { background:var(--brand-primary); color:#fff; border-color:var(--brand-primary); }

.rv-list { display:flex; flex-direction:column; gap:1rem; }
.rv-card {
    background:#fff; border:1px solid var(--border-light);
    border-radius:var(--radius-md); padding:1.25rem;
    transition: box-shadow .2s;
}
.rv-card:hover { box-shadow:var(--shadow-sm); }
.rv-card-header { display:flex; align-items:center; gap:.85rem; margin-bottom:.65rem; }
.rv-author-avatar {
    width:40px; height:40px; border-radius:50%;
    background:var(--brand-primary); color:#fff;
    font-size:.8rem; font-weight:700;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.rv-author-info { flex:1; }
.rv-author-name { font-size:.9rem; color:var(--text-primary); }
.rv-stars-row { color:#f59e0b; font-size:.75rem; display:flex; align-items:center; }
.rv-date { font-size:.72rem; color:var(--text-muted); font-family:var(--font-base); }
.rv-verified-badge { font-size:.72rem; color:#16a34a; font-weight:600; white-space:nowrap; }
.rv-title { font-size:.9rem; font-weight:700; color:var(--text-primary); margin-bottom:.35rem; }
.rv-body { font-size:.84rem; color:var(--text-secondary); line-height:1.7; margin-bottom:.65rem; }
.rv-helpful { display:flex; align-items:center; gap:.5rem; }
.rv-helpful-btn {
    background:none; border:1px solid var(--border-light);
    color:var(--text-muted); font-size:.75rem; padding:.25rem .7rem;
    border-radius:50px; cursor:pointer; transition:var(--transition);
}
.rv-helpful-btn:hover { border-color:var(--brand-primary); color:var(--brand-primary); }

.rv-write-box {
    background:var(--brand-light); border:1.5px solid rgba(240,79,35,.2);
    border-radius:var(--radius-lg); padding:1.75rem;
}
.rv-form-label { font-size:.82rem; font-weight:600; color:var(--text-secondary); }
.rv-star-picker { display:flex; gap:.35rem; }
.rv-star-pick {
    background:none; border:none; font-size:1.6rem;
    color:#d1d5db; cursor:pointer; padding:0;
    transition:color .15s, transform .15s;
}
.rv-star-pick:hover, .rv-star-pick.active { color:#f59e0b; transform:scale(1.2); }
.pd-form-input {
    width:100%; padding:.55rem .85rem; font-size:.875rem;
    border:1.5px solid var(--border-light); border-radius:var(--radius-sm);
    outline:none; font-family:var(--font-base); color:var(--text-primary);
    background:#fff; transition:border-color .2s; resize:vertical;
}
.pd-form-input:focus { border-color:var(--brand-primary); }

/* Related */
.pd-related-section { background:#f7f8fa; padding:3rem 0 4rem; }

/* Responsive */
@media(max-width:991.98px) {
    .pd-gallery { position:static; }
    .pd-thumbs .pd-thumb { width:60px; height:60px; font-size:1.3rem; }
}
@media(max-width:575.98px) {
    .pd-cta-group { flex-direction:column; }
    .pd-delivery-cards { flex-direction:column; }
    .pd-tabs-section { padding:1.5rem 0 2.5rem; }
    .pd-tab-content { padding:1.25rem; }
}
</style>
@endpush


@push('scripts')
<script>
/* Image Switcher */
function switchImg(btn, url) {
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const imgEl = document.getElementById('pdMainImgTag');
    if (imgEl) {
        imgEl.src = url;
    }
}

/* Color Selector */
function selectColor(btn, name) {
    document.querySelectorAll('.pd-color-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const el = document.getElementById('selectedColor');
    if (el) el.textContent = name;
}

/* Quantity */
function changeQty(delta) {
    const inp = document.getElementById('qtyInput');
    if (!inp) return;
    let val = parseInt(inp.value) + delta;
    val = Math.max(1, Math.min(val, parseInt(inp.max) || 99));
    inp.value = val;
}

/* Star Picker */
const starPicks = document.querySelectorAll('.rv-star-pick');
starPicks.forEach((btn, idx) => {
    btn.addEventListener('click', () => {
        starPicks.forEach((b, i) => {
            b.classList.toggle('active', i <= idx);
            b.querySelector('i').className = i <= idx ? 'fa-solid fa-star' : 'fa-regular fa-star';
        });
    });
    btn.addEventListener('mouseenter', () => {
        starPicks.forEach((b, i) => {
            b.querySelector('i').className = i <= idx ? 'fa-solid fa-star' : 'fa-regular fa-star';
        });
    });
    btn.addEventListener('mouseleave', () => {
        starPicks.forEach(b => {
            const isActive = b.classList.contains('active');
            b.querySelector('i').className = isActive ? 'fa-solid fa-star' : 'fa-regular fa-star';
        });
    });
});

/* Review filter chips */
document.querySelectorAll('.rv-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        document.querySelectorAll('.rv-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
    });
});

/* Animate rating bars on tab open */
const reviewTab = document.getElementById('tab-reviews');
if (reviewTab) {
    reviewTab.addEventListener('shown.bs.tab', () => {
        document.querySelectorAll('.rv-bar-fill').forEach(bar => {
            const w = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => { bar.style.width = w; }, 50);
        });
    });
}
</script>
@endpush
