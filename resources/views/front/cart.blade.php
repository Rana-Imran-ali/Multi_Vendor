@extends('layouts.app')

@section('title', 'Shopping Cart — Vendo')
@section('meta_description', 'View your shopping cart and checkout on Vendo.')

@php
/* ── DUMMY CART DATA ── */
$cartItems = [
    [
        'id'       => 101,
        'name'     => 'Sony WH-1000XM5 Wireless Noise Cancelling Headphones',
        'slug'     => 'sony-wh-1000xm5',
        'price'    => 42999,
        'oldPrice' => 55999,
        'qty'      => 1,
        'image'    => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=200',
        'icon'     => 'fa-headphones',
        'color'    => '#4f46e5',
        'variant'  => 'Midnight Black',
        'vendor'   => 'SoundZone PK',
        'vendorSlug'=>'soundzone-pk',
    ],
    [
        'id'       => 102,
        'name'     => 'Nike Air Max 270 — Men\'s Running Shoes',
        'slug'     => 'nike-air-max-270',
        'price'    => 18500,
        'oldPrice' => 24000,
        'qty'      => 2,
        'image'    => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=200',
        'icon'     => 'fa-shoe-prints',
        'color'    => '#0891b2',
        'variant'  => 'Size: 42 (Black/White)',
        'vendor'   => 'SportsHub',
        'vendorSlug'=>'sportshub',
    ]
];

// Calculate totals
$subtotal = 0;
$savings  = 0;
foreach($cartItems as $item) {
    $subtotal += ($item['price'] * $item['qty']);
    if($item['oldPrice']) {
        $savings += (($item['oldPrice'] - $item['price']) * $item['qty']);
    }
}
$shipping = $subtotal > 2000 ? 0 : 250;
$total = $subtotal + $shipping;
@endphp

@section('content')

{{-- BREADCRUMB --}}
<div class="cp-breadcrumb-bar">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 cp-bc">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item active">Shopping Cart</li>
            </ol>
        </nav>
    </div>
</div>

{{-- CART SECTION --}}
<section class="cp-section">
    <div class="container-xl">
        <h1 class="cp-page-title">Shopping Cart <span class="cp-title-count">({{ count($cartItems) }} items)</span></h1>

        @if(count($cartItems) > 0)
        <div class="row g-4 g-xl-5 mt-2">

            {{-- ══ LEFT: CART ITEMS ══ --}}
            <div class="col-12 col-lg-8">
                <div class="cart-items-wrap">

                    {{-- Table Header (Desktop) --}}
                    <div class="cart-table-header d-none d-md-flex">
                        <div class="ct-col-product">Product</div>
                        <div class="ct-col-price text-center">Price</div>
                        <div class="ct-col-qty text-center">Quantity</div>
                        <div class="ct-col-total text-end">Total</div>
                    </div>

                    {{-- Items List --}}
                    <div class="cart-items-list">
                        @foreach($cartItems as $item)
                        <div class="cart-item-row" id="cart-item-{{ $item['id'] }}">

                            {{-- Product Info --}}
                            <div class="ct-col-product">
                                <a href="{{ url('/products/'.$item['slug']) }}" class="ci-img-wrap"
                                   style="background: linear-gradient(135deg,{{ $item['color'] }}22,{{ $item['color'] }}11);">
                                    @if($item['image'])
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                    @else
                                        <i class="fa {{ $item['icon'] }}" style="color:{{ $item['color'] }};"></i>
                                    @endif
                                </a>
                                <div class="ci-info">
                                    <a href="{{ url('/products/'.$item['slug']) }}" class="ci-name">{{ $item['name'] }}</a>
                                    @if($item['variant'])
                                        <span class="ci-variant">{{ $item['variant'] }}</span>
                                    @endif
                                    <a href="{{ url('/vendors/'.$item['vendorSlug']) }}" class="ci-vendor">Sold by {{ $item['vendor'] }}</a>

                                    {{-- Mobile Price (hidden on desktop table) --}}
                                    <div class="ci-mobile-price d-md-none mt-2">
                                        <span class="ci-price">Rs {{ number_format($item['price']) }}</span>
                                        @if($item['oldPrice'])
                                            <span class="ci-old-price">Rs {{ number_format($item['oldPrice']) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Price Col --}}
                            <div class="ct-col-price text-center d-none d-md-block">
                                <span class="ci-price">Rs {{ number_format($item['price']) }}</span>
                                @if($item['oldPrice'])
                                    <br><span class="ci-old-price">Rs {{ number_format($item['oldPrice']) }}</span>
                                @endif
                            </div>

                            {{-- Quantity Col --}}
                            <div class="ct-col-qty">
                                <div class="ci-qty-ctrl">
                                    <button class="ci-qty-btn" onclick="updateCartQty({{ $item['id'] }}, -1)"><i class="fa fa-minus"></i></button>
                                    <input type="number" class="ci-qty-input" id="qty-{{ $item['id'] }}" value="{{ $item['qty'] }}" min="1" max="10" readonly>
                                    <button class="ci-qty-btn" onclick="updateCartQty({{ $item['id'] }}, 1)"><i class="fa fa-plus"></i></button>
                                </div>
                                <button class="ci-remove-btn mt-2" onclick="removeCartItem({{ $item['id'] }})">
                                    <i class="fa-regular fa-trash-can me-1"></i> Remove
                                </button>
                            </div>

                            {{-- Total Col --}}
                            <div class="ct-col-total text-end d-none d-md-block">
                                <span class="ci-line-total" id="total-{{ $item['id'] }}">Rs {{ number_format($item['price'] * $item['qty']) }}</span>
                            </div>

                        </div>
                        @endforeach
                    </div>

                    {{-- Cart Footer Actions --}}
                    <div class="cart-footer-actions">
                        <a href="{{ url('/shop') }}" class="btn btn-outline-brand">
                            <i class="fa fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                        <button class="btn btn-outline-secondary">
                            <i class="fa fa-rotate-right me-2"></i> Update Cart
                        </button>
                    </div>

                </div>
            </div>

            {{-- ══ RIGHT: CART SUMMARY ══ --}}
            <div class="col-12 col-lg-4">
                <div class="cart-summary-box">
                    <h5 class="summary-title">Order Summary</h5>

                    <div class="summary-lines">
                        <div class="summary-line">
                            <span class="text-secondary">Subtotal ({{ count($cartItems) }} items)</span>
                            <span class="fw-700">Rs {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="summary-line text-success">
                            <span>Discount / Savings</span>
                            <span>- Rs {{ number_format($savings) }}</span>
                        </div>
                        <div class="summary-line">
                            <span class="text-secondary">Shipping Estimate</span>
                            <span>{{ $shipping === 0 ? 'Free' : 'Rs '.number_format($shipping) }}</span>
                        </div>

                        {{-- Free shipping progress demo --}}
                        @if($shipping > 0 && $subtotal < 2000)
                        <div class="shipping-progress mt-3">
                            <div class="d-flex justify-content-between mb-1" style="font-size:.7rem;">
                                <span>Add Rs {{ number_format(2000 - $subtotal) }} for <strong>Free Shipping</strong></span>
                            </div>
                            <div class="progress" style="height:6px;">
                                <div class="progress-bar bg-warning" style="width:{{ ($subtotal/2000)*100 }}%"></div>
                            </div>
                        </div>
                        @else
                        <div class="shipping-alert mt-3 text-success">
                            <i class="fa fa-truck-fast me-1"></i> You've unlocked Free Shipping!
                        </div>
                        @endif
                    </div>

                    {{-- Promo Code --}}
                    <div class="promo-box mt-4">
                        <label class="promo-label">Have a promo code?</label>
                        <div class="promo-input-group">
                            <input type="text" class="promo-input" placeholder="Enter code">
                            <button class="promo-btn">Apply</button>
                        </div>
                    </div>

                    <div class="summary-total mt-4">
                        <span>Total Amount</span>
                        <span class="total-price">Rs {{ number_format($total) }}</span>
                    </div>
                    <p class="text-muted text-end mb-4" style="font-size:.7rem;">VAT included, where applicable</p>

                    <a href="{{ url('/checkout') }}" class="btn btn-brand w-100 btn-lg shadow-sm">
                        Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                    </a>

                    <div class="secure-checkout mt-3 text-center">
                        <i class="fa fa-lock text-success me-1"></i>
                        <span class="text-muted" style="font-size:.75rem;">Secure Encrypted Checkout</span>
                        <div class="payment-icons mt-2">
                            <i class="fa-brands fa-cc-visa"></i>
                            <i class="fa-brands fa-cc-mastercard"></i>
                            <i class="fa-brands fa-cc-paypal"></i>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- /row --}}

        @else
        {{-- EMPTY CART STATE --}}
        <div class="empty-cart-state text-center py-5">
            <div class="empty-icon-wrap mb-4 mx-auto">
                <i class="fa fa-cart-arrow-down shadow-sm"></i>
            </div>
            <h3 class="fw-800 mb-2">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ url('/shop') }}" class="btn btn-brand btn-lg px-5">Start Shopping</a>
        </div>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Breadcrumb ── */
.cp-breadcrumb-bar {
    background: #fff; border-bottom: 1px solid var(--border-light); padding: .85rem 0;
}
.cp-bc { --bs-breadcrumb-divider: '/'; }
.cp-bc a { font-size:.8rem; color:var(--brand-primary); text-decoration:none; }
.cp-bc .breadcrumb-item.active { font-size:.8rem; color:var(--text-muted); }

/* ── Section & Title ── */
.cp-section { padding: 3rem 0 5rem; background: #f7f8fa; min-height: 60vh; }
.cp-page-title {
    font-size: 2rem; font-weight: 800; color: var(--text-primary);
    margin-bottom: 1.5rem; letter-spacing: -.5px;
}
.cp-title-count { font-size: 1rem; font-weight: 500; color: var(--text-muted); position:relative; top:-2px; }

/* ── Cart Items List ── */
.cart-items-wrap {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.02);
}

.cart-table-header {
    background: #fdfdfd; border-bottom: 1px solid var(--border-light);
    padding: 1rem 1.5rem; font-size: .82rem; font-weight: 700;
    color: var(--text-secondary); text-transform: uppercase; letter-spacing: .5px;
}

/* Grid Columns */
.ct-col-product { flex: 0 0 45%; max-width: 45%; display:flex; gap:1rem; }
.ct-col-price   { flex: 0 0 15%; max-width: 15%; }
.ct-col-qty     { flex: 0 0 20%; max-width: 20%; display:flex; flex-direction:column; align-items:center; }
.ct-col-total   { flex: 0 0 20%; max-width: 20%; }

.cart-item-row {
    display: flex; align-items: center; padding: 1.5rem;
    border-bottom: 1px solid var(--border-light);
    transition: background .2s;
}
.cart-item-row:hover { background: #fbfcff; }
.cart-item-row:last-child { border-bottom: none; }

/* Product Info */
.ci-img-wrap {
    width: 80px; height: 80px; border-radius: var(--radius-sm);
    flex-shrink: 0; display:flex; align-items:center; justify-content:center;
    font-size: 2rem; overflow: hidden; border:1px solid var(--border-light);
    text-decoration:none; transition:transform .25s;
}
.ci-img-wrap:hover { transform: scale(1.05); }
.ci-img-wrap img { width:100%; height:100%; object-fit:cover; }

.ci-info { display: flex; flex-direction: column; justify-content: center; }
.ci-name {
    font-size: .95rem; font-weight: 700; color: var(--text-primary);
    text-decoration: none; line-height: 1.35; margin-bottom: .25rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ci-name:hover { color: var(--brand-primary); }
.ci-variant { font-size: .75rem; color: var(--text-secondary); margin-bottom: .2rem; }
.ci-vendor  { font-size: .72rem; color: var(--brand-primary); text-decoration: none; }
.ci-vendor:hover { text-decoration: underline; }

/* Prices */
.ci-price { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
.ci-old-price { font-size: .75rem; color: var(--text-muted); text-decoration: line-through; }
.ci-line-total { font-size: 1.1rem; font-weight: 800; color: var(--brand-primary); }

/* Qty Controls */
.ci-qty-ctrl { display: flex; align-items: center; border: 1px solid var(--border-light); border-radius: var(--radius-sm); overflow: hidden; }
.ci-qty-btn {
    width: 32px; height: 32px; background: #fdfdfd; border: none;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-secondary); font-size: .75rem; cursor: pointer; transition: background .2s;
}
.ci-qty-btn:hover { background: var(--brand-light); color: var(--brand-primary); }
.ci-qty-input {
    width: 40px; height: 32px; border: none; border-left: 1px solid var(--border-light); border-right: 1px solid var(--border-light);
    text-align: center; font-size: .85rem; font-weight: 700; color: var(--text-primary); outline: none; -moz-appearance: textfield;
}
.ci-qty-input::-webkit-outer-spin-button, .ci-qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

.ci-remove-btn {
    background: none; border: none; color: #ef4444;
    font-size: .75rem; font-weight: 600; padding: 0; cursor: pointer; opacity: .8; transition: opacity .2s;
}
.ci-remove-btn:hover { opacity: 1; text-decoration: underline; }

/* Footer Actions */
.cart-footer-actions {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.25rem 1.5rem; background: #fdfdfd; border-top: 1px solid var(--border-light);
}


/* ── Cart Summary ── */
.cart-summary-box {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-lg); padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.03); position: sticky; top: 80px;
}
.summary-title { font-size: 1.1rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-light); }

.summary-lines { display: flex; flex-direction: column; gap: .75rem; }
.summary-line { display: flex; justify-content: space-between; font-size: .9rem; color: var(--text-primary); }

/* Promo */
.promo-label { font-size: .8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: .4rem; display: block; }
.promo-input-group { display: flex; }
.promo-input {
    flex: 1; padding: .65rem 1rem; border: 1px solid var(--border-light);
    border-radius: var(--radius-sm) 0 0 var(--radius-sm); outline: none; font-size: .85rem;
}
.promo-input:focus { border-color: var(--brand-primary); }
.promo-btn {
    background: var(--text-primary); color: #fff; border: none;
    padding: 0 1.25rem; font-size: .85rem; font-weight: 600;
    border-radius: 0 var(--radius-sm) var(--radius-sm) 0; cursor: pointer; transition: background .2s;
}
.promo-btn:hover { background: #000; }

.summary-total {
    display: flex; justify-content: space-between; align-items: center;
    border-top: 1px dashed var(--border-light); padding-top: 1rem;
    font-size: 1.1rem; font-weight: 800; color: var(--text-primary);
}
.total-price { font-size: 1.5rem; color: var(--brand-primary); }

.payment-icons { color: #c8ced8; font-size: 1.8rem; display: flex; gap: .5rem; justify-content: center; }


/* ── Empty State ── */
.empty-icon-wrap {
    width: 100px; height: 100px; background: #fff;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: var(--brand-primary); border: 2px dashed rgba(240,79,35,.3);
}

/* ── Responsive ── */
@media (max-width: 767.98px) {
    .cart-item-row { flex-wrap: wrap; position: relative; padding: 1.25rem; }
    .ct-col-product { flex: 0 0 100%; max-width: 100%; margin-bottom: 1rem; }
    .ct-col-qty { flex: 0 0 100%; max-width: 100%; flex-direction: row; justify-content: space-between; align-items: center; }
    .ci-remove-btn { margin-top: 0 !important; }
    .cart-footer-actions { flex-direction: column; gap: 1rem; }
    .cart-footer-actions .btn { width: 100%; }
}
</style>
@endpush

@push('scripts')
<script>
/* Demo UI Updates */
function updateCartQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    if(input) {
        let val = parseInt(input.value) + delta;
        val = Math.max(1, Math.min(val, 10)); // min 1, max 10 for demo
        input.value = val;
        // In real app, trigger AJAX cart update here
    }
}

function removeCartItem(id) {
    const row = document.getElementById('cart-item-' + id);
    if(row) {
        row.style.opacity = '0.5';
        row.style.transform = 'scale(0.98)';
        setTimeout(() => {
            row.remove();
            // In real app, trigger AJAX cart delete here
        }, 300);
    }
}
</script>
@endpush
