@extends('layouts.app')

@section('title', 'Secure Checkout — Vendo')
@section('meta_description', 'Complete your purchase securely on Vendo.')

@php
/* ── DUMMY CHECKOUT DATA ── */
$cartItems = [
    ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 42999, 'qty' => 1, 'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=200', 'icon' => 'fa-headphones', 'color' => '#4f46e5'],
    ['name' => 'Nike Air Max 270',           'price' => 18500, 'qty' => 2, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=200', 'icon' => 'fa-shoe-prints', 'color' => '#0891b2']
];

$subtotal = 79999;
$shipping = 0; // Free shipping
$discount = 5000;
$total    = $subtotal + $shipping - $discount;

$savedAddresses = [
    ['id'=>1, 'type'=>'Home', 'name'=>'Ahmed R.', 'phone'=>'0300 1234567', 'address'=>'House 123, Street 4, Phase 5, DHA', 'city'=>'Lahore', 'isDefault'=>true],
    ['id'=>2, 'type'=>'Office','name'=>'Ahmed R.', 'phone'=>'0300 1234567', 'address'=>'Floor 6, IT Tower, Gulberg III', 'city'=>'Lahore', 'isDefault'=>false],
];
@endphp

@section('content')

{{-- BREADCRUMB --}}
<div class="ck-breadcrumb-bar">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 ck-bc">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/cart') }}">Cart</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

{{-- CHECKOUT SECTION --}}
<section class="ck-section">
    <div class="container-xl">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="ck-page-title">Checkout</h1>
            <div class="secure-badge d-none d-sm-flex">
                <i class="fa fa-lock text-success me-2"></i> 256-bit Secure Encryption
            </div>
        </div>

        <div class="row g-4 g-xl-5">

            {{-- ══ LEFT: FORMS ══ --}}
            <div class="col-12 col-lg-7 col-xl-8">
                
                {{-- Step 1: Account / Contact --}}
                <div class="ck-box mb-4">
                    <div class="ck-step-header">
                        <span class="step-num">1</span>
                        <h4 class="step-title">Contact Information</h4>
                        @guest
                        <a href="{{ route('login') }}" class="step-link">Already have an account? Log in</a>
                        @endguest
                    </div>
                    <div class="ck-step-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="ck-label">Email Address *</label>
                                <input type="email" class="ck-input" value="{{ auth()->check() ? auth()->user()->email : '' }}" placeholder="Enter your email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">Phone Number *</label>
                                <input type="tel" class="ck-input" placeholder="e.g. 03xx xxxxxxx" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Shipping Address --}}
                <div class="ck-box mb-4">
                    <div class="ck-step-header">
                        <span class="step-num">2</span>
                        <h4 class="step-title">Shipping Address</h4>
                    </div>
                    <div class="ck-step-body">
                        
                        {{-- Saved Addresses (if logged in & has data) --}}
                        @auth
                        <div class="row g-3 mb-4">
                            @foreach($savedAddresses as $addr)
                            <div class="col-md-6">
                                <label class="saved-addr-card {{ $addr['isDefault'] ? 'selected' : '' }}">
                                    <input type="radio" name="address_id" value="{{ $addr['id'] }}" class="addr-radio" {{ $addr['isDefault'] ? 'checked' : '' }}>
                                    <div class="addr-content">
                                        <div class="d-flex justify-content-between mb-2">
                                            <strong>{{ $addr['name'] }} <span class="badge bg-light text-dark border ms-1">{{ $addr['type'] }}</span></strong>
                                            @if($addr['isDefault']) <span class="text-success"><i class="fa fa-check-circle"></i></span> @endif
                                        </div>
                                        <p class="mb-1">{{ $addr['address'] }}</p>
                                        <p class="mb-1">{{ $addr['city'] }}</p>
                                        <p class="mb-0 text-muted">{{ $addr['phone'] }}</p>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            <div class="col-12 mt-3">
                                <button class="btn btn-outline-brand btn-sm"><i class="fa fa-plus me-1"></i> Add New Address</button>
                            </div>
                        </div>
                        @else

                        {{-- New Address Form (Guest or no saved addresses) --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="ck-label">First Name *</label>
                                <input type="text" class="ck-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">Last Name *</label>
                                <input type="text" class="ck-input" required>
                            </div>
                            <div class="col-12">
                                <label class="ck-label">Street Address *</label>
                                <input type="text" class="ck-input mb-2" placeholder="House number and street name" required>
                                <input type="text" class="ck-input" placeholder="Apartment, suite, unit, etc. (optional)">
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">City *</label>
                                <select class="ck-select" required>
                                    <option value="">Select City</option>
                                    <option value="karachi">Karachi</option>
                                    <option value="lahore">Lahore</option>
                                    <option value="islamabad">Islamabad</option>
                                    <option value="rawalpindi">Rawalpindi</option>
                                    <option value="peshawar">Peshawar</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">Province / Region *</label>
                                <select class="ck-select" required>
                                    <option value="">Select Province</option>
                                    <option value="punjab">Punjab</option>
                                    <option value="sindh">Sindh</option>
                                    <option value="kpk">Khyber Pakhtunkhwa</option>
                                    <option value="balochistan">Balochistan</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="ck-check-row">
                                    <input type="checkbox" class="ck-checkbox" checked>
                                    <span>Billing address is the same as shipping address</span>
                                </label>
                                <label class="ck-check-row mt-2">
                                    <input type="checkbox" class="ck-checkbox">
                                    <span>Save this information for next time</span>
                                </label>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>

                {{-- Step 3: Payment Method --}}
                <div class="ck-box">
                    <div class="ck-step-header">
                        <span class="step-num">3</span>
                        <h4 class="step-title">Payment Method</h4>
                        <span class="step-note d-none d-md-inline"><i class="fa fa-lock ms-2 me-1 text-muted"></i> Secure connection</span>
                    </div>
                    <div class="ck-step-body">
                        
                        <div class="payment-methods">
                            
                            {{-- Option 1: Card --}}
                            <label class="pay-method-card selected" id="method-card">
                                <div class="pay-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" name="payment" value="card" checked class="pay-radio" onclick="selectPayment(this)">
                                        <span class="pay-title">Credit / Debit Card</span>
                                    </div>
                                    <div class="pay-icons">
                                        <i class="fa-brands fa-cc-visa text-primary"></i>
                                        <i class="fa-brands fa-cc-mastercard text-danger"></i>
                                    </div>
                                </div>
                                <div class="pay-body" id="body-card">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <input type="text" class="ck-input" placeholder="Card Number" maxlength="19">
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="ck-input" placeholder="Name on Card">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="ck-input" placeholder="Expiration Date (MM/YY)" maxlength="5">
                                        </div>
                                        <div class="col-6">
                                            <input type="password" class="ck-input" placeholder="CVC" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                            </label>

                            {{-- Option 2: EasyPaisa / JazzCash --}}
                            <label class="pay-method-card" id="method-wallet">
                                <div class="pay-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" name="payment" value="wallet" class="pay-radio" onclick="selectPayment(this)">
                                        <span class="pay-title">Mobile Wallet</span>
                                    </div>
                                    <div class="pay-icons text-muted fs-xs">EasyPaisa / JazzCash</div>
                                </div>
                                <div class="pay-body" id="body-wallet" style="display:none;">
                                    <p class="text-secondary small mb-3">You will be redirected to the secure portal to complete your payment.</p>
                                    <select class="ck-select w-100">
                                        <option value="easypaisa">EasyPaisa Hub</option>
                                        <option value="jazzcash">JazzCash Gateway</option>
                                    </select>
                                </div>
                            </label>

                            {{-- Option 3: COD --}}
                            <label class="pay-method-card" id="method-cod">
                                <div class="pay-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" name="payment" value="cod" class="pay-radio" onclick="selectPayment(this)">
                                        <span class="pay-title">Cash on Delivery (COD)</span>
                                    </div>
                                    <i class="fa fa-money-bill-wave text-success"></i>
                                </div>
                                <div class="pay-body" id="body-cod" style="display:none;">
                                    <div class="alert alert-success bg-opacity-10 border-success border-opacity-25 mb-0" style="font-size:.85rem;">
                                        <i class="fa fa-circle-info me-2"></i>Pay in cash when your order is delivered to your doorstep. Please keep exact change ready.
                                    </div>
                                </div>
                            </label>

                        </div>

                    </div>
                </div>

            </div>

            {{-- ══ RIGHT: SUMMARY STRIP ══ --}}
            <div class="col-12 col-lg-5 col-xl-4">
                <div class="ck-summary-box">
                    
                    <h5 class="summary-title">Order Summary <span class="badge bg-light text-dark border float-end">{{ count($cartItems) }} Items</span></h5>

                    <div class="ck-item-list">
                        @foreach($cartItems as $item)
                        <div class="ck-item">
                            <div class="ck-item-img-wrap" style="background: linear-gradient(135deg,{{ $item['color'] }}22,{{ $item['color'] }}11);">
                                <i class="fa {{ $item['icon'] }}" style="color:{{ $item['color'] }};"></i>
                                <span class="ck-item-qty">{{ $item['qty'] }}</span>
                            </div>
                            <div class="ck-item-info">
                                <p class="ck-item-name">{{ $item['name'] }}</p>
                                <p class="ck-item-price">Rs {{ number_format($item['price']) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-lines mt-4">
                        <div class="summary-line">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-700">Rs {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="summary-line">
                            <span class="text-secondary">Shipping</span>
                            <span class="{{ $shipping===0 ? 'text-success fw-600' : '' }}">{{ $shipping===0 ? 'Free' : 'Rs '.number_format($shipping) }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="summary-line text-success">
                            <span>Discount Applied</span>
                            <span>- Rs {{ number_format($discount) }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="summary-total mt-4 border-top pt-3">
                        <span class="fs-5 text-dark">Total</span>
                        <div class="text-end">
                            <span class="fs-xs text-muted d-block mb-1">PKR</span>
                            <span class="fs-3 fw-900 text-brand line-height-1">Rs {{ number_format($total) }}</span>
                        </div>
                    </div>

                    <button class="btn btn-brand w-100 btn-lg shadow mt-4" onclick="alert('Order placed successfully! (Demo)')">
                        Place Order <i class="fa fa-lock ms-2"></i>
                    </button>

                    <p class="text-center text-muted mt-3" style="font-size:.7rem;">
                        By placing your order, you agree to Vendo's <br>
                        <a href="{{ url('/terms') }}" class="text-brand text-decoration-underline">Terms of Service</a> and <a href="{{ url('/privacy') }}" class="text-brand text-decoration-underline">Privacy Policy</a>.
                    </p>

                </div>
            </div>

        </div>{{-- /row --}}
    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Breadcrumb ── */
.ck-breadcrumb-bar { background: #fff; border-bottom: 1px solid var(--border-light); padding: .85rem 0; }
.ck-bc { --bs-breadcrumb-divider: '/'; font-size:.8rem; }
.ck-bc a { color:var(--brand-primary); text-decoration:none; }
.ck-bc .breadcrumb-item.active { color:var(--text-muted); }

/* ── Section UI ── */
.ck-section { padding: 2.5rem 0 5rem; background: #f7f8fa; min-height: 70vh; }
.ck-page-title { font-size: 1.8rem; font-weight: 800; color: var(--text-primary); margin:0; letter-spacing:-.4px; }
.secure-badge { font-size:.8rem; font-weight:600; color:var(--text-secondary); background:#fff; padding:.4rem .9rem; border-radius:50px; border:1px solid var(--border-light); }

/* ── Box & Steps ── */
.ck-box {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.02);
}
.ck-step-header {
    background: #fdfdfd; border-bottom: 1px solid var(--border-light);
    padding: 1.1rem 1.5rem; display: flex; align-items: center; gap: 1rem;
}
.step-num {
    width: 26px; height: 26px; background: var(--text-primary); color: #fff;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: .85rem; font-weight: 700; flex-shrink:0;
}
.step-title { font-size: 1.05rem; font-weight: 700; color: var(--text-primary); margin: 0; }
.step-link { margin-left: auto; font-size: .8rem; color: var(--brand-primary); text-decoration:none; font-weight:600; }
.step-link:hover { text-decoration: underline; }
.step-note { margin-left: auto; font-size:.75rem; color:var(--text-muted); }

.ck-step-body { padding: 1.5rem; }

/* ── Forms ── */
.ck-label { display: block; font-size: .8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: .4rem; }
.ck-input, .ck-select {
    width: 100%; border: 1.5px solid var(--border-light); border-radius: var(--radius-sm);
    padding: .65rem .85rem; font-size: .9rem; font-family: var(--font-base);
    color: var(--text-primary); outline: none; background: #fff; transition: border-color .2s;
}
.ck-input:focus, .ck-select:focus { border-color: var(--brand-primary); }
.ck-input::placeholder { color: #a1aab7; }

.ck-check-row { display: flex; align-items: flex-start; gap: .6rem; cursor: pointer; }
.ck-checkbox {
    width: 16px; height: 16px; margin-top: 3px; accent-color: var(--brand-primary); cursor:pointer;
}
.ck-check-row span { font-size: .85rem; color: var(--text-secondary); }

/* ── Saved Addresses ── */
.saved-addr-card {
    display: block; border: 1.5px solid var(--border-light); border-radius: var(--radius-md);
    padding: 1rem; cursor: pointer; position: relative; transition: all .2s ease; background:#fff; height:100%;
}
.saved-addr-card:hover { border-color: var(--brand-primary); }
.saved-addr-card.selected { border-color: var(--brand-primary); background: var(--brand-light); box-shadow: 0 0 0 1px var(--brand-primary); }
.addr-radio { position: absolute; opacity: 0; width:0; height:0; }
.addr-content p { font-size: .8rem; color: var(--text-secondary); }

/* ── Payment Methods ── */
.payment-methods { display: flex; flex-direction: column; gap: .75rem; }
.pay-method-card {
    border: 1.5px solid var(--border-light); border-radius: var(--radius-md);
    background: #fff; overflow: hidden; transition: border-color .2s;
}
.pay-method-card.selected { border-color: var(--brand-primary); }
.pay-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.25rem; cursor: pointer; background: #fdfdfd;
}
.pay-method-card.selected .pay-header { background: var(--brand-light); }
.pay-radio { width: 16px; height: 16px; accent-color: var(--brand-primary); cursor: pointer; }
.pay-title { font-size: .9rem; font-weight: 600; color: var(--text-primary); }
.pay-icons { font-size: 1.25rem; display: flex; gap: .3rem; }

.pay-body { padding: 1.25rem; border-top: 1px solid var(--border-light); background: #fff; }

/* ── Order Summary Box ── */
.ck-summary-box {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-lg); padding: 1.5rem;
    position: sticky; top: 80px; box-shadow: 0 4px 20px rgba(0,0,0,.03);
}
.summary-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.25rem; }

.ck-item-list { display: flex; flex-direction: column; gap: 1rem; max-height: 400px; overflow-y: auto; padding-right:.5rem; }
/* custom scrollbar for list view */
.ck-item-list::-webkit-scrollbar { width:4px; }
.ck-item-list::-webkit-scrollbar-track { background:#f1f1f1; }
.ck-item-list::-webkit-scrollbar-thumb { background:#ccc; border-radius:4px; }

.ck-item { display: flex; align-items: center; gap: 1rem; }
.ck-item-img-wrap {
    width: 60px; height: 60px; border-radius: var(--radius-sm); border:1px solid var(--border-light);
    display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
    position: relative; flex-shrink: 0;
}
.ck-item-qty {
    position: absolute; top: -8px; right: -8px; width: 22px; height: 22px;
    background: var(--text-primary); color: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 700; border: 2px solid #fff; line-height:1;
}
.ck-item-info { flex: 1; }
.ck-item-name { font-size: .85rem; font-weight: 600; color: var(--text-primary); margin: 0 0 .2rem; line-height: 1.3; }
.ck-item-price { font-size: .85rem; color: var(--text-secondary); margin: 0; }

.summary-lines { display: flex; flex-direction: column; gap: .6rem; }
.summary-line { display: flex; justify-content: space-between; font-size: .85rem; }

.text-brand { color: var(--brand-primary) !important; }

/* Responsive */
@media (max-width: 991.98px) {
    .ck-summary-box { position: static; margin-top: 1rem; box-shadow:none; }
}
</style>
@endpush

@push('scripts')
<script>
/* Payment UI Togglers */
function selectPayment(radio) {
    document.querySelectorAll('.pay-method-card').forEach(card => card.classList.remove('selected'));
    document.querySelectorAll('.pay-body').forEach(body => body.style.display = 'none');
    
    // Check radio and show body
    radio.checked = true;
    const val = radio.value;
    const card = document.getElementById('method-' + val);
    const body = document.getElementById('body-' + val);
    
    if(card) card.classList.add('selected');
    if(body) body.style.display = 'block';
}

/* Saved Address Selector */
document.querySelectorAll('input[name="address_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.saved-addr-card').forEach(c => c.classList.remove('selected'));
        if(this.checked) this.closest('.saved-addr-card').classList.add('selected');
    });
});
</script>
@endpush
