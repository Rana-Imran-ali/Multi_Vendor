/**
 * product.js — Dynamic product detail page.
 * Reads ?id=XYZ from URL, fetches from API, renders everything.
 * Depends on: api.js
 */

document.addEventListener('DOMContentLoaded', async () => {

    const params    = new URLSearchParams(window.location.search);
    const productId = params.get('id');

    if (!productId) {
        showFatalError('No product ID specified.');
        return;
    }

    // ── Fetch Product ─────────────────────────────────────────────────────────
    const { ok, data } = await API.get(`/products/${productId}`);

    if (!ok || !data.data) {
        showFatalError(data.message ?? 'Product not found.');
        return;
    }

    const p = data.data;

    // ── Page Title & Meta ─────────────────────────────────────────────────────
    document.title = `${p.name} | Vendo`;

    // ── Breadcrumb ────────────────────────────────────────────────────────────
    const breadcrumb = document.getElementById('productBreadcrumb');
    if (breadcrumb) {
        breadcrumb.innerHTML = `
            <a href="index.html">Home</a> <span>/</span>
            <a href="shop.html">Shop</a> <span>/</span>
            ${p.category ? `<a href="shop.html?category_id=${p.category.id}">${p.category.name}</a> <span>/</span>` : ''}
            <span style="color:var(--text);">${p.name}</span>`;
    }

    // ── Gallery ───────────────────────────────────────────────────────────────
    const mainImg  = document.getElementById('mainProductImg');
    const thumbList = document.getElementById('thumbList');

    const images = p.images?.length ? p.images : [];

    if (mainImg) {
        if (images.length) {
            mainImg.innerHTML = `<img src="${images[0].image_url}" alt="${p.name}" id="mainImgTag" style="width:100%;height:100%;object-fit:cover;">`;
        } else {
            mainImg.innerHTML = `<i class="fa-solid fa-box" style="font-size:6rem;color:var(--border);"></i>`;
        }
    }

    if (thumbList && images.length > 1) {
        thumbList.innerHTML = images.map((img, i) => `
            <div class="thumb ${i === 0 ? 'active' : ''}" data-img="${img.image_url}" onclick="swapMainImg(this)">
                <img src="${img.image_url}" alt="Thumbnail" style="width:100%;height:100%;object-fit:cover;border-radius:0.75rem;">
            </div>`).join('');
    }

    // ── Vendor & Title ────────────────────────────────────────────────────────
    const vendorLink = document.getElementById('productVendorLink');
    const titleEl    = document.getElementById('productTitle');
    if (vendorLink) {
        vendorLink.href        = `vendor.html?id=${p.vendor?.id ?? ''}`;
        vendorLink.textContent = p.vendor?.store_name ?? 'Unknown Vendor';
    }
    if (titleEl) titleEl.textContent = p.name;

    // ── Rating ────────────────────────────────────────────────────────────────
    const ratingEl = document.getElementById('productRating');
    if (ratingEl) {
        const avg   = p.avg_rating ?? null;
        const count = p.reviews_count ?? 0;
        ratingEl.innerHTML = avg
            ? `${buildStars(avg, count).replace('class="product-rating"', 'class="p-rating-stars"')}
               <span>${avg} (${count} review${count !== 1 ? 's' : ''}) &nbsp;|&nbsp;
               <span style="color:${p.status === 'active' ? 'var(--secondary)' : '#ef4444'};font-weight:600;">
                   <i class="fa-solid fa-circle-${p.status === 'active' ? 'check' : 'xmark'}"></i>
                   ${p.status === 'active' ? 'In Stock' : 'Out of Stock'}
               </span></span>`
            : `<span style="color:var(--text-muted);">No reviews yet &nbsp;|&nbsp;
               <span style="color:${p.status === 'active' ? 'var(--secondary)' : '#ef4444'};font-weight:600;">
                   ${p.status === 'active' ? 'In Stock' : 'Out of Stock'}
               </span></span>`;
    }

    // ── Price ─────────────────────────────────────────────────────────────────
    const priceEl = document.getElementById('productPrice');
    if (priceEl) priceEl.textContent = `$${parseFloat(p.price).toFixed(2)}`;

    // ── Description ───────────────────────────────────────────────────────────
    const descEl = document.getElementById('productDescription');
    if (descEl) descEl.textContent = p.description ?? '';

    // ── Variants ──────────────────────────────────────────────────────────────
    const variantSection = document.getElementById('productVariants');
    if (variantSection && p.variants?.length) {
        const colors = [...new Set(p.variants.filter(v => v.color).map(v => v.color))];
        const sizes  = [...new Set(p.variants.filter(v => v.size).map(v => v.size))];

        let varHtml = '';
        if (colors.length) {
            varHtml += `
            <div class="variant-group">
                <span class="variant-label">Color</span>
                <div class="color-options">
                    ${colors.map((c, i) => `<div class="color-btn ${i===0?'active':''}" style="background:${c};" title="${c}" onclick="selectVariant(this,'color')"></div>`).join('')}
                </div>
            </div>`;
        }
        if (sizes.length) {
            varHtml += `
            <div class="variant-group">
                <span class="variant-label">Size</span>
                <div class="size-options">
                    ${sizes.map((s, i) => `<button class="size-btn ${i===0?'active':''}" onclick="selectVariant(this,'size')">${s}</button>`).join('')}
                </div>
            </div>`;
        }
        variantSection.innerHTML = varHtml;
    } else if (variantSection) {
        variantSection.style.display = 'none';
    }

    // ── Reviews Tab ───────────────────────────────────────────────────────────
    await loadReviews(productId, p.avg_rating, p.reviews_count);

    // ── Vendor Tab ────────────────────────────────────────────────────────────
    const vendorTabEl = document.getElementById('vendorTabContent');
    if (vendorTabEl && p.vendor) {
        vendorTabEl.innerHTML = `
            <div style="display:flex;align-items:center;gap:1.5rem;">
                <div style="width:80px;height:80px;border-radius:50%;background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:2rem;">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h3>${p.vendor.store_name} <span style="background:var(--secondary);color:white;font-size:0.7rem;padding:0.2rem 0.6rem;border-radius:1rem;vertical-align:middle;margin-left:0.5rem;">Verified</span></h3>
                    <p style="color:var(--text-muted);">${p.vendor.description ?? 'This vendor has not added a description.'}</p>
                    <a href="vendor.html?id=${p.vendor.id}" class="btn btn-sm btn-outline" style="margin-top:0.75rem;">Visit Store</a>
                </div>
            </div>`;
    }

    // ── Add to Cart CTA ───────────────────────────────────────────────────────
    const addCartBtn = document.getElementById('addToCartBtn');
    if (addCartBtn) {
        addCartBtn.addEventListener('click', async () => {
            const qty = parseInt(document.getElementById('qty')?.value ?? 1);
            addCartBtn.disabled = true;
            addCartBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Adding...`;

            const { ok, data } = await API.post('/cart', { product_id: p.id, quantity: qty });

            if (ok) {
                addCartBtn.innerHTML = `<i class="fa-solid fa-check"></i> Added!`;
                addCartBtn.style.background = 'var(--secondary)';
                setTimeout(() => {
                    addCartBtn.disabled = false;
                    addCartBtn.innerHTML = `<i class="fa-solid fa-cart-shopping"></i> Add to Cart`;
                    addCartBtn.style.background = '';
                }, 2000);
            } else {
                addCartBtn.disabled = false;
                addCartBtn.innerHTML = `<i class="fa-solid fa-cart-shopping"></i> Add to Cart`;
                if (data.message?.toLowerCase().includes('unauthenticated')) {
                    window.location.href = 'auth.html';
                }
            }
        });
    }
});

// ── Load & Render Reviews ─────────────────────────────────────────────────────
async function loadReviews(productId, avgRating, reviewCount) {
    const reviewsEl = document.getElementById('reviews');
    if (!reviewsEl) return;

    const { ok, data } = await API.get(`/products/${productId}/reviews`);

    const reviewsData = ok ? (data.data ?? []) : [];

    const reviewsTabBtn = document.querySelector('[onclick="openTab(\'reviews\')"]');
    if (reviewsTabBtn) reviewsTabBtn.textContent = `Reviews (${reviewCount ?? reviewsData.length})`;

    let html = `
    <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border);padding-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <div>
            <h3 style="font-size:2rem;font-weight:800;color:var(--text);margin-bottom:0.25rem;">
                ${avgRating ? avgRating.toFixed(1) : '—'} <span style="font-size:1rem;color:var(--text-muted);font-weight:400;">out of 5</span>
            </h3>
            <div style="color:var(--accent);">${avgRating ? buildStars(avgRating).replace(/<[^>]*class="product-rating"[^>]*>|<\/div>/g,'') : 'No ratings yet'}</div>
        </div>
        <button class="btn btn-outline" id="writeReviewBtn">Write a Review</button>
    </div>
    <div class="review-list" id="reviewListContainer">`;

    if (reviewsData.length === 0) {
        html += `<p style="color:var(--text-muted);padding:2rem 0;text-align:center;">Be the first to review this product!</p>`;
    } else {
        reviewsData.forEach(r => {
            const date = new Date(r.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            html += `
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer">
                        <div class="reviewer-avatar"><i class="fa-solid fa-user"></i></div>
                        <div>
                            <h5 style="color:var(--text);">${r.user?.name ?? 'Anonymous'}</h5>
                            <span style="font-size:0.8rem;color:var(--text-muted);">${date}</span>
                        </div>
                    </div>
                    <div style="color:var(--accent);">${buildStars(r.rating).replace('class="product-rating"','style="display:flex;gap:0.2rem;"')}</div>
                </div>
                <p>${r.comment ?? ''}</p>
            </div>`;
        });
    }

    html += `</div>`;
    reviewsEl.innerHTML = html;
}

// ── Utilities exposed to inline HTML ─────────────────────────────────────────
function swapMainImg(thumb) {
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    const mainTag = document.getElementById('mainImgTag');
    if (mainTag) mainTag.src = thumb.dataset.img;
}

function selectVariant(el, type) {
    el.parentElement.querySelectorAll(type === 'color' ? '.color-btn' : '.size-btn')
      .forEach(b => b.classList.remove('active'));
    el.classList.add('active');
}

function showFatalError(msg) {
    document.querySelector('.product-layout')?.replaceWith((() => {
        const d = document.createElement('div');
        d.style.cssText = 'text-align:center;padding:6rem 1rem;color:var(--text-muted);';
        d.innerHTML = `<i class="fa-solid fa-triangle-exclamation fa-3x" style="color:#ef4444;margin-bottom:1.5rem;display:block;"></i>
                       <h2>${msg}</h2><a href="shop.html" class="btn btn-primary" style="margin-top:2rem;">Back to Shop</a>`;
        return d;
    })());
}
