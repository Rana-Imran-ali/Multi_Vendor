@extends('user.layout')

@section('user_content')
<div class="dashboard-card">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h4 class="dashboard-card-title mb-0">
            <i class="fa-regular fa-heart text-brand"></i> My Wishlist
        </h4>
        <button class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1">Clear</button>
    </div>

    {{-- WISHLIST TABLE DESKTOP --}}
    <div class="table-responsive d-none d-lg-block">
        <table class="table align-middle text-nowrap table-hover" id="wishlistTable">
            <thead class="table-light text-muted fs-xs text-uppercase">
                <tr>
                    <th class="fw-bold ps-3">Product Details</th>
                    <th class="fw-bold">Price</th>
                    <th class="fw-bold">Stock Status</th>
                    <th class="fw-bold text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                
                {{-- Item 1 --}}
                <tr>
                    <td class="ps-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded border bg-white d-flex align-items-center justify-content-center p-1" style="width: 50px; height: 50px;">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=100" alt="Product" class="img-fluid rounded" style="max-height:100%;">
                            </div>
                            <div>
                                <a href="{{ url('/products/nike-air-max-270') }}" class="d-block text-dark fw-bold text-decoration-none product-title mb-0 fs-sm">Nike Air Max 270 (Red)</a>
                                <span class="text-muted fs-xs">Vendor: TechMart PK</span>
                            </div>
                        </div>
                    </td>
                    <td class="fs-sm fw-600">Rs 18,500</td>
                    <td>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill fw-normal px-2">In Stock</span>
                    </td>
                    <td class="text-end pe-3">
                        <button class="btn btn-brand btn-sm fs-xs fw-bold px-3 me-2 rounded-pill">Add to Cart</button>
                        <button class="btn btn-light btn-sm rounded-circle border text-danger" style="width:30px; height:30px;" title="Remove">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>

                {{-- Item 2 --}}
                <tr>
                    <td class="ps-3 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded border bg-white d-flex align-items-center justify-content-center p-1" style="width: 50px; height: 50px;">
                                <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&q=80&w=100" alt="Product" class="img-fluid rounded" style="max-height:100%;">
                            </div>
                            <div>
                                <a href="{{ url('/products/macbook-pro') }}" class="d-block text-dark fw-bold text-decoration-none product-title mb-0 fs-sm">Apple MacBook Pro 14" M3</a>
                                <span class="text-muted fs-xs">Vendor: SoundZone PK</span>
                            </div>
                        </div>
                    </td>
                    <td class="fs-sm fw-600">Rs 640,000</td>
                    <td>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill fw-normal px-2">Out of Stock</span>
                    </td>
                    <td class="text-end pe-3">
                        <button class="btn btn-secondary btn-sm fs-xs fw-bold px-3 me-2 rounded-pill disabled" disabled>Add to Cart</button>
                        <button class="btn btn-light btn-sm rounded-circle border text-danger" style="width:30px; height:30px;" title="Remove">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- WISHLIST MOBILE (Cards) --}}
    <div class="d-block d-lg-none mt-3">
        <div class="border rounded shadow-sm p-3 mb-3">
            <div class="d-flex gap-3 mb-3">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=100" class="rounded border" style="width:60px; height:60px; object-fit:cover;">
                <div>
                    <div class="fw-bold fs-sm line-clamp-2">Nike Air Max 270 (Red)</div>
                    <div class="text-brand fw-bold fs-xs mt-1">Rs 18,500</div>
                    <div class="text-success fs-xs fw-bold mt-1">In Stock</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light border text-danger rounded-pill px-3"><i class="fa fa-trash-can"></i></button>
                <button class="btn btn-brand btn-sm w-100 rounded-pill fw-bold">Add to Cart</button>
            </div>
        </div>
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
