@extends('layouts.app')

@section('title', 'Register | Vendo')

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
            <!-- REGISTER FORM -->
            <form id="register-form">
                <div class="auth-header">
                    <h2>Create Account</h2>
                    <p>Join millions of shoppers discovering unique items.</p>
                </div>
                
                <div style="display:flex; gap:1rem;">
                    <div class="form-group" style="flex:1;">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="John" required>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                </div>
                
                <div style="margin: 1rem 0;">
                    <label style="display:flex;align-items:flex-start;gap:0.75rem;cursor:pointer;font-size:0.85rem;color:var(--text-muted);line-height:1.4;">
                        <input type="checkbox" required style="margin-top:0.25rem;">
                        <span>I agree to Vendo's <a href="#" style="color:var(--primary);font-weight:600;">Terms of Service</a> and <a href="#" style="color:var(--primary);font-weight:600;">Privacy Policy</a>.</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-accent" style="width:100%; padding:1rem; font-size:1.1rem; box-shadow:0 4px 14px rgba(245, 158, 11, 0.4);">Sign Up</button>
                
                <p style="text-align:center; margin-top:2rem; color:var(--text-muted);">
                    Already have an account? <a href="{{ url('/login') }}" style="color:var(--primary); font-weight:600;">Log in</a>
                </p>
            </form>
        </div>
        
        <div class="auth-brand-side" style="background: linear-gradient(135deg, var(--accent) 0%, #d97706 100%);">
            <div style="font-size: 5rem; margin-bottom: 1.5rem;"><i class="fa-solid fa-gift"></i></div>
            <h1>Unlock endless possibilities.</h1>
            <p>Join the fastest-growing marketplace. Buy amazing products from verified sellers around the globe.</p>
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Register Logic
    document.getElementById('register-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const firstName = this.querySelector('input[name="first_name"]').value;
        const lastName = this.querySelector('input[name="last_name"]').value;
        const name = firstName + ' ' + lastName;
        const email = this.querySelector('input[name="email"]').value;
        const password = this.querySelector('input[name="password"]').value;
        const btn = this.querySelector('button[type="submit"]');

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Signing Up...';
        btn.disabled = true;

        try {
            const res = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ 
                    name: name,
                    email: email, 
                    password: password,
                    password_confirmation: password,
                    role: 'user' // Default to user
                })
            });
            
            const data = await res.json();
            
            if (res.ok) {
                localStorage.setItem('auth_token', data.data.token);
                localStorage.setItem('user_data', JSON.stringify(data.data.user));
                window.location.href = '{{ url('/') }}';
            } else {
                alert(data.message || Object.values(data.errors || {})[0] || 'Registration failed');
            }
        } catch (err) {
            alert('Connection error');
        } finally {
            btn.innerHTML = 'Sign Up';
            btn.disabled = false;
        }
    });
</script>
@endpush
