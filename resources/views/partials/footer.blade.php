<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="logo"><i class="fa-solid fa-store"></i> <span>Vendo</span></a>
                <p>The premium multi-vendor marketplace connecting you with independent creators and established brands worldwide.</p>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ url('/shop') }}">Shop Categories</a></li>
                    <li><a href="{{ url('/vendor') }}">Our Vendors</a></li>
                    <li><a href="{{ url('/blog') }}">Latest News & Blog</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="{{ url('/login') }}">My Account</a></li>
                    <li><a href="#">Track Order</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Make Money With Us</h4>
                <ul>
                    <li><a href="{{ url('/register') }}">Sell on Vendo</a></li>
                    <li><a href="{{ url('/vendor-dashboard') }}">Vendor Center</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Vendo Marketplace. All rights reserved.</p>
            <div style="display:flex;gap:1.5rem;">
                <i class="fa-brands fa-cc-visa fa-2x"></i>
                <i class="fa-brands fa-cc-mastercard fa-2x"></i>
                <i class="fa-brands fa-cc-paypal fa-2x"></i>
            </div>
        </div>
    </div>
</footer>
