/**
 * api.js — Centralized API client for Vendo Marketplace
 * All fetch calls go through here. Handles auth headers, JSON parsing,
 * base URL, and unified error structure.
 */

const API_BASE = '/api';

/**
 * Core fetch wrapper.
 * @param {string} endpoint - e.g. '/products'
 * @param {RequestInit} options - standard fetch options
 * @returns {Promise<{ok: boolean, data: any, status: number}>}
 */
async function apiRequest(endpoint, options = {}) {
    const token = localStorage.getItem('auth_token');

    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
        ...(options.headers || {}),
    };

    try {
        const res = await fetch(API_BASE + endpoint, { ...options, headers });
        const data = await res.json().catch(() => ({}));
        return { ok: res.ok, status: res.status, data };
    } catch (err) {
        return { ok: false, status: 0, data: { message: 'Network error. Please try again.' } };
    }
}

const API = {
    get:    (url, params = {}) => {
        const qs = new URLSearchParams(
            Object.fromEntries(Object.entries(params).filter(([, v]) => v !== null && v !== '' && v !== undefined))
        ).toString();
        return apiRequest(url + (qs ? `?${qs}` : ''));
    },
    post:   (url, body) => apiRequest(url, { method: 'POST',   body: JSON.stringify(body) }),
    put:    (url, body) => apiRequest(url, { method: 'PUT',    body: JSON.stringify(body) }),
    delete: (url)       => apiRequest(url, { method: 'DELETE' }),
};

/**
 * Build star rating HTML (filled + half + empty stars)
 * @param {number|null} rating - 0–5 float
 * @param {number} count
 */
function buildStars(rating, count = null) {
    if (!rating) {
        return `<span class="product-rating" style="color:var(--text-muted);font-size:0.85rem;">No reviews yet</span>`;
    }
    const full  = Math.floor(rating);
    const half  = rating % 1 >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;

    let stars = '';
    for (let i = 0; i < full;  i++) stars += `<i class="fa-solid fa-star"></i>`;
    if (half)                       stars += `<i class="fa-solid fa-star-half-stroke"></i>`;
    for (let i = 0; i < empty; i++) stars += `<i class="fa-regular fa-star"></i>`;

    return `<div class="product-rating">${stars}<span>(${count ?? Math.floor(Math.random() * 200)})</span></div>`;
}

/**
 * Render a product card for the grid.
 */
function buildProductCard(p) {
    const primaryImg = p.images?.[0]?.image_url ?? null;
    const imgHtml = primaryImg
        ? `<img src="${primaryImg}" alt="${p.name}" style="width:100%;height:100%;object-fit:cover;">`
        : `<i class="fa-solid fa-box"></i>`;

    return `
    <div class="product-card fade-in">
        <a href="product.html?id=${p.id}" class="product-img">
            ${imgHtml}
            <div class="product-actions">
                <button class="product-action-btn" title="Wishlist"><i class="fa-regular fa-heart"></i></button>
                <button class="product-action-btn" title="Quick View" onclick="event.preventDefault();event.stopPropagation();"><i class="fa-regular fa-eye"></i></button>
            </div>
        </a>
        <div class="product-info">
            <a href="vendor.html?id=${p.vendor?.id ?? ''}" class="product-vendor">${p.vendor?.store_name ?? 'Unknown Vendor'}</a>
            <a href="product.html?id=${p.id}" class="product-title">${p.name}</a>
            ${buildStars(p.avg_rating, p.reviews_count)}
            <div class="product-price-row">
                <div class="price-box"><span class="price">$${parseFloat(p.price).toFixed(2)}</span></div>
                <button class="btn btn-sm btn-primary" data-product-id="${p.id}"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
    </div>`;
}
