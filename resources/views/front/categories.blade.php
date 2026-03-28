@extends('layouts.app')

@section('title', 'All Categories — Vendo')
@section('meta_description', 'Explore our wide range of categories and find exactly what you need at the best prices.')

@section('content')

{{-- PAGE HEADER --}}
<div class="bg-light py-4 mb-5 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 fs-sm">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>
        <h1 class="fw-900 text-dark mb-1" style="letter-spacing:-1px;">All Categories</h1>
        <p class="text-muted mb-0">Discover top categories and start shopping</p>
    </div>
</div>

<div class="container-xl mb-5 pb-4">
    <div class="row g-4">
        
        {{-- Electronics --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-laptop"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=electronics') }}" class="text-dark text-decoration-none cat-title">Electronics</a></h4>
                        <span class="text-muted fs-sm">4,200+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-primary fs-xs"></i> Laptops & Computers</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-primary fs-xs"></i> Smartphones & Tablets</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-primary fs-xs"></i> Cameras & Photography</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-primary fs-xs"></i> TV & Home Theater</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-primary fs-xs"></i> Audio & Headphones</a></li>
                </ul>
                <a href="{{ url('/shop?category=electronics') }}" class="btn btn-outline-primary btn-sm mt-4 w-100 fw-bold">View All Electronics</a>
            </div>
        </div>

        {{-- Fashion --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=fashion') }}" class="text-dark text-decoration-none cat-title">Fashion</a></h4>
                        <span class="text-muted fs-sm">12,500+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-danger fs-xs"></i> Men's Clothing</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-danger fs-xs"></i> Women's Clothing</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-danger fs-xs"></i> Kids & Babies</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-danger fs-xs"></i> Shoes & Footwear</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-danger fs-xs"></i> Watches & Accessories</a></li>
                </ul>
                <a href="{{ url('/shop?category=fashion') }}" class="btn btn-outline-danger btn-sm mt-4 w-100 fw-bold">View All Fashion</a>
            </div>
        </div>

        {{-- Home & Lifestyle --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-couch"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=home') }}" class="text-dark text-decoration-none cat-title">Home & Lifestyle</a></h4>
                        <span class="text-muted fs-sm">8,100+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-success fs-xs"></i> Furniture & Decor</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-success fs-xs"></i> Kitchen & Dining</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-success fs-xs"></i> Bedding & Bath</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-success fs-xs"></i> Tools & Home Improvement</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-success fs-xs"></i> Pet Supplies</a></li>
                </ul>
                <a href="{{ url('/shop?category=home') }}" class="btn btn-outline-success btn-sm mt-4 w-100 fw-bold">View All Home</a>
            </div>
        </div>

        {{-- Health & Beauty --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-pump-soap"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=beauty') }}" class="text-dark text-decoration-none cat-title">Health & Beauty</a></h4>
                        <span class="text-muted fs-sm">5,300+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-info fs-xs"></i> Skincare & Makeup</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-info fs-xs"></i> Hair Care</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-info fs-xs"></i> Fragrances</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-info fs-xs"></i> Vitamins & Supplements</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-info fs-xs"></i> Medical Supplies</a></li>
                </ul>
                <a href="{{ url('/shop?category=beauty') }}" class="btn btn-outline-info btn-sm mt-4 w-100 fw-bold">View All Health & Beauty</a>
            </div>
        </div>

        {{-- Sports & Outdoors --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-table-tennis-paddle-ball"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=sports') }}" class="text-dark text-decoration-none cat-title">Sports & Outdoors</a></h4>
                        <span class="text-muted fs-sm">3,800+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-warning fs-xs"></i> Fitness Equipment</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-warning fs-xs"></i> Camping & Hiking</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-warning fs-xs"></i> Cycling</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-warning fs-xs"></i> Team Sports</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-warning fs-xs"></i> Water Sports</a></li>
                </ul>
                <a href="{{ url('/shop?category=sports') }}" class="btn btn-outline-warning btn-sm mt-4 w-100 fw-bold text-dark">View All Sports</a>
            </div>
        </div>

        {{-- Automotive --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="category-card shadow-sm h-100 bg-white border rounded p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="cat-icon bg-dark bg-opacity-10 text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px;height:60px;font-size:1.5rem;">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1"><a href="{{ url('/shop?category=auto') }}" class="text-dark text-decoration-none cat-title">Automotive</a></h4>
                        <span class="text-muted fs-sm">2,100+ Products</span>
                    </div>
                </div>
                
                <h6 class="fw-bold fs-sm text-uppercase text-muted mb-3" style="letter-spacing:1px;">Sub-Modules</h6>
                <ul class="list-unstyled sub-cat-list mb-0">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-dark fs-xs"></i> Car Accessories</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-dark fs-xs"></i> Auto Parts</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-dark fs-xs"></i> Motorcycle Parts</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-dark fs-xs"></i> Car Care & Cleaning</a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-dark fs-xs"></i> Tool Kits</a></li>
                </ul>
                <a href="{{ url('/shop?category=auto') }}" class="btn btn-outline-dark btn-sm mt-4 w-100 fw-bold">View All Automotive</a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
.category-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
.cat-title:hover { color: var(--brand-primary) !important; }

.sub-cat-list li { padding: 0.5rem 0; border-bottom: 1px dashed #e2e8f0; }
.sub-cat-list li:last-child { border-bottom: none; }
.sub-cat-list a { color: var(--text-primary); text-decoration: none; font-size: 0.95rem; display: block; transition: all 0.2s; }
.sub-cat-list a:hover { color: var(--brand-primary); transform: translateX(5px); }
</style>
@endpush
