@extends('layouts.app')

@section('title', 'About Us — Vendo')
@section('meta_description', 'Learn more about Vendo, our mission to empower local businesses, and our commitment to bringing you the best products.')

@section('content')

{{-- HERO SECTION --}}
<section class="about-hero text-center py-5 mb-5 bg-light position-relative overflow-hidden">
    <div class="container-xl position-relative z-1 py-4">
        <h1 class="fw-900 text-dark mb-3" style="letter-spacing:-1.5px; font-size: 3rem;">Redefining E-Commerce</h1>
        <p class="text-muted fs-5 mx-auto mb-4" style="max-width:600px; line-height: 1.6;">
            We're on a mission to empower local sellers and provide customers with a seamless, trustworthy, and modern shopping experience.
        </p>
        <a href="{{ url('/shop') }}" class="btn btn-brand rounded-pill px-4 py-2 fw-bold shadow-sm fs-6">
            Start Shopping <i class="fa fa-arrow-right ms-2"></i>
        </a>
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-5" style="z-index: 0;"></div>
</section>

{{-- STATS SECTION --}}
<section class="container-xl mb-5 pb-5 border-bottom border-light">
    <div class="row g-4 text-center">
        <div class="col-6 col-md-3">
            <h2 class="fw-900 text-brand mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">1.2M+</h2>
            <p class="text-secondary fw-600 fs-sm text-uppercase" style="letter-spacing: 1px;">Active Users</p>
        </div>
        <div class="col-6 col-md-3">
            <h2 class="fw-900 text-brand mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">15k+</h2>
            <p class="text-secondary fw-600 fs-sm text-uppercase" style="letter-spacing: 1px;">Verified Vendors</p>
        </div>
        <div class="col-6 col-md-3">
            <h2 class="fw-900 text-brand mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">4.5M</h2>
            <p class="text-secondary fw-600 fs-sm text-uppercase" style="letter-spacing: 1px;">Products Listed</p>
        </div>
        <div class="col-6 col-md-3">
            <h2 class="fw-900 text-brand mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">24/7</h2>
            <p class="text-secondary fw-600 fs-sm text-uppercase" style="letter-spacing: 1px;">Customer Support</p>
        </div>
    </div>
</section>

{{-- OUR STORY --}}
<section class="container-xl mb-5 pb-5">
    <div class="row align-items-center g-5">
        <div class="col-12 col-lg-6">
            <div class="rounded-4 overflow-hidden shadow" style="height: 400px; background: #e2e8f0;">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1000" alt="Our Team" class="w-100 h-100 object-fit-cover">
            </div>
        </div>
        <div class="col-12 col-lg-6 px-lg-4">
            <h6 class="text-brand fw-bold mb-2 text-uppercase" style="letter-spacing: 2px; font-size: .8rem;">Our Story</h6>
            <h2 class="fw-800 text-dark mb-4" style="letter-spacing: -1px;">Built for the future of online retail.</h2>
            <p class="text-secondary mb-4" style="line-height: 1.8;">
                Founded in 2026, Vendo started as a small idea in a garage: what if we could build a marketplace that treats sellers like partners and buyers like family? 
                <br><br>
                Today, we operate one of the fastest-growing multi-vendor platforms in the region. We focus entirely on rigorous vendor verification, ultra-fast shipping logistics, and building beautiful software that gets out of your way.
            </p>
            <div class="d-flex gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width:30px;height:30px;"><i class="fa fa-check fs-xs"></i></div>
                    <span class="fw-bold fs-sm">Verified Trust</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:30px;height:30px;"><i class="fa fa-check fs-xs"></i></div>
                    <span class="fw-bold fs-sm">Global Reach</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CORE VALUES --}}
<section class="bg-light py-5 mb-5">
    <div class="container-xl py-4">
        <div class="text-center mb-5">
            <h2 class="fw-800 text-dark mb-2" style="letter-spacing: -1px;">Why Choose Vendo?</h2>
            <p class="text-muted">The core principles that drive everything we do.</p>
        </div>
        
        <div class="row g-4">
            {{-- Value 1 --}}
            <div class="col-12 col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border text-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;font-size:2rem;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Secure Shopping</h5>
                    <p class="text-muted fs-sm mb-0">Every transaction is encrypted and backed by our comprehensive buyer protection program.</p>
                </div>
            </div>
            {{-- Value 2 --}}
            <div class="col-12 col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;font-size:2rem;">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Lightning Fast</h5>
                    <p class="text-muted fs-sm mb-0">Our automated warehousing and routing ensures your order arrives in record time.</p>
                </div>
            </div>
            {{-- Value 3 --}}
            <div class="col-12 col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border text-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;font-size:2rem;">
                        <i class="fa-solid fa-people-carry-box"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Community First</h5>
                    <p class="text-muted fs-sm mb-0">We take only a 5% commission from local sellers to help small businesses thrive.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- JOIN CTA --}}
<section class="container-xl mb-5 pb-4 text-center">
    <div class="bg-dark rounded-4 p-5 position-relative overflow-hidden">
        <div class="position-relative z-1 py-4">
            <h2 class="fw-900 text-white mb-3" style="letter-spacing: -1px;">Ready to grow your business?</h2>
            <p class="text-white-50 fs-6 mx-auto mb-4" style="max-width:500px;">
                Join 15,000+ brands and local stores already selling on the Vendo platform. Start your seller journey today.
            </p>
            <a href="#" class="btn btn-brand rounded-pill px-4 py-2 fw-bold fs-6 shadow">Become a Seller <i class="fa fa-arrow-right ms-2"></i></a>
        </div>
        {{-- Background Graphic --}}
        <i class="fa-brands fa-shopify position-absolute text-white" style="font-size: 20rem; opacity: 0.03; right: -2rem; bottom: -5rem; z-index:0; transform: rotate(-15deg);"></i>
    </div>
</section>

@endsection

@push('styles')
<style>
.about-hero {
    background-image: radial-gradient(circle at top right, rgba(59,130,246,0.1) 0%, transparent 40%),
                      radial-gradient(circle at bottom left, rgba(59,130,246,0.05) 0%, transparent 40%);
}
.fs-sm { font-size: 0.85rem; }
.fw-600 { font-weight: 600; }
.fw-800 { font-weight: 800; }
.fw-900 { font-weight: 900; }
.object-fit-cover { object-fit: cover; }
.text-brand { color: var(--brand-primary); }
</style>
@endpush
