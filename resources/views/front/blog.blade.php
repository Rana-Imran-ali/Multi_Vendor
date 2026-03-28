@extends('layouts.app')

@section('title', 'Our Blog — Vendo')
@section('meta_description', 'Read the latest news, eCommerce tips, and product reviews on the Vendo blog.')

@section('content')

{{-- PAGE HEADER --}}
<div class="bg-light py-4 mb-5 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 fs-sm">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </nav>
        <h1 class="fw-900 text-dark mb-1" style="letter-spacing:-1px;">Latest News & Guides</h1>
        <p class="text-muted mb-0">Discover tips, product reviews, and eCommerce trends.</p>
    </div>
</div>

<div class="container-xl mb-5 pb-4">
    <div class="row g-5">
        
        {{-- MAIN CONTENT (Left Col) --}}
        <div class="col-12 col-lg-8">
            <div class="row g-4">
                
                {{-- Blog Post 1 --}}
                <div class="col-12">
                    <article class="blog-card bg-white border rounded shadow-sm overflow-hidden d-flex flex-column flex-md-row">
                        <div class="blog-img" style="background-image: url('https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&q=80&w=600');"></div>
                        <div class="p-4 d-flex flex-column justify-content-center flex-grow-1">
                            <div class="d-flex align-items-center gap-3 mb-2 fs-xs text-uppercase fw-bold" style="letter-spacing:1px;">
                                <span class="text-brand">Technology</span>
                                <span class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Mar 24, 2026</span>
                            </div>
                            <h3 class="fw-bold mb-3 fs-5 line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">Top 10 Laptops for Creative Professionals in 2026</a></h3>
                            <p class="text-muted fs-sm mb-4 line-clamp-3">
                                Finding the right laptop architecture for video editing, 3D rendering, and graphic design has never been harder given the rapid advancement of ARM chips...
                            </p>
                            <a href="#" class="fw-bold text-brand text-decoration-none fs-sm mt-auto">Read Article <i class="fa fa-arrow-right fs-xs ms-1"></i></a>
                        </div>
                    </article>
                </div>

                {{-- Blog Post 2 --}}
                <div class="col-12">
                    <article class="blog-card bg-white border rounded shadow-sm overflow-hidden d-flex flex-column flex-md-row">
                        <div class="blog-img" style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&q=80&w=600');"></div>
                        <div class="p-4 d-flex flex-column justify-content-center flex-grow-1">
                            <div class="d-flex align-items-center gap-3 mb-2 fs-xs text-uppercase fw-bold" style="letter-spacing:1px;">
                                <span class="text-brand">Style & Fashion</span>
                                <span class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Mar 20, 2026</span>
                            </div>
                            <h3 class="fw-bold mb-3 fs-5 line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">The Ultimate Summer Wardrobe Guide for Men</a></h3>
                            <p class="text-muted fs-sm mb-4 line-clamp-3">
                                Get ready for the heat with our curated selection of breathable fabrics, light colors, and stylish accessories guaranteed to keep you cool and sharp...
                            </p>
                            <a href="#" class="fw-bold text-brand text-decoration-none fs-sm mt-auto">Read Article <i class="fa fa-arrow-right fs-xs ms-1"></i></a>
                        </div>
                    </article>
                </div>

                {{-- Blog Post 3 --}}
                <div class="col-12">
                    <article class="blog-card bg-white border rounded shadow-sm overflow-hidden d-flex flex-column flex-md-row">
                        <div class="blog-img" style="background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=600');"></div>
                        <div class="p-4 d-flex flex-column justify-content-center flex-grow-1">
                            <div class="d-flex align-items-center gap-3 mb-2 fs-xs text-uppercase fw-bold" style="letter-spacing:1px;">
                                <span class="text-brand">E-Commerce</span>
                                <span class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Mar 15, 2026</span>
                            </div>
                            <h3 class="fw-bold mb-3 fs-5 line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">How to Setup Your Very First Vendor Store on Vendo</a></h3>
                            <p class="text-muted fs-sm mb-4 line-clamp-3">
                                A comprehensive step-by-step tutorial on registering as a seller, uploading your first 10 products, and utilizing our marketing tools to land that first sale...
                            </p>
                            <a href="#" class="fw-bold text-brand text-decoration-none fs-sm mt-auto">Read Article <i class="fa fa-arrow-right fs-xs ms-1"></i></a>
                        </div>
                    </article>
                </div>

            </div>

            {{-- Pagination --}}
            <nav aria-label="Blog pagination" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">1</a></li>
                    <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">2</a></li>
                    <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-1" href="#">3</a></li>
                    <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                </ul>
            </nav>

        </div>

        {{-- SIDEBAR (Right Col) --}}
        <div class="col-12 col-lg-4">
            
            {{-- Search Widget --}}
            <div class="bg-white border rounded shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3">Search Blog</h6>
                <div class="position-relative">
                    <input type="text" class="form-control ps-4 pe-5" placeholder="Keywords..." style="border-radius:var(--radius-sm); font-size:.9rem;">
                    <i class="fa fa-search position-absolute text-muted" style="right:1rem; top:50%; transform:translateY(-50%);"></i>
                </div>
            </div>

            {{-- Categories Widget --}}
            <div class="bg-white border rounded shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3">Categories</h6>
                <ul class="list-unstyled mb-0 sidebar-list">
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-brand fs-xs"></i> Technology <span class="badge bg-light text-muted float-end">12</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-brand fs-xs"></i> Style & Fashion <span class="badge bg-light text-muted float-end">8</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-brand fs-xs"></i> E-Commerce Tips <span class="badge bg-light text-muted float-end">24</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-brand fs-xs"></i> Health & Wellness <span class="badge bg-light text-muted float-end">5</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-angle-right me-2 text-brand fs-xs"></i> Home Decor <span class="badge bg-light text-muted float-end">9</span></a></li>
                </ul>
            </div>

            {{-- Recent Posts Widget --}}
            <div class="bg-white border rounded shadow-sm p-4">
                <h6 class="fw-bold mb-4">Recent Posts</h6>
                
                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom border-light">
                    <div class="rounded bg-light" style="width:60px; height:60px; background-image:url('https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=100'); background-size:cover; background-position:center;"></div>
                    <div>
                        <h6 class="mb-1 fs-sm fw-bold line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">5 Best Headphones for Audiophiles</a></h6>
                        <span class="text-muted" style="font-size:.7rem;">Mar 12, 2026</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom border-light">
                    <div class="rounded bg-light" style="width:60px; height:60px; background-image:url('https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&q=80&w=100'); background-size:cover; background-position:center;"></div>
                    <div>
                        <h6 class="mb-1 fs-sm fw-bold line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">Nike vs Adidas: Which running shoe wins?</a></h6>
                        <span class="text-muted" style="font-size:.7rem;">Mar 08, 2026</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="rounded bg-light" style="width:60px; height:60px; background-image:url('https://images.unsplash.com/photo-1434493789847-2f02b0c1685c?auto=format&fit=crop&q=80&w=100'); background-size:cover; background-position:center;"></div>
                    <div>
                        <h6 class="mb-1 fs-sm fw-bold line-clamp-2"><a href="#" class="text-dark text-decoration-none article-title">Why smartwatches are becoming essential</a></h6>
                        <span class="text-muted" style="font-size:.7rem;">Mar 02, 2026</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
.blog-card { transition: box-shadow 0.3s ease; }
.blog-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
.blog-img { width: 100%; height: 250px; background-size: cover; background-position: center; border-right: 1px solid var(--border-light); }
@media (min-width: 768px) {
    .blog-img { width: 35%; height: auo; min-height: 250px; }
}

.article-title { transition: color 0.2s; }
.article-title:hover { color: var(--brand-primary) !important; }

.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }

.sidebar-list li { padding: 0.6rem 0; border-bottom: 1px dashed #e2e8f0; }
.sidebar-list li:last-child { border-bottom: none; pb: 0; }
.sidebar-list a { color: var(--text-primary); text-decoration: none; font-size: 0.9rem; display: block; transition: all 0.2s; font-weight: 500; }
.sidebar-list a:hover { color: var(--brand-primary); transform: translateX(5px); }

.pagination .page-link { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--text-primary); font-weight: 600; margin: 0 4px; }
.pagination .page-item.active .page-link { background-color: var(--brand-primary); color: #fff; }
</style>
@endpush
