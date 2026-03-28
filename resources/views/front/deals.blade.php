@extends('layouts.app')

@section('title', 'Hot Deals & Offers — Vendo')
@section('meta_description', 'Discover limited-time flash sales, daily discounts, and massive price drops on top products.')

@section('content')

{{-- PAGE HEADER & COUNTDOWN --}}
<div class="bg-danger py-5 mb-5 border-bottom position-relative overflow-hidden" style="background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);">
    {{-- Background Pattern Decoration --}}
    <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
    
    <div class="container-xl position-relative z-1">
        <div class="row align-items-center">
            
            <div class="col-12 col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-25 rounded-pill px-3 py-1 mb-3">
                    <span class="spinner-grow spinner-grow-sm text-white" role="status" style="width:12px; height:12px;"></span>
                    <span class="text-white fw-bold fs-xs text-uppercase" style="letter-spacing:1px;">Live Now</span>
                </div>
                <h1 class="fw-900 text-white mb-2" style="letter-spacing:-1px; font-size:3rem;">End of Season Sale</h1>
                <p class="text-white-50 fs-5 mb-0">Up to 70% off on thousands of products. Hurry, offers end soon!</p>
            </div>
            
            <div class="col-12 col-lg-6">
                {{-- Countdown Timer Box --}}
                <div class="bg-white rounded-4 shadow-lg p-4 ms-lg-auto" style="max-width:400px;">
                    <h6 class="text-center text-dark fw-bold mb-3 text-uppercase" style="letter-spacing:1px;">Sale Ends In</h6>
                    <div class="d-flex justify-content-center gap-3 text-center" id="dealTimer">
                        <div>
                            <div class="time-box bg-light text-brand fw-900 rounded mb-1 d-flex align-items-center justify-content-center" style="width:60px; height:60px; font-size:1.75rem;">12</div>
                            <span class="text-muted fs-xs fw-bold text-uppercase">Days</span>
                        </div>
                        <div class="fs-4 fw-bold text-muted mt-2">:</div>
                        <div>
                            <div class="time-box bg-light text-brand fw-900 rounded mb-1 d-flex align-items-center justify-content-center" style="width:60px; height:60px; font-size:1.75rem;">08</div>
                            <span class="text-muted fs-xs fw-bold text-uppercase">Hours</span>
                        </div>
                        <div class="fs-4 fw-bold text-muted mt-2">:</div>
                        <div>
                            <div class="time-box bg-light text-brand fw-900 rounded mb-1 d-flex align-items-center justify-content-center" style="width:60px; height:60px; font-size:1.75rem;">45</div>
                            <span class="text-muted fs-xs fw-bold text-uppercase">Mins</span>
                        </div>
                        <div class="fs-4 fw-bold text-muted mt-2">:</div>
                        <div>
                            <div class="time-box bg-danger bg-opacity-10 text-danger fw-900 rounded mb-1 d-flex align-items-center justify-content-center" style="width:60px; height:60px; font-size:1.75rem;">14</div>
                            <span class="text-muted fs-xs fw-bold text-uppercase">Secs</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container-xl mb-5 pb-4">
    
    {{-- Deal Categories Filter --}}
    <div class="d-flex flex-wrap gap-2 mb-4 pb-3 border-bottom no-scrollbar overflow-x-auto text-nowrap">
        <button class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"><i class="fa-solid fa-fire me-2"></i> All Deals</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">Tech under Rs 10k</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">Clearance Fashion</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">Home Appliances 50% Off</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">BOGO Offers</button>
    </div>

    {{-- Info banner --}}
    <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 py-2 px-3 fw-500 text-dark mb-4 fs-sm d-flex align-items-center">
        <i class="fa-solid fa-tags text-warning fs-5 me-3"></i> 
        <span><strong>Extra 10% Off!</strong> Use code <code class="bg-white px-2 py-1 rounded fw-bold text-danger border shadow-sm">FLASHSALE10</code> at checkout. Minimum spend Rs 5,000.</span>
    </div>

    {{-- Grid --}}
    <div class="row g-3 g-md-4 mb-5">
        
        {{-- Repeat Product Component 8 times for Demo --}}
        {{-- NOTE: We explicitly pass dummy specific discounts to these to emphasize the "Deals" aspect --}}
        @for($i = 1; $i <= 8; $i++)
        <div class="col-6 col-md-4 col-lg-3">
            @php
                // Randomize some deal-specific badges
                $discount = [70, 50, 45, 60, 25, 30, 80, 40][$i-1];
                $oldPrice = [10000, 45000, 2500, 8000, 150000, 12000, 5000, 35000][$i-1];
                $price = $oldPrice - ($oldPrice * ($discount / 100));
                $image = [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1608043152269-41fa42981329?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&q=80&w=300'
                ][$i-1];
            @endphp
            
            <div class="product-card card h-100 border-0 rounded overflow-hidden">
                <div class="product-img-wrap position-relative bg-light pt-4 pb-3 px-3 d-flex align-items-center justify-content-center">
                    
                    {{-- Badges --}}
                    <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1" style="z-index: 2;">
                        <span class="badge bg-danger text-white px-2 py-1 text-uppercase fw-bold" style="font-size:.65rem; letter-spacing:.5px;">-{{ $discount }}% OFF</span>
                        @if($i % 2 == 0)
                        <span class="badge bg-warning text-dark px-2 py-1 text-uppercase fw-bold" style="font-size:.65rem; letter-spacing:.5px;">Hot</span>
                        @endif
                    </div>

                    {{-- Wishlist btn --}}
                    <button class="btn wishlist-btn position-absolute top-0 end-0 m-2 rounded-circle bg-white text-muted shadow-sm" style="width:34px;height:34px;z-index:2;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-regular fa-heart"></i>
                    </button>

                    <a href="{{ url('/products/deal-item-' . $i) }}">
                        <img src="{{ $image }}" 
                             alt="Deal item" class="img-fluid product-img transition-transform" style="max-height: 180px; object-fit:contain;">
                    </a>
                </div>

                <div class="card-body p-3 d-flex flex-column bg-white border border-top-0 rounded-bottom">
                    <div class="text-muted fs-xs text-uppercase mb-1" style="letter-spacing: .5px;">Vendor Store</div>
                    <h3 class="product-title fw-600 mb-2 line-clamp-2" style="font-size: .9rem; line-height: 1.3;">
                        <a href="{{ url('/products/deal-item-' . $i) }}" class="text-dark text-decoration-none">Amazing Flash Deal Product #{{ $i }}</a>
                    </h3>
                    
                    {{-- Ratings --}}
                    <div class="d-flex align-items-center gap-1 mb-2 fs-xs text-warning">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        <span class="text-muted ms-1">(120)</span>
                    </div>

                    <div class="mt-auto pt-2 d-flex align-items-end justify-content-between">
                        <div>
                            <div class="text-muted text-decoration-line-through fs-xs">Rs {{ number_format($oldPrice) }}</div>
                            <div class="text-danger fw-900 fs-5 mb-0" style="line-height: 1;">Rs {{ number_format($price) }}</div>
                        </div>
                        <button class="btn btn-brand btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:36px;height:36px;" title="Add to Cart">
                            <i class="fa-solid fa-cart-shopping fs-xs"></i>
                        </button>
                    </div>
                    
                    {{-- Deal Stock Progress --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between fs-xs mb-1">
                            <span class="text-danger fw-bold">Only {{ rand(2, 15) }} left!</span>
                            <span class="text-muted">Sold: {{ rand(50, 200) }}</span>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ rand(70, 95) }}%"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endfor

    </div>

    {{-- Load More CTA --}}
    <div class="text-center mt-2">
        <button class="btn btn-outline-secondary rounded-pill px-5 py-2 fw-bold text-dark border-2 bg-white shadow-sm">
            Load More Deals <i class="fa fa-rotate-right ms-2 fs-xs"></i>
        </button>
    </div>

</div>

@endsection

@push('styles')
<style>
/* Utilities */
.fs-sm { font-size: 0.85rem; }
.fs-xs { font-size: 0.75rem; }
.fw-500 { font-weight: 500; }
.fw-600 { font-weight: 600; }
.fw-900 { font-weight: 900; }

.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }

/* Product Card Override slightly for deals */
.product-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.product-card:hover { transform: translateY(-4px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important; }
.product-img-wrap { border: 1px solid var(--border-light); border-bottom: 0; border-radius: inherit; border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
.transition-transform { transition: transform 0.3s ease; }
.product-card:hover .transition-transform { transform: scale(1.05); }
.product-title a:hover { color: var(--brand-primary) !important; }

.wishlist-btn { border: 1px solid var(--border-light); transition: all 0.2s; }
.wishlist-btn:hover { background: #fee2e2 !important; color: #dc2626 !important; border-color: #fecaca !important; }

/* Deals specific */
.time-box { box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }

/* Hide scrollbar for category filters on mobile */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@push('scripts')
<script>
// Simple demo decrement for the Seconds box to make it feel "Live"
document.addEventListener('DOMContentLoaded', function() {
    const secBox = document.querySelector('.time-box.bg-danger');
    if(!secBox) return;
    
    let secs = parseInt(secBox.innerText);
    setInterval(() => {
        secs--;
        if(secs < 0) secs = 59;
        secBox.innerText = secs.toString().padStart(2, '0');
    }, 1000);
});
</script>
@endpush
