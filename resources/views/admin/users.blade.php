@extends('layouts.admin')

@section('title', 'Manage Customers')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Customers</h1>
        <p class="page-desc">View registered users, purchase history, and account statuses.</p>
    </div>
    <button class="btn btn-primary" style="background:var(--admin-primary); border:none;">
        <i class="fa-solid fa-user-plus me-2"></i> Add Customer
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>Role: All</option>
                <option>Customer</option>
                <option>Admin</option>
            </select>
            <select class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option>Status: All</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="position-relative" style="width:250px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:.8rem;"></i>
            <input type="text" class="form-control form-control-sm ps-5" placeholder="Search name, email, phone..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Contact Info</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- User 1 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                AK
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Ali Khan</a>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border mt-1" style="font-size:.65rem;">Customer</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block text-dark fs-sm"><i class="fa-regular fa-envelope me-2 text-muted"></i>ali.khan@example.com</span>
                        <span class="text-muted fs-xs"><i class="fa-solid fa-phone me-2"></i>0300 1234567</span>
                    </td>
                    <td class="fw-600 text-dark">12</td>
                    <td class="fw-600 text-primary">Rs 145,000</td>
                    <td><span class="status-pill status-success">Active</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View Profile"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Edit User"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>
                </tr>
                {{-- User 2 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                SR
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Sara Raza</a>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border mt-1" style="font-size:.65rem;">Customer</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block text-dark fs-sm"><i class="fa-regular fa-envelope me-2 text-muted"></i>sara.raza@example.com</span>
                        <span class="text-muted fs-xs"><i class="fa-solid fa-phone me-2"></i>0321 9876543</span>
                    </td>
                    <td class="fw-600 text-dark">4</td>
                    <td class="fw-600 text-primary">Rs 32,500</td>
                    <td><span class="status-pill status-success">Active</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View Profile"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Edit User"><i class="fa-regular fa-pen-to-square"></i></button>
                    </td>
                </tr>
                {{-- User 3 --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                ZH
                            </div>
                            <div>
                                <a href="#" class="d-block fw-600 text-dark text-decoration-none">Zahid Hussain</a>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border mt-1" style="font-size:.65rem;">Customer</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block text-dark fs-sm"><i class="fa-regular fa-envelope me-2 text-muted"></i>zahid.h@example.com</span>
                        <span class="text-muted fs-xs"><i class="fa-solid fa-phone me-2"></i>0333 4567890</span>
                    </td>
                    <td class="fw-600 text-muted">0</td>
                    <td class="fw-600 text-muted">Rs 0</td>
                    <td><span class="status-pill status-danger">Inactive</span></td>
                    <td class="text-end">
                        <button class="action-btn" title="View Profile"><i class="fa-regular fa-eye"></i></button>
                        <button class="action-btn" title="Edit User"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button class="action-btn delete" title="Delete User"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-3 border-top border-light d-flex justify-content-between align-items-center">
        <span class="text-muted" style="font-size:.8rem;">Showing 1 to 3 of 12.5k entries</span>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
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
