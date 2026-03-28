{{--
    ================================================================
    COMPONENT: components/footer.blade.php
    A rich, production-quality 4-column footer for Vendo.
    ================================================================
--}}

<footer class="vendo-footer">

    {{-- ===== NEWSLETTER STRIP ===== --}}
    <div class="footer-newsletter-strip">
        <div class="container-xl">
            <div class="row align-items-center gy-3">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="newsletter-icon">
                            <i class="fa fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-700">Stay in the loop</h5>
                            <p class="mb-0 text-white-70 small">Deals, new arrivals & exclusive offers — straight to your inbox.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form" action="{{ url('/newsletter/subscribe') }}" method="POST">
                        @csrf
                        <div class="newsletter-input-wrap">
                            <input type="email" name="email" placeholder="Enter your email address" required>
                            <button type="submit">Subscribe <i class="fa fa-arrow-right ms-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN FOOTER BODY ===== --}}
    <div class="footer-body">
        <div class="container-xl">
            <div class="row gy-5">

                {{-- ── Brand Column ── --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="{{ url('/') }}" class="footer-logo">
                        <span class="footer-logo-icon"><i class="fa fa-bag-shopping"></i></span>
                        <span class="footer-logo-text">Vendo</span>
                    </a>
                    <p class="footer-tagline">
                        Pakistan's modern multi-vendor marketplace — discover thousands of products from trusted local and international sellers.
                    </p>
                    <div class="footer-socials">
                        <a href="#" class="footer-social-btn" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="footer-social-btn" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="footer-social-btn" title="X / Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="footer-social-btn" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="footer-social-btn" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                {{-- ── Quick Links ── --}}
                <div class="col-6 col-sm-6 col-lg-3">
                    <h6 class="footer-col-heading">Quick Links</h6>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/shop') }}">Shop All</a></li>
                        <li><a href="{{ url('/categories') }}">Browse Categories</a></li>
                        <li><a href="{{ url('/vendors') }}">Our Vendors</a></li>
                        <li><a href="{{ url('/deals') }}">Today's Deals</a></li>
                        <li><a href="{{ url('/blog') }}">Blog</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                    </ul>
                </div>

                {{-- ── Customer Service ── --}}
                <div class="col-6 col-sm-6 col-lg-3">
                    <h6 class="footer-col-heading">Customer Service</h6>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('/help') }}">Help Center</a></li>
                        <li><a href="{{ url('/orders') }}">Track My Order</a></li>
                        <li><a href="{{ url('/returns') }}">Returns & Refunds</a></li>
                        <li><a href="{{ url('/shipping') }}">Shipping Policy</a></li>
                        <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}">FAQs</a></li>
                    </ul>
                </div>

                {{-- ── Sell on Vendo ── --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <h6 class="footer-col-heading">Sell on Vendo</h6>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('/become-seller') }}">Become a Seller</a></li>
                        <li><a href="{{ url('/vendor/login') }}">Vendor Login</a></li>
                        <li><a href="{{ url('/vendor/register') }}">Vendor Register</a></li>
                        <li><a href="{{ url('/seller-guide') }}">Seller Guide</a></li>
                        <li><a href="{{ url('/seller-fees') }}">Fee Structure</a></li>
                    </ul>

                    <div class="footer-app-badges mt-3">
                        <a href="#" class="app-badge-btn">
                            <i class="fab fa-apple fs-5"></i>
                            <span>
                                <small>Download on</small>
                                App Store
                            </span>
                        </a>
                        <a href="#" class="app-badge-btn">
                            <i class="fab fa-google-play fs-5"></i>
                            <span>
                                <small>Get it on</small>
                                Google Play
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== TRUST BADGES ROW ===== --}}
    <div class="footer-trust-row">
        <div class="container-xl">
            <div class="row gy-3 text-center justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="trust-item">
                        <i class="fa fa-truck-fast trust-icon"></i>
                        <span>Fast Delivery</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-item">
                        <i class="fa fa-rotate-left trust-icon"></i>
                        <span>Easy Returns</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-item">
                        <i class="fa fa-lock trust-icon"></i>
                        <span>Secure Payments</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-item">
                        <i class="fa fa-headset trust-icon"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== BOTTOM BAR ===== --}}
    <div class="footer-bottom">
        <div class="container-xl">
            <div class="row align-items-center gy-2">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-white-50">
                        &copy; {{ date('Y') }} Vendo. All rights reserved. Crafted with <i class="fa fa-heart text-danger mx-1" style="font-size:.7rem;"></i> in Pakistan.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-bottom-links">
                        <a href="{{ url('/privacy') }}">Privacy Policy</a>
                        <span class="sep">·</span>
                        <a href="{{ url('/terms') }}">Terms of Service</a>
                        <span class="sep">·</span>
                        <a href="{{ url('/sitemap') }}">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>

{{-- ===== BACK TO TOP BUTTON ===== --}}
<button id="backToTop" class="back-to-top" title="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fa fa-chevron-up"></i>
</button>

{{-- ===== FOOTER CSS ===== --}}
<style>
    /* ── Footer shell ── */
    .vendo-footer {
        font-family: var(--font-base);
    }

    /* ── Newsletter strip ── */
    .footer-newsletter-strip {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 2.25rem 0;
        border-top: 3px solid var(--brand-primary);
    }
    .newsletter-icon {
        width: 52px;
        height: 52px;
        background: rgba(240,79,35,.15);
        border: 1.5px solid rgba(240,79,35,.3);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-primary);
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .footer-newsletter-strip h5 { color: #fff; font-weight: 700; font-size: 1.05rem; }
    .text-white-70 { color: rgba(255,255,255,.65); }
    .newsletter-input-wrap {
        display: flex;
        background: rgba(255,255,255,.08);
        border: 1.5px solid rgba(255,255,255,.15);
        border-radius: 50px;
        overflow: hidden;
        transition: border-color .2s;
    }
    .newsletter-input-wrap:focus-within {
        border-color: var(--brand-primary);
    }
    .newsletter-input-wrap input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        padding: .7rem 1.25rem;
        font-size: .875rem;
        color: #fff;
    }
    .newsletter-input-wrap input::placeholder { color: rgba(255,255,255,.4); }
    .newsletter-input-wrap button {
        background: var(--brand-primary);
        border: none;
        color: #fff;
        padding: .7rem 1.4rem;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        border-radius: 0 50px 50px 0;
        transition: background .2s;
        white-space: nowrap;
    }
    .newsletter-input-wrap button:hover { background: var(--brand-dark); }

    /* ── Main footer body ── */
    .footer-body {
        background: var(--surface-footer);
        padding: 3.5rem 0 2rem;
    }

    /* Logo */
    .footer-logo {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        text-decoration: none;
        margin-bottom: 1rem;
    }
    .footer-logo-icon {
        width: 34px;
        height: 34px;
        background: var(--brand-primary);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: .9rem;
    }
    .footer-logo-text {
        font-size: 1.28rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.4px;
    }

    .footer-tagline {
        font-size: .84rem;
        color: rgba(255,255,255,.45);
        line-height: 1.7;
        margin-bottom: 1.25rem;
    }

    /* Socials */
    .footer-socials { display: flex; gap: .5rem; flex-wrap: wrap; }
    .footer-social-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.6);
        font-size: .85rem;
        text-decoration: none;
        transition: var(--transition);
    }
    .footer-social-btn:hover {
        background: var(--brand-primary);
        border-color: var(--brand-primary);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Column headings */
    .footer-col-heading {
        font-size: .73rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .9px;
        color: rgba(255,255,255,.9);
        margin-bottom: 1.1rem;
    }

    /* Link list */
    .footer-link-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-link-list li { margin-bottom: .55rem; }
    .footer-link-list a {
        font-size: .875rem;
        color: rgba(255,255,255,.45);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        transition: color .18s ease;
    }
    .footer-link-list a::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,.25);
        border-radius: 50%;
        flex-shrink: 0;
        transition: background .18s ease;
    }
    .footer-link-list a:hover {
        color: var(--brand-primary);
    }
    .footer-link-list a:hover::before {
        background: var(--brand-primary);
    }

    /* App badges */
    .footer-app-badges { display: flex; flex-direction: column; gap: .5rem; }
    .app-badge-btn {
        display: flex;
        align-items: center;
        gap: .6rem;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: var(--radius-sm);
        padding: .5rem .85rem;
        text-decoration: none;
        color: rgba(255,255,255,.8);
        transition: var(--transition);
        font-size: .8rem;
    }
    .app-badge-btn span { display: flex; flex-direction: column; line-height: 1.25; }
    .app-badge-btn small { font-size: .65rem; color: rgba(255,255,255,.4); }
    .app-badge-btn:hover {
        background: rgba(240,79,35,.15);
        border-color: var(--brand-primary);
        color: #fff;
    }

    /* ── Trust row ── */
    .footer-trust-row {
        background: #0d1117;
        border-top: 1px solid rgba(255,255,255,.06);
        padding: 1.5rem 0;
    }
    .trust-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .45rem;
        color: rgba(255,255,255,.55);
        font-size: .82rem;
        font-weight: 500;
    }
    .trust-icon {
        font-size: 1.5rem;
        color: var(--brand-primary);
    }

    /* ── Bottom bar ── */
    .footer-bottom {
        background: #0a0c0f;
        border-top: 1px solid rgba(255,255,255,.05);
        padding: .95rem 0;
    }
    .footer-bottom-links {
        display: flex;
        justify-content: flex-end;
        gap: .5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .footer-bottom-links a {
        font-size: .78rem;
        color: rgba(255,255,255,.4);
        text-decoration: none;
        transition: color .15s;
    }
    .footer-bottom-links a:hover { color: rgba(255,255,255,.8); }
    .footer-bottom-links .sep {
        color: rgba(255,255,255,.2);
        font-size: .78rem;
    }

    /* ── Back to top ── */
    .back-to-top {
        position: fixed;
        bottom: 28px;
        right: 24px;
        width: 42px;
        height: 42px;
        background: var(--brand-primary);
        color: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(240,79,35,.4);
        z-index: 999;
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s ease, transform .25s ease;
    }
    .back-to-top.visible {
        opacity: 1;
        pointer-events: auto;
    }
    .back-to-top:hover { transform: translateY(-3px); }

    /* Responsive */
    @media (max-width: 767.98px) {
        .footer-newsletter-strip { padding: 1.75rem 0; }
        .footer-body { padding: 2.5rem 0 1.5rem; }
        .newsletter-input-wrap { flex-direction: column; border-radius: var(--radius-md); }
        .newsletter-input-wrap button { border-radius: var(--radius-md); }
        .footer-bottom-links { justify-content: center; }
    }
</style>

{{-- ===== FOOTER JS ===== --}}
<script>
    // Back to top visibility
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });
</script>
