@extends('user.layout')

@section('user_content')
<div class="dashboard-card">
    <h4 class="dashboard-card-title border-bottom pb-3 mb-4">
        <i class="fa fa-user-pen text-brand"></i> My Profile Settings
    </h4>

    <div id="profileAlert" class="alert d-none mb-4 fs-sm" role="alert"></div>

    <form id="profileForm" class="row g-4 max-w-lg">
        <div class="col-12 col-md-6">
            <label class="form-label auth-label" for="profile_name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="profile_name" class="form-control auth-input" required>
            <div id="nameError" class="invalid-feedback d-none fs-xs"></div>
        </div>

        <div class="col-12 col-md-6">
            <label class="form-label auth-label" for="profile_email">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="profile_email" class="form-control auth-input" required>
            <div class="form-text fs-xs text-muted">Changing your email requires relogin.</div>
            <div id="emailError" class="invalid-feedback d-none fs-xs"></div>
        </div>

        <div class="col-12">
            <h6 class="mt-2 mb-3 fw-bold border-bottom pb-2">Change Password <span class="fw-normal text-muted fs-xs">(Leave blank to keep current)</span></h6>
        </div>

        <div class="col-12 col-md-6">
            <label class="form-label auth-label" for="profile_password">New Password</label>
            <input type="password" id="profile_password" class="form-control auth-input" placeholder="Min 8 chars">
            <div id="passwordError" class="invalid-feedback d-none fs-xs"></div>
        </div>

        <div class="col-12 col-md-6">
            <label class="form-label auth-label" for="profile_password_confirmation">Confirm Password</label>
            <input type="password" id="profile_password_confirmation" class="form-control auth-input" placeholder="Repeat password">
        </div>

        <div class="col-12 mt-4 pt-2">
            <button type="submit" class="btn btn-brand w-100 py-2 fs-6 fw-bold">
                Save Changes <i class="fa fa-save ms-1"></i>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Auth || !window.Auth.check()) return;

        // Populate fields
        const user = window.Auth.getUser();
        document.getElementById('profile_name').value = user.name;
        document.getElementById('profile_email').value = user.email;

        // Handle Submit
        const form = document.getElementById('profileForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = form.querySelector('button[type="submit"]');
            const alertBox = document.getElementById('profileAlert');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
            btn.disabled = true;
            
            // clear alerts
            alertBox.classList.add('d-none');
            alertBox.className = 'alert d-none mb-4 fs-sm';
            document.querySelectorAll('.auth-input').forEach(i => i.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(f => f.classList.add('d-none'));

            const payload = {
                name: document.getElementById('profile_name').value,
                email: document.getElementById('profile_email').value
            };

            const pw = document.getElementById('profile_password').value;
            if(pw.trim() !== '') {
                payload.password = pw;
                payload.password_confirmation = document.getElementById('profile_password_confirmation').value;
            }

            try {
                const response = await fetch('/api/user', {
                    method: 'PUT',
                    headers: window.Auth.getAuthHeaders(),
                    body: JSON.stringify(payload)
                });
                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Update Local Storage
                    window.Auth.setAuth(window.Auth.getToken(), data.data.user);
                    
                    // Show success
                    alertBox.textContent = 'Profile updated successfully!';
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-success');
                    
                    // Optionally clear passwords
                    document.getElementById('profile_password').value = '';
                    document.getElementById('profile_password_confirmation').value = '';
                    
                    // Update DOM generic labels globally if needed
                    document.getElementById('sidebar-user-name').textContent = data.data.user.name;
                    document.getElementById('sidebar-user-initial').textContent = data.data.user.name.charAt(0).toUpperCase();

                } else {
                    alertBox.textContent = data.message || 'Validation failed.';
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-danger');

                    if(data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            let f = document.getElementById(`profile_${key}`);
                            let err = document.getElementById(`${key}Error`);
                            if(f && err) {
                                f.classList.add('is-invalid');
                                err.textContent = data.errors[key][0];
                                err.classList.remove('d-none');
                            }
                        });
                    }
                }
            } catch (err) {
                console.error(err);
                alertBox.textContent = 'An unexpected error occurred.';
                alertBox.classList.remove('d-none');
                alertBox.classList.add('alert-danger');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    });
</script>
@endpush
@endsection
