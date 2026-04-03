@extends('layouts.admin')

@section('title', 'Manage Customers & Users')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Users</h1>
        <p class="page-desc">View registered users, platform roles, and manage accounts.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" style="background:var(--admin-primary); border:none;">
        <i class="fa-solid fa-user-plus me-2"></i> Add User
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        
        {{-- Filters --}}
        <div class="d-flex gap-2">
            <select id="roleFilter" class="form-select form-select-sm" style="width:140px; font-size:.85rem; color:var(--admin-text-sub);">
                <option value="">Role: All</option>
                <option value="customer">Customer</option>
                <option value="vendor">Vendor</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        {{-- Search --}}
        <div class="position-relative" style="width:250px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:.8rem;"></i>
            <input type="text" id="searchInput" class="form-control form-control-sm ps-5" placeholder="Search name or email..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                {{-- Dynamic Content goes here --}}
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

{{-- ADD USER MODAL --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addUserForm">
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label text-muted fs-sm fw-600">Full Name</label>
                  <input type="text" class="form-control" name="name" required placeholder="e.g. John Doe">
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fs-sm fw-600">Email Address</label>
                  <input type="email" class="form-control" name="email" required placeholder="e.g. john@example.com">
              </div>
              <div class="row">
                  <div class="col-6 mb-3">
                      <label class="form-label text-muted fs-sm fw-600">Password</label>
                      <input type="password" class="form-control" name="password" required minlength="8">
                  </div>
                  <div class="col-6 mb-3">
                      <label class="form-label text-muted fs-sm fw-600">Confirm Password</label>
                      <input type="password" class="form-control" name="password_confirmation" required minlength="8">
                  </div>
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fs-sm fw-600">Role</label>
                  <select class="form-select" name="role" required>
                      <option value="customer">Customer</option>
                      <option value="vendor">Vendor</option>
                      <option value="admin">Admin</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveUserBtn">Create User</button>
          </div>
      </form>
    </div>
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
    const tableBody = document.getElementById('usersTableBody');
    const roleFilter = document.getElementById('roleFilter');
    const searchInput = document.getElementById('searchInput');
    let currentPage = 1;

    // Load users
    async function fetchUsers(page = 1) {
        currentPage = page;
        renderSkeleton();
        
        const params = new URLSearchParams({ page });
        if(roleFilter.value) params.append('role', roleFilter.value);
        if(searchInput.value) params.append('search', searchInput.value);

        try {
            const res = await fetch(`/api/admin/users?${params.toString()}`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            const json = await res.json();
            
            if (res.ok) {
                renderUsers(json.data.data);
                renderPagination(json.data);
            } else {
                Swal.fire('Error', json.message || 'Failed to load users', 'error');
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
                    <div><div class="shimmer-box mb-1" style="width:120px;"></div><div class="shimmer-box" style="width:160px;height:14px"></div></div></div></td>
                <td><div class="shimmer-box" style="width:80px;"></div></td>
                <td><div class="shimmer-box" style="width:100px;"></div></td>
                <td><div class="shimmer-box ms-auto" style="width:60px;"></div></td>
            </tr>`;
        }
        tableBody.innerHTML = html;
    }

    function renderUsers(users) {
        if(users.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No users found.</td></tr>`;
            return;
        }

        const colors = ['primary', 'success', 'warning', 'danger', 'info'];
        let html = users.map((user) => {
            const initials = user.name.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();
            const color = colors[user.id % colors.length];
            const date = new Date(user.created_at).toLocaleDateString();
            
            let roleBadge = '';
            if(user.role === 'admin') roleBadge = '<span class="status-pill status-danger">Admin</span>';
            else if(user.role === 'vendor') roleBadge = '<span class="status-pill status-info">Vendor</span>';
            else roleBadge = '<span class="status-pill status-success">Customer</span>';

            return `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-${color} bg-opacity-10 text-${color} rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.9rem;">
                                ${initials}
                            </div>
                            <div>
                                <span class="d-block fw-600 text-dark">${user.name}</span>
                                <span class="d-block text-muted fs-xs"><i class="fa-regular fa-envelope me-1"></i>${user.email}</span>
                            </div>
                        </div>
                    </td>
                    <td>${roleBadge}</td>
                    <td class="text-muted fs-sm">${date}</td>
                    <td class="text-end">
                        <button class="action-btn delete-user-btn" data-id="${user.id}" title="Delete User"><i class="fa-regular fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
        }).join('');

        tableBody.innerHTML = html;

        // Attach delete events
        document.querySelectorAll('.delete-user-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteUser(this.dataset.id);
            });
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
        if(page > 0) fetchUsers(page);
    };

    // Filters & Search
    roleFilter.addEventListener('change', () => fetchUsers(1));
    let timeout = null;
    searchInput.addEventListener('keyup', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => fetchUsers(1), 500);
    });

    // Delete User
    async function deleteUser(id) {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!'
        });

        if (result.isConfirmed) {
            try {
                const res = await fetch(`/api/admin/users/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
                const data = await res.json();
                
                if (res.ok) {
                    Swal.fire('Deleted!', 'User has been deleted.', 'success');
                    fetchUsers(currentPage);
                } else {
                    Swal.fire('Error', data.message || 'Failed to delete user', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Network error occurred', 'error');
            }
        }
    }

    // Add User
    document.getElementById('addUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('saveUserBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const formData = new FormData(this);
        const params = new URLSearchParams();
        for (const pair of formData) { params.append(pair[0], pair[1]); }

        try {
            const res = await fetch('/api/admin/users', {
                method: 'POST',
                headers: { 
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: params.toString()
            });
            const data = await res.json();

            if (res.ok) {
                Swal.fire('Success', 'User created successfully', 'success');
                const modalParams = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                modalParams.hide();
                this.reset();
                fetchUsers(1);
            } else {
                let errorMsg = data.message;
                if (data.errors) {
                    errorMsg += '<br><small>' + Object.values(data.errors).map(e => e.join(', ')).join('<br>') + '</small>';
                }
                Swal.fire({title:'Validation Error', html: errorMsg, icon: 'error'});
            }
        } catch (err) {
            Swal.fire('Error', 'Network error occurred', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Create User';
        }
    });

    // Initial Fetch
    fetchUsers(1);
});
</script>
@endpush
