@extends('user.layout')

@section('user_content')
<div class="dashboard-card">
    <h4 class="dashboard-card-title border-bottom pb-3 mb-4">
        <i class="fa fa-box-open text-brand"></i> My Purchase History
    </h4>

    <div class="table-responsive">
        <table class="table align-middle text-nowrap table-hover" id="ordersTable">
            <thead class="table-light text-muted fs-xs text-uppercase">
                <tr>
                    <th class="fw-bold ps-3">Order ID</th>
                    <th class="fw-bold">Date</th>
                    <th class="fw-bold">Items</th>
                    <th class="fw-bold">Total</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end pe-3">Action</th>
                </tr>
            </thead>
            <tbody id="ordersBody">
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fa fa-spinner fa-spin fs-4 text-brand"></i><br>
                        <span class="fs-sm text-muted mt-2 d-inline-block">Loading your orders...</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        if (!window.Auth || !window.Auth.check()) return;

        const tbody = document.getElementById('ordersBody');

        try {
            const res = await fetch('/api/orders', {
                headers: window.Auth.getAuthHeaders()
            });
            const result = await res.json();

            if (res.ok && result.status === 'success') {
                const orders = result.data;

                if (orders.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open fs-2 mb-2 opacity-50"></i><br>
                        You haven't placed any orders yet. <a href="/shop" class="text-brand text-decoration-underline ms-1">Start shopping</a>
                    </td></tr>`;
                    return;
                }

                tbody.innerHTML = '';
                orders.forEach(order => {
                    // Summary of items
                    let itemsCount = order.items ? order.items.length : 0;
                    let firstItemName = order.items && order.items.length > 0 && order.items[0].product ? order.items[0].product.name : 'Unknown Product';
                    let itemDisplay = itemsCount > 1 
                        ? `${firstItemName} <span class="text-muted fs-xs">(+${itemsCount - 1} more)</span>` 
                        : firstItemName;

                    // Date formatting
                    let orderDate = new Date(order.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year:'numeric' });

                    // Status pill
                    let statusClass = 'bg-secondary';
                    if(order.status === 'completed') statusClass = 'bg-success';
                    if(order.status === 'processing') statusClass = 'bg-info bg-opacity-75';
                    if(order.status === 'cancelled') statusClass = 'bg-danger';
                    if(order.status === 'pending') statusClass = 'bg-warning text-dark';

                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="ps-3"><span class="fw-bold">#ORD-${order.id}</span></td>
                        <td class="fs-sm text-secondary">${orderDate}</td>
                        <td class="fs-sm truncate-250" style="max-width:250px; text-overflow:ellipsis; overflow:hidden;">${itemDisplay}</td>
                        <td class="fw-600">Rs. ${parseFloat(order.total_amount).toLocaleString()}</td>
                        <td><span class="badge ${statusClass} rounded-pill px-3 py-1 fw-normal text-capitalize shadow-sm">${order.status}</span></td>
                        <td class="text-end pe-3">
                            <a href="#" class="btn btn-sm btn-light border fs-xs py-1" onclick="alert('Viewing order details for #ORD-${order.id}')">View</a>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-danger">Failed to load orders.</td></tr>`;
            }

        } catch (err) {
            console.error(err);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-danger">An unexpected error occurred while fetching orders.</td></tr>`;
        }
    });
</script>
<style>
.fw-600 { font-weight: 600; }
.truncate-250 { white-space: nowrap; }
.badge.bg-warning { background-color: #f5b700 !important; }
</style>
@endpush
@endsection
