@extends('layouts.app')

@section('title', 'Contact Us | Vendo')

@push('styles')
<style>
    .contact-layout { display: flex; gap: 4rem; align-items: stretch; margin-top: 2rem; margin-bottom: 5rem; }
    
    .contact-info { width: 40%; background: #fff; border: 1px solid var(--border-light); border-radius: 1.5rem; padding: 3rem; display: flex; flex-direction: column; justify-content: center; box-shadow: var(--shadow-sm); }
    .contact-info h2 { font-size: 2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem; }
    .contact-info p { color: var(--text-muted); line-height: 1.6; margin-bottom: 2.5rem; font-size: 1.05rem; }
    
    .info-item { display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: flex-start; }
    .info-icon { width: 50px; height: 50px; background: rgba(240,79,35,0.1); color: var(--brand-primary); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
    .info-text h4 { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .info-text span { color: var(--text-secondary); font-size: 0.95rem; line-height: 1.5; }
    
    .social-links { display: flex; gap: 1rem; margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--border-light); }
    .social-link { width: 45px; height: 45px; border-radius: 50%; border: 1px solid var(--border-light); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: var(--transition); font-size: 1.25rem; text-decoration: none; }
    .social-link:hover { background: var(--brand-primary); color: white; border-color: var(--brand-primary); transform: translateY(-3px); }

    .contact-form-side { width: 60%; background: #fff; border: 1px solid var(--border-light); border-radius: 1.5rem; padding: 4rem; box-shadow: var(--shadow-sm); }
    .contact-form-side h3 { font-size: 1.75rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.5rem; }
    .contact-form-side p { color: var(--text-secondary); margin-bottom: 2.5rem; }
    
    .form-row { display: flex; gap: 1.5rem; margin-bottom: 1.5rem; }
    .form-row .form-group { width: 50%; margin-bottom: 0; }
    
    /* Map Placeholder */
    .map-wrapper { width: 100%; height: 400px; background: #e5e7eb; border-radius: 1.5rem; margin-bottom: 5rem; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.25rem; overflow: hidden; position: relative; }

    @media (max-width: 1024px) {
        .contact-layout { flex-direction: column; }
        .contact-info, .contact-form-side { width: 100%; padding: 2.5rem 1.5rem; }
        .form-row { flex-direction: column; gap: 1.5rem; }
        .form-row .form-group { width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="bg-light" style="padding: 4rem 0 2rem; border-bottom: 1px solid var(--border-light);">
    <div class="container-xl">
        <h1 class="fw-bold" style="font-size:3rem; letter-spacing: -1px;">Get in Touch</h1>
        <p class="text-secondary" style="max-width:600px; font-size: 1.1rem;">We'd love to hear from you. Our friendly team is always here to chat and help you with any questions.</p>
    </div>
</div>

<section class="container-xl">
    <div class="contact-layout">
        
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p>Fill out the form and our team will get back to you within 24 hours.</p>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                <div class="info-text">
                    <h4>Phone Number</h4>
                    <span>+1 (555) 123-4567<br>Mon-Fri 9am-6pm PST</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                <div class="info-text">
                    <h4>Email Address</h4>
                    <span>support@vendomarket.com<br>sales@vendomarket.com</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="info-text">
                    <h4>Store Location</h4>
                    <span>123 Commerce Avenue<br>San Francisco, CA 94103</span>
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="contact-form-side">
            <h3>Send Us a Message</h3>
            <p>Have a question or feedback? We are ready to help.</p>

            <form onsubmit="event.preventDefault(); alert('Message sent successfully!');">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label auth-label">First Name</label>
                        <input type="text" class="form-control auth-input" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label auth-label">Last Name</label>
                        <input type="text" class="form-control auth-input" placeholder="Doe" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label auth-label">Email Address</label>
                        <input type="email" class="form-control auth-input" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label auth-label">Phone Number <span style="font-weight:400;font-size:0.85rem;" class="text-muted">(Optional)</span></label>
                        <input type="tel" class="form-control auth-input" placeholder="+1 (555) 000-0000">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label auth-label">Subject</label>
                    <input type="text" class="form-control auth-input" placeholder="How can we help you?" required>
                </div>

                <div class="mb-4">
                    <label class="form-label auth-label">Message</label>
                    <textarea class="form-control auth-input" rows="5" placeholder="Include all the details you think are necessary..." required style="resize:vertical;"></textarea>
                </div>

                <button type="submit" class="btn btn-brand w-100 py-3 mt-2 fs-6 fw-bold shadow-sm" style="border-radius: var(--radius-md);">
                    <i class="fa-regular fa-paper-plane me-2"></i> Send Message
                </button>
            </form>
        </div>

    </div>

    <!-- Google Maps Placeholder -->
    <div class="map-wrapper shadow-sm">
        <div style="position:absolute; inset:0; background: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><path d=\"M20,20 L80,20 L80,80 L20,80 Z\" fill=\"none\" stroke=\"%23cbd5e1\" stroke-width=\"1\"/><circle cx=\"50\" cy=\"50\" r=\"5\" fill=\"%234f46e5\"/></svg>') center center; opacity:0.3; pointer-events:none;"></div>
        <div style="z-index: 2; display:flex; flex-direction:column; align-items:center; gap:0.5rem;">
            <i class="fa-solid fa-map-location-dot" style="font-size:2.5rem; color: #adb5bd;"></i>
            <span>Interactive Map Placeholder</span>
        </div>
    </div>
</section>

@endsection
