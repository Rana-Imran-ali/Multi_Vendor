@extends('layouts.app')

@section('title', 'Registered Vendors — Vendo')
@section('meta_description', 'Discover top-rated sellers, official brands, and local stores on Vendo.')

@section('content')

{{-- PAGE HEADER --}}
<div class="bg-light py-4 mb-5 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 fs-sm">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vendors</li>
            </ol>
        </nav>
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <h1 class="fw-900 text-dark mb-1" style="letter-spacing:-1px;">Verified Stores</h1>
                <p class="text-muted mb-0">Discover top-rated sellers and official brands</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-inline-flex position-relative w-100 max-w-sm" style="max-width:300px;">
                    <input type="text" class="form-control rounded-pill ps-4 pr-5 shadow-sm border-0" placeholder="Search stores..." style="height:45px;">
                    <button class="btn bg-transparent position-absolute end-0 top-50 translate-middle-y border-0 text-brand">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-xl mb-5 pb-4">
    
    {{-- Tabs / Filter --}}
    <div class="d-flex flex-wrap gap-2 mb-4 pb-2 border-bottom">
        <button class="btn btn-brand rounded-pill px-4 fw-bold shadow-sm">All Stores</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">Top Rated</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">Official Brands</button>
        <button class="btn btn-outline-secondary rounded-pill px-4 bg-white border-light text-dark fw-500">New Sellers</button>
    </div>

    {{-- Grid --}}
    <div class="row g-4 mb-5">
        
        {{-- Vendor 1 --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="vendor-card bg-white border rounded shadow-sm overflow-hidden position-relative">
                <div class="vendor-banner bg-primary bg-gradient" style="height:100px;"></div>
                <div class="px-4 pb-4 position-relative text-center" style="margin-top:-40px;">
                    
                    <div class="vendor-avatar bg-white shadow-sm border rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:1.5rem;font-weight:bold;color:var(--brand-primary); z-index:2; position:relative;">
                        SZ
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-dark">SoundZone PK <i class="fa-solid fa-circle-check text-primary fs-xs ms-1" title="Verified"></i></h5>
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>4.9</span>
                        <span class="text-muted fs-xs">| 3.2k Reviews | <i class="fa-solid fa-box-open ms-1 me-1"></i>142 Items</span>
                    </div>
                    
                    <p class="text-muted fs-sm mb-4 line-clamp-2">Premium audio gear, headphones, and home theater systems. 100% genuine products with warranty.</p>
                    
                    <a href="{{ url('/vendors/soundzone') }}" class="btn btn-outline-primary fw-bold w-100 rounded-pill">Visit Store <i class="fa fa-arrow-right-long ms-2"></i></a>
                </div>
            </div>
        </div>

        {{-- Vendor 2 --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="vendor-card bg-white border rounded shadow-sm overflow-hidden position-relative">
                <div class="vendor-banner bg-info bg-gradient" style="height:100px;"></div>
                <div class="px-4 pb-4 position-relative text-center" style="margin-top:-40px;">
                    
                    <div class="vendor-avatar bg-white shadow-sm border rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:1.5rem;font-weight:bold;color:#0dcaf0; z-index:2; position:relative;">
                        TM
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-dark">TechMart PK <i class="fa-solid fa-circle-check text-primary fs-xs ms-1" title="Verified"></i></h5>
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>4.7</span>
                        <span class="text-muted fs-xs">| 1.1k Reviews | <i class="fa-solid fa-box-open ms-1 me-1"></i>85 Items</span>
                    </div>
                    
                    <p class="text-muted fs-sm mb-4 line-clamp-2">Your one-stop shop for smartphones, tablets, and mobile accessories. Fast shipping guaranteed.</p>
                    
                    <a href="{{ url('/vendors/techmart') }}" class="btn btn-outline-info fw-bold w-100 rounded-pill">Visit Store <i class="fa fa-arrow-right-long ms-2"></i></a>
                </div>
            </div>
        </div>

        {{-- Vendor 3 --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="vendor-card bg-white border rounded shadow-sm overflow-hidden position-relative">
                <div class="vendor-banner bg-danger bg-gradient" style="height:100px;"></div>
                <div class="px-4 pb-4 position-relative text-center" style="margin-top:-40px;">
                    
                    <div class="vendor-avatar bg-white shadow-sm border rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:1.5rem;font-weight:bold;color:#dc3545; z-index:2; position:relative;">
                        GF
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-dark">Glamour Finds</h5>
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                        <span class="badge bg-light text-muted border"><i class="fa-regular fa-star me-1"></i>New</span>
                        <span class="text-muted fs-xs">| 0 Reviews | <i class="fa-solid fa-box-open ms-1 me-1"></i>12 Items</span>
                    </div>
                    
                    <p class="text-muted fs-sm mb-4 line-clamp-2">Latest trends in women's fashion, clothing, and accessories. Boutique quality at great prices.</p>
                    
                    <a href="{{ url('/vendors/glamour-finds') }}" class="btn btn-outline-danger fw-bold w-100 rounded-pill">Visit Store <i class="fa fa-arrow-right-long ms-2"></i></a>
                </div>
            </div>
        </div>

        {{-- Vendor 4 --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="vendor-card bg-white border rounded shadow-sm overflow-hidden position-relative">
                <div class="vendor-banner bg-success bg-gradient" style="height:100px;"></div>
                <div class="px-4 pb-4 position-relative text-center" style="margin-top:-40px;">
                    
                    <div class="vendor-avatar bg-white shadow-sm border rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;font-size:1.5rem;font-weight:bold;color:#198754; z-index:2; position:relative;">
                        EL
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-dark">EcoLife Living <i class="fa-solid fa-circle-check text-primary fs-xs ms-1" title="Verified"></i></h5>
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>4.9</span>
                        <span class="text-muted fs-xs">| 842 Reviews | <i class="fa-solid fa-box-open ms-1 me-1"></i>65 Items</span>
                    </div>
                    
                    <p class="text-muted fs-sm mb-4 line-clamp-2">Sustainable home goods, organic kitchenware, and eco-friendly lifestyle products to green your home.</p>
                    
                    <a href="{{ url('/vendors/ecolife') }}" class="btn btn-outline-success fw-bold w-100 rounded-pill">Visit Store <i class="fa fa-arrow-right-long ms-2"></i></a>
                </div>
            </div>
        </div>

    </div>

    {{-- Pagination --}}
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
            <li class="page-item active"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">1</a></li>
            <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">2</a></li>
            <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">3</a></li>
            <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
        </ul>
    </nav>
</div>

@endsection

@push('styles')
<style>
.vendor-card { transition: all 0.3s ease; }
.vendor-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
.vendor-avatar { font-family: var(--font-base); letter-spacing: -1px; }

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 42px;
}

.pagination .page-link { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--text-primary); font-weight: 600; margin: 0 4px; }
.pagination .page-item.active .page-link { background-color: var(--brand-primary); color: #fff; }
</style>
@endpush
