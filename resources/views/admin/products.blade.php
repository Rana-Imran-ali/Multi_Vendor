@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Products</h1>
        <p class="page-desc">Manage your store's inventory and product listings.</p>
    </div>
    <button class="btn btn-primary" style="background:var(--admin-primary); border:none;">
        <i class="fa-solid fa-plus me-2"></i> Add Product
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>All Categories</option>
                <option>Electronics</option>
                <option>Clothing</option>
            </select>
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>All Status</option>
                <option>Active</option>
                <option>Draft</option>
                <option>Out of Stock</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="position-relative" style="width:250px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:.8rem;"></i>
            <input type="text" class="form-control form-control-sm ps-5" placeholder="Search products..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width:40px;">
                        <input class="form-check-input ms-1" type="checkbox">
                    </th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Item 1 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-primary" style="width:40px;height:40px;font-size:1.2rem;">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Sony WH-1000XM5</a>
                                <span class="text-muted fs-xs">SKU: SNY-1005</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Electronics</span></td>
                    <td class="fw-600">Rs 42,999</td>
                    <td>14 <span class="text-success fs-xs ms-1"><i class="fa-solid fa-arrow-trend-up"></i></span></td>
                    <td><span class="status-pill status-success">Active</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="Edit"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button class="action-btn delete" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
                {{-- Item 2 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-info" style="width:40px;height:40px;font-size:1.2rem;">
                                <i class="fa fa-shoe-prints"></i>
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Nike Air Max 270</a>
                                <span class="text-muted fs-xs">SKU: NKE-AM270</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Footwear</span></td>
                    <td class="fw-600">Rs 18,500</td>
                    <td>0 <span class="text-danger fs-xs ms-1"><i class="fa-solid fa-arrow-trend-down"></i></span></td>
                    <td><span class="status-pill status-danger">Out of Stock</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="Edit"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button class="action-btn delete" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
                {{-- Item 3 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-warning" style="width:40px;height:40px;font-size:1.2rem;">
                                <i class="fa fa-stopwatch"></i>
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Apple Watch Series 8</a>
                                <span class="text-muted fs-xs">SKU: APL-W8</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Wearables</span></td>
                    <td class="fw-600">Rs 85,000</td>
                    <td>- <span class="text-muted fs-xs ms-1">N/A</span></td>
                    <td><span class="status-pill status-warning">Draft</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="Edit"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button class="action-btn delete" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-3 border-top border-light d-flex justify-content-between align-items-center">
        <span class="text-muted" style="font-size:.8rem;">Showing 1 to 3 of 142 entries</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>

@endsection

@push('styles')
<style>
.fs-xs { font-size: 0.75rem; }
.fw-600 { font-weight: 600; }
.form-check-input:checked { background-color: var(--admin-primary); border-color: var(--admin-primary); }
</style>
@endpush
