@extends('layouts.app')

@section('title', 'My Wishlist — Vendo')
@section('meta_description', 'View and manage your saved products on Vendo.')

@section('content')

{{-- PAGE HEADER --}}
<div class="bg-light py-4 mb-5 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 fs-sm">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </nav>
        <h1 class="fw-900 text-dark mb-1" style="letter-spacing:-1px;">My Wishlist</h1>
        <p class="text-muted mb-0">Manage the items you've saved for later.</p>
    </div>
</div>

<div class="container-xl mb-5 pb-4">
    
    {{-- WISHLIST TABLE DESKTOP --}}
    <div class="d-none d-lg-block bg-white border rounded shadow-sm overflow-hidden mb-4">
        <table class="table mb-0 align-middle">
            <thead class="bg-light border-bottom">
                <tr>
                    <th class="py-3 px-4 text-uppercase fs-xs fw-bold text-muted border-0" style="letter-spacing:1px; width:45%;">Product Details</th>
                    <th class="py-3 px-4 text-uppercase fs-xs fw-bold text-muted border-0" style="letter-spacing:1px; width:15%;">Price</th>
                    <th class="py-3 px-4 text-uppercase fs-xs fw-bold text-muted border-0" style="letter-spacing:1px; width:15%;">Stock Status</th>
                    <th class="py-3 px-4 text-uppercase fs-xs fw-bold text-muted border-0 text-end" style="letter-spacing:1px; width:25%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- Item 1 --}}
                <tr>
                    <td class="p-4 border-bottom border-light">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded border bg-white d-flex align-items-center justify-content-center p-2" style="width: 80px; height: 80px;">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=200" alt="Product" class="img-fluid" style="max-height:100%;">
                            </div>
                            <div>
                                <a href="{{ url('/products/nike-air-max-270') }}" class="d-block text-dark fw-bold text-decoration-none product-title mb-1 fs-6">Nike Air Max 270 (Red)</a>
                                <span class="badge bg-light text-muted border fw-normal fs-xs">Vendor: TechMart PK</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 border-bottom border-light fw-bold text-dark">
                        Rs 18,500
                    </td>
                    <td class="p-4 border-bottom border-light">
                        <span class="status-pill text-success bg-success bg-opacity-10 border border-success border-opacity-25 px-2 py-1 rounded-pill fw-bold fs-xs d-inline-flex align-items-center gap-1">
                            <i class="fa fa-check"></i> In Stock
                        </span>
                    </td>
                    <td class="p-4 border-bottom border-light text-end">
                        <button class="btn btn-brand btn-sm fw-bold px-3 me-2 text-nowrap rounded-pill">Add to Cart</button>
                        <button class="btn btn-outline-danger btn-sm border-0 bg-danger bg-opacity-10 position-relative rounded-circle" style="width:34px; height:34px;" title="Remove">
                            <i class="fa-solid fa-trash-can position-absolute top-50 start-50 translate-middle"></i>
                        </button>
                    </td>
                </tr>

                {{-- Item 2 --}}
                <tr>
                    <td class="p-4 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded border bg-white d-flex align-items-center justify-content-center p-2" style="width: 80px; height: 80px;">
                                <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&q=80&w=200" alt="Product" class="img-fluid" style="max-height:100%;">
                            </div>
                            <div>
                                <a href="{{ url('/products/macbook-pro') }}" class="d-block text-dark fw-bold text-decoration-none product-title mb-1 fs-6">Apple MacBook Pro 14" M3</a>
                                <span class="badge bg-light text-muted border fw-normal fs-xs">Vendor: SoundZone PK</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 border-0 fw-bold text-dark">
                        Rs 640,000
                    </td>
                    <td class="p-4 border-0">
                        <span class="status-pill text-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 px-2 py-1 rounded-pill fw-bold fs-xs d-inline-flex align-items-center gap-1">
                            <i class="fa fa-xmark"></i> Out of Stock
                        </span>
                    </td>
                    <td class="p-4 border-0 text-end">
                        <button class="btn btn-dark btn-sm fw-bold px-3 me-2 text-nowrap rounded-pill disabled">Add to Cart</button>
                        <button class="btn btn-outline-danger btn-sm border-0 bg-danger bg-opacity-10 position-relative rounded-circle" style="width:34px; height:34px;" title="Remove">
                            <i class="fa-solid fa-trash-can position-absolute top-50 start-50 translate-middle"></i>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- WISHLIST MOBILE (Cards) --}}
    <div class="d-block d-lg-none">
        
        {{-- Mob Item 1 --}}
        <div class="bg-white border rounded shadow-sm p-3 mb-3 d-flex flex-column gap-3">
            <div class="d-flex gap-3">
                <div class="rounded border bg-white d-flex align-items-center justify-content-center p-2" style="width: 80px; height: 80px; flex-shrink:0;">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=200" alt="Product" class="img-fluid" style="max-height:100%;">
                </div>
                <div>
                    <a href="#" class="d-block text-dark fw-bold text-decoration-none product-title mb-1 fs-6 line-clamp-2">Nike Air Max 270 (Red)</a>
                    <div class="fw-bold text-brand mb-1">Rs 18,500</div>
                    <span class="text-success fs-xs fw-bold"><i class="fa fa-check"></i> In Stock</span>
                </div>
            </div>
            <div class="d-flex gap-2 w-100">
                <button class="btn btn-outline-danger w-25 rounded-pill"><i class="fa-solid fa-trash-can"></i></button>
                <button class="btn btn-brand fw-bold w-100 rounded-pill">Add to Cart</button>
            </div>
        </div>

        {{-- Mob Item 2 --}}
        <div class="bg-white border rounded shadow-sm p-3 mb-3 d-flex flex-column gap-3">
            <div class="d-flex gap-3">
                <div class="rounded border bg-white d-flex align-items-center justify-content-center p-2" style="width: 80px; height: 80px; flex-shrink:0;">
                    <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&q=80&w=200" alt="Product" class="img-fluid" style="max-height:100%;">
                </div>
                <div>
                    <a href="#" class="d-block text-dark fw-bold text-decoration-none product-title mb-1 fs-6 line-clamp-2">Apple MacBook Pro 14" M3</a>
                    <div class="fw-bold text-brand mb-1">Rs 640,000</div>
                    <span class="text-danger fs-xs fw-bold"><i class="fa fa-xmark"></i> Out of Stock</span>
                </div>
            </div>
            <div class="d-flex gap-2 w-100">
                <button class="btn btn-outline-danger w-25 rounded-pill"><i class="fa-solid fa-trash-can"></i></button>
                <button class="btn btn-dark fw-bold w-100 rounded-pill disabled">Add to Cart</button>
            </div>
        </div>

    </div>

    {{-- Bottom Nav --}}
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ url('/shop') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-600 border-light bg-white text-dark shadow-sm">
            <i class="fa fa-arrow-left me-2 fs-xs"></i> Continue Shopping
        </a>
        <button class="btn btn-outline-danger rounded-pill px-4 fw-600 bg-white shadow-sm">
            Clear Wishlist
        </button>
    </div>

</div>

@endsection

@push('styles')
<style>
.fs-sm { font-size: 0.85rem; }
.fs-xs { font-size: 0.75rem; }
.fw-600 { font-weight: 600; }
.product-title { transition: color 0.2s; }
.product-title:hover { color: var(--brand-primary) !important; }

.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }

/* Custom danger button hover states */
.btn-outline-danger.border-0:hover { background-color: #dc3545 !important; color: #fff !important; }
</style>
@endpush
