@extends('layouts.admin')

@section('title', 'Product Moderation')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Products Sandbox</h1>
        <p class="page-desc">Moderate all products across the platform. Suspend or reject non-compliant items.</p>
    </div>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select id="statusFilter" class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option value="">Status: All</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="suspended">Suspended</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Price & Stock</th>
                    <th>Status</th>
                    <th class="text-end">Moderation</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                {{-- Dynamic Content --}}
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-3 border-top border-light d-flex justify-content-between align-items-center">
        <span class="text-muted" id="paginationInfo" style="font-size:.8rem;">Loading...</span>
        <ul class="pagination pagination-sm mb-0" id="paginationControls">
            {{-- Dynamic Pagination --}}
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

.shimmer-row td { position: relative; overflow: hidden; }
.shimmer-box { 
    height: 20px; background: #e2e8f0; border-radius: 4px;
    position: relative; overflow: hidden;
}
.shimmer-box::after {
    content: ""; position: absolute; top: 0; right: 0; bottom: 0; left: 0;
    transform: translateX(-100%);
    background-image: linear-gradient(90deg, rgba(255,255,255,0) 0, rgba(255,255,255,0.4) 20%, rgba(255,255,255,0.4) 60%, rgba(255,255,255,0));
    animation: shimmer 1.5s infinite;
}
@keyframes shimmer { 100% { transform: translateX(100%); } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('admin_token');
    const tableBody = document.getElementById('productsTableBody');
    const statusFilter = document.getElementById('statusFilter');
    let currentPage = 1;

    async function fetchProducts(page = 1) {
        currentPage = page;
        renderSkeleton();
        
        const params = new URLSearchParams({ page });
        if(statusFilter.value) params.append('status', statusFilter.value);

        try {
            const res = await fetch(`/api/admin/products?${params.toString()}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const json = await res.json();
            
            if (res.ok) {
                renderProducts(json.data.data);
                renderPagination(json.data);
            } else {
                Swal.fire('Error', json.message || 'Failed to load products', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Network error occurred.', 'error');
        }
    }

    function renderSkeleton() {
        let html = '';
        for (let i=0; i<5; i++) {
            html += `<tr class="shimmer-row">
                <td><div class="shimmer-box mb-1" style="width:160px;"></div><div class="shimmer-box" style="width:100px;height:12px"></div></td>
                <td><div class="shimmer-box" style="width:120px;"></div></td>
                <td><div class="shimmer-box" style="width:80px;"></div></td>
                <td><div class="shimmer-box" style="width:90px;"></div></td>
                <td><div class="shimmer-box ms-auto" style="width:100px;"></div></td>
            </tr>`;
        }
        tableBody.innerHTML = html;
    }

    function renderProducts(products) {
        if(products.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">No products found.</td></tr>`;
            return;
        }

        let html = products.map((prod) => {
            const vendorName = prod.vendor ? prod.vendor.name : 'Unknown Vendor';
            const catName = prod.category ? prod.category.name : 'Uncategorized';
            
            let statusBadge = '';
            if(prod.status === 'active') statusBadge = '<span class="status-pill status-success">Active</span>';
            else if(prod.status === 'suspended') statusBadge = '<span class="status-pill status-danger">Suspended</span>';
            else if(prod.status === 'rejected') statusBadge = '<span class="status-pill status-danger">Rejected</span>';
            else statusBadge = '<span class="status-pill status-warning">Pending</span>';

            const toggleBtn = prod.status === 'active' 
                ? `<button class="btn btn-sm btn-outline-danger py-1 px-2 fs-xs status-toggle" data-id="${prod.id}" data-action="suspended">Suspend</button>`
                : `<button class="btn btn-sm btn-outline-success py-1 px-2 fs-xs status-toggle" data-id="${prod.id}" data-action="active">Activate</button>`;

            return `
                <tr>
                    <td>
                        <span class="d-block fw-600 text-dark">${prod.name}</span>
                        <span class="text-muted fs-xs"><i class="fa-solid fa-tag me-1"></i>${catName}</span>
                    </td>
                    <td>
                        <span class="d-block fs-sm text-dark">${vendorName}</span>
                    </td>
                    <td>
                        <span class="d-block fw-600 text-primary">$${parseFloat(prod.price).toFixed(2)}</span>
                        <span class="text-muted fs-xs">${prod.stock} in stock</span>
                    </td>
                    <td>${statusBadge}</td>
                    <td class="text-end text-nowrap">
                        ${toggleBtn}
                        <button class="btn btn-sm btn-light py-1 px-2 fs-xs ms-1 border" title="View"><i class="fa-regular fa-eye"></i></button>
                    </td>
                </tr>
            `;
        }).join('');

        tableBody.innerHTML = html;

        document.querySelectorAll('.status-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                updateStatus(this.dataset.id, this.dataset.action);
            });
        });
    }

    function renderPagination(meta) {
        document.getElementById('paginationInfo').textContent = `Showing ${meta.from || 0} to ${meta.to || 0} of ${meta.total} entries`;
        let html = `<li class="page-item ${meta.prev_page_url ? '' : 'disabled'}"><button class="page-link" onclick="fetchPage(${meta.current_page - 1})">Prev</button></li>`;
        html += `<li class="page-item active"><button class="page-link">${meta.current_page}</button></li>`;
        html += `<li class="page-item ${meta.next_page_url ? '' : 'disabled'}"><button class="page-link" onclick="fetchPage(${meta.current_page + 1})">Next</button></li>`;
        document.getElementById('paginationControls').innerHTML = html;
    }

    window.fetchPage = function(page) {
        if(page > 0) fetchProducts(page);
    };

    statusFilter.addEventListener('change', () => fetchProducts(1));

    window.updateStatus = async function(id, status) {
        const confirmText = status === 'suspended' ? 'suspend this product?' : 'activate this product?';
        const resAlert = await Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${confirmText}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'suspended' ? '#dc2626' : '#16a34a',
            confirmButtonText: 'Yes, do it'
        });

        if(!resAlert.isConfirmed) return;

        try {
            const res = await fetch(`/api/admin/products/${id}/status`, {
                method: 'PUT',
                headers: { 
                    'Authorization': 'Bearer ' + token, 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({ status })
            });

            if (res.ok) {
                Swal.fire({title: 'Updated!', icon: 'success', timer: 1000, showConfirmButton: false});
                fetchProducts(currentPage);
            } else {
                Swal.fire('Error', 'Failed to update status', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Network error', 'error');
        }
    };

    fetchProducts(1);
});
</script>
@endpush
