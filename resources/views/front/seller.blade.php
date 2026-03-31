@extends('layouts.app')

@section('title', 'Become a Seller | Vendo')

@push('styles')
<style>
    .seller-hero { 
        background: linear-gradient(135deg, var(--brand-primary) 0%, #d83b0b 100%); 
        color: white; 
        padding: 6rem 0; 
        position: relative; 
        overflow: hidden; 
    }
    .seller-hero::before { content: ''; position: absolute; top: -50px; left: -50px; width: 400px; height: 400px; background: rgba(255,255,255,0.1); border-radius: 50%; pointer-events: none; }
    .seller-hero::after { content: ''; position: absolute; bottom: -100px; right: -50px; width: 600px; height: 600px; background: rgba(0,0,0,0.1); border-radius: 50%; pointer-events: none; }
    .seller-hero h1 { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; line-height: 1.1; margin-bottom: 1.5rem; position: relative; z-index: 2; color: #fff; letter-spacing: -1px; }
    .seller-hero p { font-size: 1.25rem; opacity: 0.9; max-width: 650px; position: relative; z-index: 2; }

    .seller-layout { display: flex; gap: 5rem; align-items: stretch; margin-top: -3rem; position: relative; z-index: 5; margin-bottom: 5rem; }
    
    .benefits-col { flex: 1; padding-top: 5rem; }
    .benefit-item { display: flex; gap: 1.5rem; margin-bottom: 3rem; }
    .b-icon { width: 60px; height: 60px; background: rgba(240,79,35,0.1); color: var(--brand-primary); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; box-shadow: var(--shadow-sm); }
    .b-text h3 { font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; line-height: 1.2; }
    .b-text p { color: var(--text-muted); line-height: 1.6; }

    .form-col { width: 450px; flex-shrink: 0; }
    .seller-card { background: #fff; border: 1px solid var(--border-light); border-radius: 1.5rem; padding: 2.5rem 2rem; box-shadow: var(--shadow-md); }
    .seller-card h2 { font-size: 1.75rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.5rem; text-align: center; }
    .seller-card p { color: var(--text-muted); text-align: center; margin-bottom: 2rem; font-size: 0.95rem; }

    @media (max-width: 1024px) {
        .seller-layout { flex-direction: column; gap: 3rem; }
        .form-col { width: 100%; order: -1; }
        .benefits-col { padding-top: 1rem; }
    }
</style>
@endpush

@section('content')

<div class="seller-hero">
    <div class="container-xl">
        <h1>Turn Your Passion Into a<br><span style="color:#ffcc00;">Global Business</span></h1>
        <p>Join over 150,000 independent sellers who trust Vendo. Setup is free, easy, and gives you instant access to millions of active buyers worldwide.</p>
    </div>
</div>

<div class="container-xl">
    <div class="seller-layout">
        
        <div class="benefits-col">
            <div class="benefit-item">
                <div class="b-icon"><i class="fa-solid fa-globe"></i></div>
                <div class="b-text">
                    <h3>Global Reach</h3>
                    <p>Sell your items anywhere. We handle international currency conversions and global shipping logistics seamlessly across borders.</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="b-icon"><i class="fa-solid fa-percent"></i></div>
                <div class="b-text">
                    <h3>Low Commissions</h3>
                    <p>Keep more of what you earn. We charge a flat, transparent 5% fee on sales, with absolutely no hidden monthly subscription costs.</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="b-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div class="b-text">
                    <h3>Powerful Tools</h3>
                    <p>Get access to our advanced vendor dashboard, replete with analytics, inventory management, and automated promotional tools.</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="b-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="b-text">
                    <h3>Seller Protection</h3>
                    <p>Our dedicated seller support team and robust fraud AI protects you from chargebacks and fraudulent behavior 24/7.</p>
                </div>
            </div>
        </div>

        <div class="form-col">
            <div class="seller-card">
                <h2>Register Your Store</h2>
                <p>Start your journey as a Vendo merchant</p>
                
                {{-- Form hitting our register API for vendor creation --}}
                <div class="alert alert-danger d-none mb-3" id="sellerError" style="font-size: 0.85rem; padding: 0.5rem 1rem;"></div>
                
                <form id="sellerRegisterForm">
                    <div class="mb-3">
                        <label class="form-label auth-label">Store Name</label>
                        <div class="position-relative">
                            <i class="fa-solid fa-shop auth-input-icon"></i>
                            <input type="text" id="store_name" class="form-control auth-input" placeholder="E.g., TechNova Store" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label auth-label">Manager Full Name</label>
                        <div class="position-relative">
                            <i class="fa-solid fa-user auth-input-icon"></i>
                            <input type="text" id="seller_name" class="form-control auth-input" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label auth-label">Email Address</label>
                        <div class="position-relative">
                            <i class="fa-regular fa-envelope auth-input-icon"></i>
                            <input type="email" id="seller_email" class="form-control auth-input" placeholder="contact@store.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label auth-label">Account Password</label>
                        <div class="position-relative">
                            <i class="fa-solid fa-lock auth-input-icon"></i>
                            <input type="password" id="seller_password" class="form-control auth-input" placeholder="Create a strong password" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label auth-label">Confirm Password</label>
                        <div class="position-relative">
                            <i class="fa-solid fa-lock auth-input-icon"></i>
                            <input type="password" id="seller_password_confirmation" class="form-control auth-input" placeholder="Confirm password" required>
                        </div>
                    </div>
                    
                    <div class="mt-4 mb-3">
                        <label class="ck-check-row">
                            <input type="checkbox" class="ck-checkbox" required>
                            <span class="text-secondary select-none" style="font-size: .8rem; padding-top:2px;">
                                I agree to the <a href="#" class="text-brand fw-bold">Standard Seller Agreement</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-brand w-100 py-3 mt-2 fs-6 fw-bold shadow-sm" style="border-radius: var(--radius-md);">
                        Apply Now
                    </button>
                    
                    <p class="text-center mt-4 mb-0" style="font-size:0.9rem; color:var(--text-muted);">
                        Already have a seller account? <a href="{{ route('login') }}" style="color:var(--brand-primary); font-weight:600; text-decoration:none;">Log in</a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('sellerRegisterForm');
        if(!form) return;
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            const errDiv = document.getElementById('sellerError');
            const originalText = btn.innerHTML;
            
            errDiv.classList.add('d-none');
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Registering...';
            btn.disabled = true;
            
            // Re-using our Auth system to register but forcing 'vendor' role
            if(window.Auth) {
                try {
                    const name = document.getElementById('seller_name').value;
                    const email = document.getElementById('seller_email').value;
                    const pass = document.getElementById('seller_password').value;
                    const pass_conf = document.getElementById('seller_password_confirmation').value;
                    
                    const res = await window.Auth.register(name, email, pass, pass_conf, 'vendor');
                    
                    if(res.success) {
                        window.location.href = window.Auth.getRedirectUrl();
                    } else {
                        errDiv.textContent = res.message || 'Validation failed. Check your inputs.';
                        errDiv.classList.remove('d-none');
                    }
                } catch(err) {
                    errDiv.textContent = 'An expected error occurred configuring store details.';
                    errDiv.classList.remove('d-none');
                } finally {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            }
        });
    });
</script>
@endpush
@endsection
