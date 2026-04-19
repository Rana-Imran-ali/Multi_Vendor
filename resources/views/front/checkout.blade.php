@extends('layouts.app')

@section('title', 'Secure Checkout — Vendo')
@section('meta_description', 'Complete your purchase securely on Vendo.')

$subtotal = 0;
$shipping = 0; 
$discount = 0;
$total    = 0;

$savedAddresses = [];
// Assuming Address model has an endpoint, but for now we'll rely on the manual inputs from the user since Address is not fully mapped in the backend summary.
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
                        {{-- New Address Form --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="ck-label">First Name *</label>
                                <input type="text" class="ck-input" id="billFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">Last Name *</label>
                                <input type="text" class="ck-input" id="billLastName" required>
                            </div>
                            <div class="col-12">
                                <label class="ck-label">Street Address *</label>
                                <input type="text" class="ck-input mb-2" id="billStreet" placeholder="House number and street name" required>
                                <input type="text" class="ck-input" id="billAppt" placeholder="Apartment, suite, unit, etc. (optional)">
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">City *</label>
                                <select class="ck-select" id="billCity" required>
                                    <option value="">Select City</option>
                                    <option value="Karachi">Karachi</option>
                                    <option value="Lahore">Lahore</option>
                                    <option value="Islamabad">Islamabad</option>
                                    <option value="Rawalpindi">Rawalpindi</option>
                                    <option value="Peshawar">Peshawar</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="ck-label">Province / Region *</label>
                                <select class="ck-select" id="billProv" required>
                                    <option value="">Select Province</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Sindh">Sindh</option>
                                    <option value="KPK">Khyber Pakhtunkhwa</option>
                                    <option value="Balochistan">Balochistan</option>
                                </select>
                            </div>
                        </div>
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

                    <div class="ck-item-list" id="ckCartList">
                        <div class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                    </div>

                    <div class="summary-lines mt-4">
                        <div class="summary-line">
                            <span class="text-secondary">Subtotal</span>
                            <span class="fw-700" id="ckSubtotal">Rs 0</span>
                        </div>
                        <div class="summary-line">
                            <span class="text-secondary">Shipping</span>
                            <span id="ckShipping">Free</span>
                        </div>
                    </div>

                    <div class="summary-total mt-4 border-top pt-3">
                        <span class="fs-5 text-dark">Total</span>
                        <div class="text-end">
                            <span class="fs-xs text-muted d-block mb-1">PKR</span>
                            <span class="fs-3 fw-900 text-brand line-height-1" id="ckTotal">Rs 0</span>
                        </div>
                    </div>

                    <button class="btn btn-brand w-100 btn-lg shadow mt-4" id="btnPlaceOrder" onclick="placeOrder()">
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

const FREE_SHIPPING_THRESHOLD = 5000;

document.addEventListener('DOMContentLoaded', () => {
    if(!window.Auth || !window.Auth.check()) {
        window.location.href = '/login?redirect=/checkout';
        return;
    }
    loadCheckoutCart();
});

async function loadCheckoutCart() {
    const res = await window.CartAPI.fetch();
    if(res && res.status === 'success') {
        if(res.data.items.length === 0) {
            window.location.href = '/cart'; // Redirect empty cart
            return;
        }
        renderCheckoutCart(res.data);
    }
}

function renderCheckoutCart(cartData) {
    const list = document.getElementById('ckCartList');
    list.innerHTML = '';
    
    let subtotal = parseFloat(cartData.subtotal);
    
    cartData.items.forEach(item => {
        const p = item.product;
        const thumbnail = p.thumbnail || '/placeholder.jpg';
        const fp = new Intl.NumberFormat().format(item.unit_price);
        
        list.insertAdjacentHTML('beforeend', `
        <div class="ck-item">
            <div class="ck-item-img-wrap" style="background:#f7f8fa;">
                <img src="${thumbnail}" style="width:100%;height:100%;object-fit:cover;border-radius:4px;">
                <span class="ck-item-qty">${item.quantity}</span>
            </div>
            <div class="ck-item-info">
                <p class="ck-item-name">${p.name}</p>
                <p class="ck-item-price">Rs ${fp}</p>
            </div>
        </div>`);
    });
    
    document.getElementById('ckSubtotal').textContent = `Rs ${new Intl.NumberFormat().format(subtotal)}`;
    
    let shipping = subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : 250;
    document.getElementById('ckShipping').textContent = shipping === 0 ? 'Free' : `Rs ${shipping}`;
    
    let total = subtotal + shipping;
    document.getElementById('ckTotal').textContent = `Rs ${new Intl.NumberFormat().format(total)}`;
}

async function placeOrder() {
    const first = document.getElementById('billFirstName').value.trim();
    const last = document.getElementById('billLastName').value.trim();
    const street = document.getElementById('billStreet').value.trim();
    const appt = document.getElementById('billAppt').value.trim();
    const city = document.getElementById('billCity').value;
    const prov = document.getElementById('billProv').value;
    
    if(!first || !last || !street || !city || !prov) {
        alert("Please fill out all required shipping fields.");
        return;
    }
    
    const shipping_address = `${first} ${last}, ${street} ${appt ? appt : ''}, ${city}, ${prov}`;
    const payment_method = document.querySelector('input[name="payment"]:checked').value;
    
    // We only support 'card' and 'cod' from the allowed API strings in this simplified demo scope
    const apiPaymentMethod = payment_method === 'card' ? 'card' : 'cod'; // Map wallet to cod for fallback
    
    const btn = document.getElementById('btnPlaceOrder');
    const origHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    try {
        const res = await fetch('/api/orders', {
            method: 'POST',
            headers: window.Auth.getAuthHeaders(),
            body: JSON.stringify({ shipping_address, payment_method: apiPaymentMethod })
        });
        
        const data = await res.json();
        
        if(res.ok && data.status === 'success') {
            // Success
            if (data.payment_url) {
                // Redirect to stripe form
                window.location.href = data.payment_url;
            } else {
                alert('Order placed successfully!');
                window.location.href = '/dashboard/orders';
            }
        } else {
            alert(data.message || 'Failed to place order.');
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }
    } catch(err) {
        alert('Internal server error.');
        btn.innerHTML = origHTML;
        btn.disabled = false;
    }
}
</script>
@endpush
