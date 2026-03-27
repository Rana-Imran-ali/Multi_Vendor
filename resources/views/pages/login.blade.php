@extends('layouts.app')

@section('title', 'Login | Vendo')

@push('styles')
<style>
    .auth-page-wrapper { display: flex; align-items: center; justify-content: center; padding: 4rem 1rem; }
    
    .auth-container { display: flex; width: 1000px; max-width: 100%; min-height: 600px; background: var(--surface); border-radius: 1.5rem; box-shadow: var(--shadow-lg); overflow: hidden; position: relative; border: 1px solid var(--border); }
    
    .auth-form-side { width: 50%; padding: 4rem; display: flex; flex-direction: column; justify-content: center; position: relative; background: var(--surface); z-index: 2; }
    
    .auth-brand-side { width: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 4rem; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; position: relative; overflow: hidden; z-index: 1; }
    
    /* Abstract decorative shapes */
    .auth-brand-side::before { content: ''; position: absolute; top: -20%; left: -20%; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(40px); }
    .auth-brand-side::after { content: ''; position: absolute; bottom: -20%; right: -20%; width: 400px; height: 400px; background: rgba(0,0,0,0.1); border-radius: 50%; filter: blur(50px); }
    
    .auth-brand-side h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; position: relative; z-index: 2; line-height: 1.2; }
    .auth-brand-side p { font-size: 1.1rem; opacity: 0.9; max-width: 300px; line-height: 1.6; position: relative; z-index: 2; }

    /* Form elements */
    .auth-header { margin-bottom: 2rem; }
    .auth-header h2 { font-size: 2rem; font-weight: 800; color: var(--text); margin-bottom: 0.5rem; }
    .auth-header p { color: var(--text-muted); }
    
    .divider { display: flex; align-items: center; text-align: center; margin: 1.5rem 0; color: var(--text-muted); font-size: 0.9rem; }
    .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid var(--border); }
    .divider::before { margin-right: 0.75rem; }
    .divider::after { margin-left: 0.75rem; }
    
    .social-login { display: flex; gap: 1rem; }
    .social-btn { flex: 1; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; border: 1px solid var(--border); border-radius: 0.5rem; background: var(--surface); color: var(--text); font-weight: 600; cursor: pointer; transition: var(--transition); }
    .social-btn:hover { background: var(--background); box-shadow: var(--shadow-sm); border-color: var(--primary-light); }
    
    @media (max-width: 900px) {
        .auth-container { flex-direction: column; min-height: auto; }
        .auth-form-side, .auth-brand-side { width: 100%; padding: 2.5rem 1.5rem; }
        .auth-brand-side { display: none; }
    }
</style>
@endpush

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-container fade-in">
        
        <div class="auth-form-side">
            <!-- LOGIN FORM -->
            <form id="login-form">
                <div class="auth-header">
                    <h2>Welcome Back</h2>
                    <p>Enter your details to access your account.</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>
                <div class="form-group" style="position:relative;">
                    <label class="form-label" style="display:flex; justify-content:space-between;">
                        <span>Password</span>
                        <a href="#" style="color:var(--primary); font-weight:500;">Forgot Password?</a>
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width:100%; padding:1rem; font-size:1.1rem; margin-top:0.5rem; box-shadow:0 4px 14px rgba(79, 70, 229, 0.4);">Sign In</button>
                
                <div class="divider">Or continue with</div>
                <div class="social-login">
                    <button type="button" class="social-btn"><i class="fa-brands fa-google" style="color:#ea4335;"></i> Google</button>
                    <button type="button" class="social-btn"><i class="fa-brands fa-facebook" style="color:#1877f2;"></i> Facebook</button>
                </div>
                
                <p style="text-align:center; margin-top:2rem; color:var(--text-muted);">
                    Don't have an account? <a href="{{ url('/register') }}" style="color:var(--primary); font-weight:600;">Create one</a>
                </p>
            </form>
        </div>
        
        <div class="auth-brand-side">
            <div style="font-size: 5rem; margin-bottom: 1.5rem;"><i class="fa-solid fa-basket-shopping"></i></div>
            <h1>The ultimate shopping destination.</h1>
            <p>Discover thousands of local and international brands, exclusive deals, and premium products tailored just for you.</p>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Login Logic using Fetch API
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = this.querySelector('input[name="email"]').value;
        const password = this.querySelector('input[name="password"]').value;
        const btn = this.querySelector('button[type="submit"]');
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Signing In...';
        btn.disabled = true;

        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email, password })
            });
            
            const data = await res.json();
            
            if (res.ok) {
                localStorage.setItem('auth_token', data.data.token);
                localStorage.setItem('user_data', JSON.stringify(data.data.user));
                window.location.href = '{{ url('/') }}';
            } else {
                alert(data.message || 'Login failed');
            }
        } catch (err) {
            alert('Connection error');
        } finally {
            btn.innerHTML = 'Sign In';
            btn.disabled = false;
        }
    });
</script>
@endpush
