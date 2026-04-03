@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Categories</h1>
        <p class="page-desc">Manage the platform's product catalog taxonomy and taxonomy icons.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openAddModal()" style="background:var(--admin-primary); border:none;">
        <i class="fa-solid fa-plus me-2"></i> Add Category
    </button>
</div>

{{-- DATA TABLE CARD --}}
<div class="saas-card p-0 overflow-hidden">
    
    {{-- Toolbar --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border-bottom border-light gap-3">
        <div class="position-relative" style="width:250px;">
            <i class="fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:.8rem;"></i>
            <input type="text" id="searchInput" class="form-control form-control-sm ps-5" placeholder="Search categories..." style="font-size:.85rem; border-radius:50px;">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive border-0 mb-0">
        <table class="table saas-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="categoriesTableBody">
                {{-- Dynamic Content goes here --}}
            </tbody>
        </table>
    </div>
</div>

{{-- CATEGORY MODAL --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalTitle">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="categoryForm">
          <input type="hidden" id="categoryId" name="id">
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label text-muted fs-sm fw-600">Category Name</label>
                  <input type="text" class="form-control" id="catName" name="name" required placeholder="e.g. Electronics">
              </div>
              <div class="mb-3">
                  <label class="form-label text-muted fs-sm fw-600">Description</label>
                  <textarea class="form-control" id="catDesc" name="description" rows="3" placeholder="Optional description..."></textarea>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
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
let allCategories = [];
const token = localStorage.getItem('admin_token');
const tableBody = document.getElementById('categoriesTableBody');

document.addEventListener('DOMContentLoaded', () => {
    fetchCategories();

    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const val = e.target.value.toLowerCase();
        const filtered = allCategories.filter(c => c.name.toLowerCase().includes(val));
        renderCategories(filtered);
    });

    document.getElementById('categoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('saveCategoryBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const id = document.getElementById('categoryId').value;
        const name = document.getElementById('catName').value;
        const desc = document.getElementById('catDesc').value;

        const payload = new URLSearchParams();
        payload.append('name', name);
        if(desc) payload.append('description', desc);

        let url = '/api/admin/categories';
        let method = 'POST';
        if(id) {
            url = `/api/admin/categories/${id}`;
            method = 'PUT';
        }

        try {
            const res = await fetch(url, {
                method: method,
                headers: { 
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: payload.toString()
            });
            const data = await res.json();

            if (res.ok) {
                Swal.fire('Success', data.message, 'success');
                bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
                fetchCategories();
            } else {
                Swal.fire('Error', data.message || 'Validation error', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Network error occurred', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Save Category';
        }
    });
});

async function fetchCategories() {
    renderSkeleton();
    try {
        const res = await fetch('/api/categories', {
            headers: { 'Accept': 'application/json' }
        });
        const json = await res.json();
        if(res.ok) {
            allCategories = json.data;
            renderCategories(allCategories);
        }
    } catch (e) {
        Swal.fire('Error', 'Failed to load categories', 'error');
    }
}

function renderSkeleton() {
    let html = '';
    for (let i=0; i<4; i++) {
        html += `<tr class="shimmer-row">
            <td><div class="d-flex gap-2"><div class="shimmer-box" style="width:30px;height:30px;border-radius:4px"></div><div class="shimmer-box mt-1" style="width:120px;"></div></div></td>
            <td><div class="shimmer-box" style="width:80px;"></div></td>
            <td><div class="shimmer-box" style="width:200px;"></div></td>
            <td><div class="shimmer-box ms-auto" style="width:60px;"></div></td>
        </tr>`;
    }
    tableBody.innerHTML = html;
}

function renderCategories(cats) {
    if(cats.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No categories found.</td></tr>`;
        return;
    }

    const colors = ['primary', 'info', 'warning', 'success', 'danger'];
    tableBody.innerHTML = cats.map(cat => {
        const char = cat.name.charAt(0).toUpperCase();
        const color = colors[cat.id % colors.length];
        const desc = cat.description || '<span class="text-muted fst-italic">No description</span>';
        
        return `
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-${color} bg-opacity-10 text-${color} rounded d-flex align-items-center justify-content-center fw-bold" style="width:36px;height:36px;font-size:1.1rem;">
                            ${char}
                        </div>
                        <span class="fw-600 text-dark">${cat.name}</span>
                    </div>
                </td>
                <td class="text-muted fs-sm">${cat.slug}</td>
                <td class="fs-sm text-muted text-truncate" style="max-width:250px;">${desc}</td>
                <td class="text-end">
                    <button class="action-btn" title="Edit" onclick='openEditModal(${JSON.stringify(cat).replace(/'/g, "&apos;")})'><i class="fa-regular fa-pen-to-square"></i></button>
                    <button class="action-btn delete" title="Delete" onclick="deleteCategory(${cat.id})"><i class="fa-regular fa-trash-can"></i></button>
                </td>
            </tr>
        `;
    }).join('');
}

window.openAddModal = function() {
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('modalTitle').textContent = 'Add Category';
};

window.openEditModal = function(cat) {
    document.getElementById('categoryId').value = cat.id;
    document.getElementById('catName').value = cat.name;
    document.getElementById('catDesc').value = cat.description || '';
    document.getElementById('modalTitle').textContent = 'Edit Category';
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
};

window.deleteCategory = async function(id) {
    const res = await Swal.fire({
        title: 'Delete Category?',
        text: "Products inside it might be affected!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Yes, delete'
    });

    if(res.isConfirmed) {
        try {
            const res = await fetch(`/api/admin/categories/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            });
            if(res.ok) {
                Swal.fire('Deleted!', 'Category removed.', 'success');
                fetchCategories();
            }
        } catch(e) {
            Swal.fire('Error', 'Network error', 'error');
        }
    }
};
</script>
@endpush
