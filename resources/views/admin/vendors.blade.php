@extends('layouts.admin')

@section('title', 'Manage Vendors & Applications')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Vendors</h1>
        <p class="page-desc">Manage store owners, review vendor applications, and network status.</p>
    </div>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select id="statusFilter" class="form-select form-select-sm" style="width:160px; font-size:.85rem; color:var(--admin-text-sub);">
                <option value="">Status: All</option>
                <option value="pending">Pending Approval</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Store Information</th>
                    <th>Applicant (User)</th>
                    <th>Application Status</th>
                    <th>Date Applied</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="vendorsTableBody">
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

/* Shimmer Effect */
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
    const tableBody = document.getElementById('vendorsTableBody');
    const statusFilter = document.getElementById('statusFilter');
    let currentPage = 1;

    async function fetchVendors(page = 1) {
        currentPage = page;
        renderSkeleton();
        
        const params = new URLSearchParams({ page });
        if(statusFilter.value) params.append('status', statusFilter.value);

        try {
            const res = await fetch(`/api/admin/vendors?${params.toString()}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const json = await res.json();
            
            if (res.ok) {
                renderVendors(json.data.data);
                renderPagination(json.data);
            } else {
                Swal.fire('Error', json.message || 'Failed to load vendors', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Network error occurred.', 'error');
            console.error(err);
        }
    }

    function renderSkeleton() {
        let html = '';
        for (let i=0; i<5; i++) {
            html += `<tr class="shimmer-row">
                <td><div class="d-flex gap-3"><div class="shimmer-box" style="width:40px;height:40px;border-radius:50%"></div>
                    <div><div class="shimmer-box mb-1" style="width:140px;"></div><div class="shimmer-box" style="width:100px;height:12px"></div></div></div></td>
                <td><div class="shimmer-box mb-1" style="width:120px;"></div><div class="shimmer-box" style="width:160px;height:12px"></div></td>
                <td><div class="shimmer-box" style="width:90px;"></div></td>
                <td><div class="shimmer-box" style="width:80px;"></div></td>
                <td><div class="shimmer-box ms-auto" style="width:80px;"></div></td>
            </tr>`;
        }
        tableBody.innerHTML = html;
    }

    function renderVendors(vendors) {
        if(vendors.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">No vendor applications found.</td></tr>`;
            return;
        }

        const colors = ['primary', 'info', 'warning', 'success', 'secondary'];
        
        let html = vendors.map((vendor) => {
            const initials = vendor.store_name ? vendor.store_name.substring(0,2).toUpperCase() : 'ST';
            const color = colors[vendor.id % colors.length];
            const date = new Date(vendor.created_at).toLocaleDateString();
            
            let statusBadge = '';
            if(vendor.status === 'approved') statusBadge = '<span class="status-pill status-success"><i class="fa-solid fa-circle-check me-1"></i> Approved</span>';
            else if(vendor.status === 'rejected') statusBadge = '<span class="status-pill status-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Rejected</span>';
            else statusBadge = '<span class="status-pill status-warning"><i class="fa-solid fa-clock me-1"></i> Pending</span>';

            let actionButtons = '';
            if (vendor.status === 'pending') {
                actionButtons = `
                    <button class="btn btn-sm btn-success py-1 px-2 fs-xs me-1 approve-btn" data-id="${vendor.id}"><i class="fa-solid fa-check"></i> Approve</button>
                    <button class="btn btn-sm btn-outline-danger py-1 px-2 fs-xs reject-btn" data-id="${vendor.id}"><i class="fa-solid fa-xmark"></i></button>
                `;
            } else {
                actionButtons = `<span class="text-muted fs-xs">No Actions</span>`;
            }

            return `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-${color} text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                ${initials}
                            </div>
                            <div>
                                <span class="d-block fw-600 text-dark">${vendor.store_name}</span>
                                <span class="text-muted fs-xs">${vendor.store_description ? vendor.store_description.substring(0,30)+'...' : 'No description'}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="d-block fw-500 text-dark fs-sm">${vendor.user?.name || 'N/A'}</span>
                        <span class="text-muted fs-xs">${vendor.user?.email || 'N/A'}</span>
                    </td>
                    <td>${statusBadge}</td>
                    <td class="text-muted fs-sm">${date}</td>
                    <td class="text-end">${actionButtons}</td>
                </tr>
            `;
        }).join('');

        tableBody.innerHTML = html;

        // Attach events
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function() { reviewVendor(this.dataset.id, 'approved'); });
        });
        document.querySelectorAll('.reject-btn').forEach(btn => {
            btn.addEventListener('click', function() { reviewVendor(this.dataset.id, 'rejected'); });
        });
    }

    function renderPagination(meta) {
        document.getElementById('paginationInfo').textContent = `Showing ${meta.from || 0} to ${meta.to || 0} of ${meta.total} entries`;
        
        let html = `<li class="page-item ${meta.prev_page_url ? '' : 'disabled'}">
            <button class="page-link" onclick="fetchPage(${meta.current_page - 1})">Prev</button>
        </li>`;
        
        html += `<li class="page-item active"><button class="page-link">${meta.current_page}</button></li>`;
        
        html += `<li class="page-item ${meta.next_page_url ? '' : 'disabled'}">
            <button class="page-link" onclick="fetchPage(${meta.current_page + 1})">Next</button>
        </li>`;
        
        document.getElementById('paginationControls').innerHTML = html;
    }

    window.fetchPage = function(page) {
        if(page > 0) fetchVendors(page);
    };

    statusFilter.addEventListener('change', () => fetchVendors(1));

    async function reviewVendor(id, status) {
        let payload = { status: status };

        if (status === 'rejected') {
            const { value: reason, isDismissed } = await Swal.fire({
                title: 'Reject Application',
                input: 'textarea',
                inputLabel: 'Reason for rejection (required)',
                inputPlaceholder: 'Enter the reason here...',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                inputValidator: (value) => {
                    if (!value) return 'You need to write something!'
                }
            });

            if (isDismissed) return;
            payload.rejection_reason = reason;
        } else {
            const { isConfirmed } = await Swal.fire({
                title: 'Approve Vendor?',
                text: "This will grant the user vendor access.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'Yes, approve'
            });

            if (!isConfirmed) return;
        }

        try {
            const res = await fetch(`/api/admin/vendors/${id}/review`, {
                method: 'PUT',
                headers: { 
                    'Authorization': 'Bearer ' + token, 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json' 
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            
            if (res.ok) {
                Swal.fire({
                    title: status === 'approved' ? 'Approved!' : 'Rejected', 
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                fetchVendors(currentPage);
            } else {
                Swal.fire('Error', data.message || 'Failed to review vendor', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Network error occurred', 'error');
        }
    }

    // Initial Fetch
    fetchVendors(1);
});
</script>
@endpush
