@extends('layouts.app')

@section('title', 'Create Account — Vendo')
@section('meta_description', 'Sign up for a FREE Vendo account to unlock exclusive deals, save your favorites, and checkout faster.')

@section('content')

<section class="auth-section">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                
                <div class="auth-card">
                    
                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}" class="auth-logo">
                            Vendo<span class="text-brand">.</span>
                        </a>
                        <h1 class="auth-title">Create an Account</h1>
                        <p class="auth-subtitle">Join us today to get the best deals and fast checkout</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="auth-form row g-3">
                        @csrf

                        {{-- Full Name --}}
                        <div class="col-12">
                            <label class="form-label auth-label" for="name">Full Name</label>
                            <div class="position-relative">
                                <i class="fa-regular fa-user auth-input-icon"></i>
                                <input type="text" id="name" name="name" 
                                       class="form-control auth-input @error('name') is-invalid @enderror" 
                                       placeholder="e.g. Ali Khan" value="{{ old('name') }}" required autofocus>
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block fs-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label auth-label" for="email">Email Address</label>
                            <div class="position-relative">
                                <i class="fa-regular fa-envelope auth-input-icon"></i>
                                <input type="email" id="email" name="email" 
                                       class="form-control auth-input @error('email') is-invalid @enderror" 
                                       placeholder="name@example.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block fs-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Field --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label auth-label" for="phone">Phone Number</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-phone auth-input-icon"></i>
                                <input type="tel" id="phone" name="phone" 
                                       class="form-control auth-input @error('phone') is-invalid @enderror" 
                                       placeholder="03xx-xxxxxxx" value="{{ old('phone') }}" required>
                            </div>
                            @error('phone')
                            <div class="invalid-feedback d-block fs-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label auth-label" for="password">Password</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-lock auth-input-icon"></i>
                                <input type="password" id="password" name="password" 
                                       class="form-control auth-input @error('password') is-invalid @enderror" 
                                       placeholder="Min 8 characters" required>
                                <button type="button" class="auth-eye-btn" onclick="togglePassword('password', this)" tabindex="-1">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block fs-xs">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label auth-label" for="password_confirmation">Confirm Password</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-lock auth-input-icon"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-control auth-input" 
                                       placeholder="Repeat password" required>
                            </div>
                        </div>

                        {{-- Terms checkbox --}}
                        <div class="col-12 mt-3 mb-2">
                            <label class="ck-check-row">
                                <input type="checkbox" name="terms" id="terms" class="ck-checkbox" required>
                                <span class="text-secondary select-none" style="font-size: .8rem; padding-top:2px;">
                                    I agree to Vendo's 
                                    <a href="#" class="text-brand fw-700 text-decoration-underline">Terms of Service</a> & 
                                    <a href="#" class="text-brand fw-700 text-decoration-underline">Privacy Policy</a>
                                </span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-brand w-100 py-3 mt-2 fs-6 fw-bold shadow-sm" style="border-radius: var(--radius-md);">
                                Create Account <i class="fa fa-user-plus ms-2"></i>
                            </button>
                        </div>

                    </form>

                    {{-- Login Link --}}
                    <div class="text-center mt-4">
                        <p class="auth-bottom-text mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-brand fw-700 text-decoration-underline">Log In</a>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Base */
.auth-section { 
    background: #f7f8fa; 
    min-height: calc(100vh - 80px - 36px); 
    display: flex; align-items: center; padding: 4rem 0; 
}
.auth-card {
    background: #fff; border: 1px solid var(--border-light);
    border-radius: var(--radius-lg); padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
}

/* Typography */
.auth-logo {
    display: inline-block; font-size: 2rem; font-weight: 900;
    color: var(--text-primary); text-decoration: none;
    letter-spacing: -1px; line-height: 1; margin-bottom: .5rem;
}
.auth-title { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: .25rem; letter-spacing: -.5px; }
.auth-subtitle { font-size: .9rem; color: var(--text-secondary); margin: 0; }

/* Forms */
.auth-label { font-size: .8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: .4rem; }
.auth-input {
    padding: .65rem 1rem .65rem 2.75rem;
    border: 1.5px solid var(--border-light);
    border-radius: var(--radius-sm);
    font-size: .9rem; font-family: var(--font-base);
    color: var(--text-primary); background: #fff;
    transition: all .2s; outline: none; box-shadow: none !important;
}
.auth-input:focus { border-color: var(--brand-primary); }
.auth-input.is-invalid {
    border-color: #dc3545; background-image: none !important; padding-right: 2.5rem;
}
.auth-input::placeholder { color: #a1aab7; }

/* Icons inside inputs */
.auth-input-icon {
    position: absolute; left: 1.1rem; top: 50%; transform: translateY(-50%);
    color: var(--text-muted); font-size: .95rem; pointer-events: none; z-index: 5;
}
.auth-input:focus ~ .auth-input-icon { color: var(--brand-primary); }

.auth-eye-btn {
    position: absolute; right: .5rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; padding: .5rem;
    color: var(--text-muted); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 5;
}
.auth-eye-btn:hover { color: var(--text-primary); }

.ck-check-row { display: flex; align-items: flex-start; gap: .5rem; cursor: pointer; margin:0; }
.ck-checkbox { width: 15px; height: 15px; margin-top: 3px; accent-color: var(--brand-primary); cursor:pointer; }
.select-none { user-select: none; }
.fs-xs { font-size: .75rem; }

.auth-bottom-text { font-size: .85rem; color: var(--text-secondary); }

/* Mobile */
@media (max-width: 575.98px) {
    .auth-section { padding: 2rem 0; }
    .auth-card { padding: 1.5rem; border-radius: var(--radius-md); border-left:none; border-right:none; border-top:1px solid var(--border-light); border-bottom:1px solid var(--border-light); box-shadow:none; }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const inp = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if(inp.type === 'password') {
        inp.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
