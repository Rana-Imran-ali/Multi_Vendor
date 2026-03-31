@extends('user.layout')

@section('user_content')
<div class="dashboard-card mb-4 border-top border-3 border-brand">
    <div class="d-flex justify-content-between align-items-center mb-0">
        <div>
            <h4 class="fw-bold mb-1">Hello, <span id="dash-greeting-name">there</span>!</h4>
            <p class="text-secondary mb-0">From your account dashboard you can view your recent orders and manage your profile details.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="dashboard-card hover-lift transition">
            <h5 class="dashboard-card-title"><i class="fa fa-box text-brand fs-4"></i> Recent Orders</h5>
            <p class="text-muted fs-sm">Track your packages, leave reviews, and view your purchase history.</p>
            <a href="{{ route('user.orders') }}" class="btn btn-outline-brand btn-sm mt-2">View Orders</a>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="dashboard-card hover-lift transition">
            <h5 class="dashboard-card-title"><i class="fa fa-user-pen text-brand fs-4"></i> Profile Settings</h5>
            <p class="text-muted fs-sm">Update your personal information, email, and secure your account.</p>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-brand btn-sm mt-2">Edit Profile</a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
    .border-brand { border-color: var(--brand-primary) !important; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Auth && window.Auth.check()) {
            const user = window.Auth.getUser();
            document.getElementById('dash-greeting-name').textContent = user.name.split(' ')[0];
        }
    });
</script>
@endpush
@endsection
