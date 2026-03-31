@extends('layouts.app')

@section('title', 'Login — Vendo')
@section('meta_description', 'Sign in to your Vendo account to manage your orders, wishlist, and settings.')

@section('content')

<section class="auth-section">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                
                <div class="auth-card">
                    
                    {{-- Logo / Header --}}
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}" class="auth-logo">
                            Vendo<span class="text-brand">.</span>
                        </a>
                        <h1 class="auth-title">Welcome Back</h1>
                        <p class="auth-subtitle">Log in to your account to continue</p>
                    </div>

                    {{-- Flash Errors (if any) --}}
                    @if(session('error'))
                    <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 py-2 px-3 text-danger" style="font-size:.85rem;">
                        <i class="fa fa-circle-exclamation me-2"></i> {{ session('error') }}
                    </div>
                    @endif

                    {{-- API Error Container --}}
                    <div id="loginErrorContainer" class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 py-2 px-3 text-danger d-none" style="font-size:.85rem;">
                        <i class="fa fa-circle-exclamation me-2"></i> <span id="loginErrorText"></span>
                    </div>

                    <form id="loginForm" class="auth-form">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label class="form-label auth-label" for="email">Email Address</label>
                            <div class="position-relative">
                                <i class="fa-regular fa-envelope auth-input-icon"></i>
                                <input type="email" id="email" name="email" 
                                       class="form-control auth-input" 
                                       placeholder="name@example.com" required autofocus>
                            </div>
                            <div id="emailError" class="invalid-feedback d-none fs-xs"></div>
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label auth-label mb-0" for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="auth-forgot-link">Forgot password?</a>
                                @endif
                            </div>
                            <div class="position-relative">
                                <i class="fa-solid fa-lock auth-input-icon"></i>
                                <input type="password" id="password" name="password" 
                                       class="form-control auth-input" 
                                       placeholder="Enter your password" required>
                                <button type="button" class="auth-eye-btn" onclick="togglePassword('password', this)" tabindex="-1">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordError" class="invalid-feedback d-none fs-xs"></div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4">
                            <label class="ck-check-row">
                                <input type="checkbox" name="remember" id="remember" class="ck-checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <span class="text-secondary select-none" style="font-size: .85rem; padding-top:2px;">Remember me on this device</span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-brand w-100 py-2 fs-6 fw-bold shadow-sm">
                            Log In <i class="fa fa-arrow-right-to-bracket ms-2"></i>
                        </button>

                    </form>

                    {{-- Social Login Divider --}}
                    <div class="auth-divider">
                        <span>OR CONTINUE WITH</span>
                    </div>

                    {{-- Social Buttons --}}
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="#" class="btn auth-social-btn w-100">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" width="16">
                                Google
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn auth-social-btn w-100 text-primary">
                                <i class="fa-brands fa-facebook fs-5"></i>
                                Facebook
                            </a>
                        </div>
                    </div>

                    {{-- Register Link --}}
                    <div class="text-center mt-4 pt-2">
                        <p class="auth-bottom-text mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-brand fw-700 text-decoration-underline">Sign up</a>
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
    background: #fff;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
}

/* Typography */
.auth-logo {
    display: inline-block;
    font-size: 2rem; font-weight: 900;
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
    color: var(--text-muted); font-size: .9rem; pointer-events: none; z-index: 5;
}
.auth-input:focus ~ .auth-input-icon { color: var(--brand-primary); }

.auth-eye-btn {
    position: absolute; right: .5rem; top: 50%; transform: translateY(-50%);
    background: none; border: none; padding: .5rem;
    color: var(--text-muted); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 5;
}
.auth-eye-btn:hover { color: var(--text-primary); }

/* Links & Checkbox */
.auth-forgot-link { font-size: .75rem; font-weight: 600; color: var(--brand-primary); text-decoration: none; }
.auth-forgot-link:hover { text-decoration: underline; }

.ck-check-row { display: flex; align-items: flex-start; gap: .5rem; cursor: pointer; margin:0; }
.ck-checkbox { width: 15px; height: 15px; margin-top: 3px; accent-color: var(--brand-primary); cursor:pointer; }
.select-none { user-select: none; }
.fs-xs { font-size: .75rem; }

/* Divider */
.auth-divider {
    display: flex; align-items: center; text-align: center;
    margin: 1.75rem 0; color: var(--text-muted); font-size: .7rem; font-weight: 700; letter-spacing: 1px;
}
.auth-divider::before, .auth-divider::after {
    content: ''; flex: 1; border-bottom: 1px solid var(--border-light);
}
.auth-divider span { padding: 0 1rem; }

/* Social Buttons */
.auth-social-btn {
    background: #fff; border: 1.5px solid var(--border-light);
    color: var(--text-primary); font-size: .85rem; font-weight: 600;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    padding: .6rem; border-radius: var(--radius-sm); transition: var(--transition);
}
.auth-social-btn:hover { background: #f7f8fa; border-color: #cbd5e1; }

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

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    if(loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Clear prior errors
            document.getElementById('loginErrorContainer').classList.add('d-none');
            document.querySelectorAll('.auth-input').forEach(i => i.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(f => f.classList.add('d-none'));

            const btn = loginForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Logging in...';
            btn.disabled = true;

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                if (!window.Auth) throw new Error("Auth helper not loaded.");
                
                const response = await window.Auth.login(email, password);
                
                if(response.success) {
                    // Redirect based on role
                    window.location.href = window.Auth.getRedirectUrl();
                } else {
                    // Display general error
                    if(!response.errors) {
                        document.getElementById('loginErrorText').textContent = response.message;
                        document.getElementById('loginErrorContainer').classList.remove('d-none');
                    } else {
                        // Display validation errors
                        if(response.errors.email) {
                            const emF = document.getElementById('email');
                            emF.classList.add('is-invalid');
                            const emE = document.getElementById('emailError');
                            emE.textContent = response.errors.email[0];
                            emE.classList.remove('d-none');
                        }
                        if(response.errors.password) {
                            const pwF = document.getElementById('password');
                            pwF.classList.add('is-invalid');
                            const pwE = document.getElementById('passwordError');
                            pwE.textContent = response.errors.password[0];
                            pwE.classList.remove('d-none');
                        }
                    }
                }
            } catch (err) {
                console.error(err);
                document.getElementById('loginErrorText').textContent = 'An unexpected error occurred. Please try again.';
                document.getElementById('loginErrorContainer').classList.remove('d-none');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }
});
</script>
@endpush
