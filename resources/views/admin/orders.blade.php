@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Orders</h1>
        <p class="page-desc">View and process customer orders across all stores.</p>
    </div>
    <button class="btn btn-outline-secondary bg-white shadow-sm">
        <i class="fa-solid fa-file-export me-2"></i> Export CSV
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Tabs / Filters --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom border-light">
        <ul class="nav nav-tabs border-0 px-3 pt-2" style="gap:2rem;">
            <li class="nav-item">
                <a class="nav-link active text-primary fw-bold bg-transparent border-0 border-bottom border-primary border-2 px-0 pb-3" href="#">All Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted fw-500 bg-transparent border-0 px-0 pb-3" href="#">Unfulfilled <span class="badge bg-danger rounded-pill ms-1">12</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted fw-500 bg-transparent border-0 px-0 pb-3" href="#">Paid</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted fw-500 bg-transparent border-0 px-0 pb-3" href="#">Disputed</a>
            </li>
        </ul>

        <div class="pe-3 pb-2 pt-2 pt-md-0 position-relative" style="width:280px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y text-muted" style="margin-left: 1rem; font-size:.8rem;"></i>
            <input type="text" class="form-control form-control-sm ps-5" placeholder="Search order ID, name..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width:40px;"><input class="form-check-input ms-1" type="checkbox"></th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Fulfillment</th>
                    <th>Total</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Row 1 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td><a href="#" class="fw-bold text-primary text-decoration-none">#ORD-9021</a></td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-600 text-dark">Ali Khan</span>
                            <span class="text-muted" style="font-size:.7rem;">ali@example.com</span>
                        </div>
                    </td>
                    <td class="text-muted fs-sm">Today at 10:45 AM</td>
                    <td><span class="status-pill status-warning"><i class="fa-solid fa-circle-notch fa-spin me-1"></i> Pending</span></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Unfulfilled</span></td>
                    <td class="fw-bold">Rs 24,500 <span class="text-muted fw-normal fs-xs d-block">COD</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Print Invoice"><i class="fa-solid fa-print"></i></button>
                    </td>
                </tr>
                {{-- Row 2 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td><a href="#" class="fw-bold text-primary text-decoration-none">#ORD-9020</a></td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-600 text-dark">Sara Raza</span>
                            <span class="text-muted" style="font-size:.7rem;">sara.r@example.com</span>
                        </div>
                    </td>
                    <td class="text-muted fs-sm">Yesterday at 04:30 PM</td>
                    <td><span class="status-pill status-success"><i class="fa-solid fa-check me-1"></i> Paid</span></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">Shipped</span></td>
                    <td class="fw-bold">Rs 45,999 <span class="text-muted fw-normal fs-xs d-block">Visa ⋯ 4242</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Print Invoice"><i class="fa-solid fa-print"></i></button>
                    </td>
                </tr>
                {{-- Row 3 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td><a href="#" class="fw-bold text-primary text-decoration-none">#ORD-9019</a></td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-600 text-dark">Usman Malik</span>
                            <span class="text-muted" style="font-size:.7rem;">usman12@example.com</span>
                        </div>
                    </td>
                    <td class="text-muted fs-sm">Mar 25, 2026</td>
                    <td><span class="status-pill status-success"><i class="fa-solid fa-check me-1"></i> Paid</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Delivered</span></td>
                    <td class="fw-bold">Rs 12,000 <span class="text-muted fw-normal fs-xs d-block">EasyPaisa</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Print Invoice"><i class="fa-solid fa-print"></i></button>
                    </td>
                </tr>
                {{-- Row 4 --}}
                <tr>
                    <td><input class="form-check-input ms-1" type="checkbox"></td>
                    <td><a href="#" class="fw-bold text-primary text-decoration-none">#ORD-9018</a></td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-600 text-dark">Aisha Imran</span>
                            <span class="text-muted" style="font-size:.7rem;">aisha.im@example.com</span>
                        </div>
                    </td>
                    <td class="text-muted fs-sm">Mar 24, 2026</td>
                    <td><span class="status-pill status-danger"><i class="fa-solid fa-xmark me-1"></i> Failed</span></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border">Cancelled</span></td>
                    <td class="fw-bold text-muted text-decoration-line-through">Rs 8,500 <span class="fw-normal fs-xs d-block">Mastercard ⋯ 1122</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn delete" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-3 border-top border-light d-flex justify-content-between align-items-center">
        <span class="text-muted" style="font-size:.8rem;">Showing 1 to 4 of 1,245 entries</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">125</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </div>
</div>

@endsection

@push('styles')
<style>
.fs-sm { font-size: 0.85rem; }
.fs-xs { font-size: 0.75rem; }
.fw-500 { font-weight: 500; }
.fw-600 { font-weight: 600; }
.form-check-input:checked { background-color: var(--admin-primary); border-color: var(--admin-primary); }

.nav-tabs .nav-link { transition: all 0.2s; }
.nav-tabs .nav-link:hover:not(.active) { color: var(--admin-text-main) !important; }
</style>
@endpush
