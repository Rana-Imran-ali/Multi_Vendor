@extends('layouts.admin')

@section('title', 'Manage Vendors')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Vendors</h1>
        <p class="page-desc">Manage third-party store owners, approvals, and payout details.</p>
    </div>
    <button class="btn btn-primary" style="background:var(--admin-primary); border:none;">
        <i class="fa-solid fa-user-plus me-2"></i> Add Vendor
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>Status: All</option>
                <option>Active</option>
                <option>Pending Approval</option>
                <option>Suspended</option>
            </select>
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>Commission: All</option>
                <option>Standard (10%)</option>
                <option>Premium (8%)</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="position-relative" style="width:250px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:.8rem;"></i>
            <input type="text" class="form-control form-control-sm ps-5" placeholder="Search store name..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Owner</th>
                    <th>Products</th>
                    <th>Total Sales</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Vendor 1 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                SZ
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">SoundZone PK</a>
                                <span class="text-muted fs-xs"><i class="fa-solid fa-star text-warning"></i> 4.9 (3.2k reviews)</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block fw-500 text-dark fs-sm">Moiz Ali</span>
                        <span class="text-muted fs-xs">moiz@soundzone.pk</span>
                    </td>
                    <td class="fw-600">142</td>
                    <td class="fw-600 text-dark">Rs 12.4M</td>
                    <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check me-1"></i> Active</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View Store"><i class="fa-solid fa-store"></i></button>
                        <button class="action-btn" title="Edit Vendor"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>
                </tr>
                {{-- Vendor 2 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                TM
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">TechMart PK</a>
                                <span class="text-muted fs-xs"><i class="fa-solid fa-star text-warning"></i> 4.7 (1.1k reviews)</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block fw-500 text-dark fs-sm">Zain Bukhari</span>
                        <span class="text-muted fs-xs">zain@techmart.pk</span>
                    </td>
                    <td class="fw-600">85</td>
                    <td class="fw-600 text-dark">Rs 8.9M</td>
                    <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check me-1"></i> Active</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View Store"><i class="fa-solid fa-store"></i></button>
                        <button class="action-btn" title="Edit Vendor"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>
                </tr>
                {{-- Vendor 3 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                GF
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Glamour Finds</a>
                                <span class="text-muted fs-xs"><i class="fa-solid fa-star text-warning"></i> No reviews yet</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block fw-500 text-dark fs-sm">Fatima Tariq</span>
                        <span class="text-muted fs-xs">contact@glamourfinds.pk</span>
                    </td>
                    <td class="fw-600 text-muted">0</td>
                    <td class="fw-600 text-muted">Rs 0</td>
                    <td><span class="status-pill status-warning"><i class="fa-solid fa-clock me-1"></i> Pending Approval</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-success py-1 px-2 fs-xs me-1">Approve</button>
                        <button class="action-btn delete" title="Reject"><i class="fa-solid fa-xmark"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-3 border-top border-light d-flex justify-content-between align-items-center">
        <span class="text-muted" style="font-size:.8rem;">Showing 1 to 3 of 84 entries</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
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
</style>
@endpush
