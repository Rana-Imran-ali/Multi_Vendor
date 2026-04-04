/**
 * shop.js — Shop catalog with live search, filters, sorting, infinite scroll.
 * Depends on: api.js (must be loaded before this script).
 */

document.addEventListener('DOMContentLoaded', () => {

    // ── State ─────────────────────────────────────────────────────────────────
    let state = {
        search:     '',
        category_id: null,
        min_price:  null,
        max_price:  null,
        min_rating: null,
        sort:       'latest',
        cursor:     null,
        loading:    false,
        hasMore:    true,
    };

    // ── DOM Refs ──────────────────────────────────────────────────────────────
    const grid          = document.getElementById('productGrid');
    const toolbar       = document.querySelector('.shop-toolbar p');
    const sortSelect    = document.getElementById('sortSelect');
    const searchInput   = document.getElementById('shopSearchInput');
    const applyBtn      = document.getElementById('applyFiltersBtn');
    const clearBtn      = document.getElementById('clearFiltersBtn');
    const sentinelEl    = document.getElementById('scrollSentinel');
    const minPriceInput = document.getElementById('filterMinPrice');
    const maxPriceInput = document.getElementById('filterMaxPrice');
    const ratingInputs  = document.querySelectorAll('input[name="rating_filter"]');

    // ── Helpers ───────────────────────────────────────────────────────────────
    function setLoading(on) {
        state.loading = on;
        if (sentinelEl) sentinelEl.innerHTML = on
            ? `<i class="fa-solid fa-spinner fa-spin fa-2x" style="color:var(--primary)"></i>`
            : '';
    }

    function showEmpty() {
        grid.innerHTML = `
            <div style="grid-column:1/-1;text-align:center;padding:4rem 1rem;color:var(--text-muted);">
                <i class="fa-solid fa-box-open fa-3x" style="opacity:0.4;margin-bottom:1.25rem;display:block;"></i>
                <p style="font-size:1.1rem;font-weight:600;">No products found</p>
                <p style="margin-top:0.5rem;font-size:0.9rem;">Try adjusting your filters or search term.</p>
            </div>`;
    }

    function showError() {
        grid.innerHTML = `
            <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#ef4444;">
                <i class="fa-solid fa-triangle-exclamation fa-2x" style="margin-bottom:1rem;display:block;"></i>
                <p>Failed to connect to the API. Please try again later.</p>
            </div>`;
    }

    // ── Fetch & Render ────────────────────────────────────────────────────────
    async function loadProducts(reset = false) {
        if (state.loading || (!state.hasMore && !reset)) return;
        setLoading(true);

        if (reset) {
            state.cursor  = null;
            state.hasMore = true;
            grid.innerHTML = '';
        }

        const params = {
            search:      state.search      || null,
            category_id: state.category_id || null,
            min_price:   state.min_price   || null,
            max_price:   state.max_price   || null,
            min_rating:  state.min_rating  || null,
            sort:        state.sort,
            per_page:    15,
            cursor:      state.cursor      || null,
        };

        const { ok, data } = await API.get('/products', params);

        setLoading(false);

        if (!ok) { if (reset) showError(); return; }

        const products = data.data ?? [];
        const meta     = data.meta ?? {};

        if (products.length === 0 && reset) { showEmpty(); return; }

        // Append cards
        const fragment = document.createDocumentFragment();
        const wrapper  = document.createElement('div');
        wrapper.innerHTML = products.map(buildProductCard).join('');
        Array.from(wrapper.children).forEach(c => fragment.appendChild(c));
        grid.appendChild(fragment);

        // Update cursor for next page
        state.cursor  = meta.next_cursor ?? null;
        state.hasMore = meta.has_more    ?? false;

        // Update toolbar count label
        if (toolbar) toolbar.textContent = products.length > 0
            ? `Showing ${grid.children.length} products`
            : 'No products found';
    }

    // ── Infinite Scroll via IntersectionObserver ──────────────────────────────
    if (sentinelEl) {
        const io = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !state.loading && state.hasMore) {
                loadProducts(false);
            }
        }, { rootMargin: '200px' });
        io.observe(sentinelEl);
    }

    // ── Sort ──────────────────────────────────────────────────────────────────
    if (sortSelect) {
        sortSelect.addEventListener('change', () => {
            const map = {
                'latest': 'latest', 'price_asc': 'price_asc',
                'price_desc': 'price_desc', 'rating': 'rating',
            };
            state.sort = map[sortSelect.value] ?? 'latest';
            loadProducts(true);
        });
    }

    // ── Live Search (debounced 400ms) ─────────────────────────────────────────
    let searchTimer;
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                state.search = searchInput.value.trim();
                loadProducts(true);
            }, 400);
        });
    }

    // ── Filter: Apply ─────────────────────────────────────────────────────────
    if (applyBtn) {
        applyBtn.addEventListener('click', () => {
            state.min_price  = minPriceInput?.value ? parseFloat(minPriceInput.value) : null;
            state.max_price  = maxPriceInput?.value  ? parseFloat(maxPriceInput.value)  : null;

            const checkedRating = document.querySelector('input[name="rating_filter"]:checked');
            state.min_rating = checkedRating ? parseInt(checkedRating.value) : null;

            // Category checkboxes
            const checkedCat = document.querySelector('input[name="category_filter"]:checked');
            state.category_id = checkedCat ? checkedCat.value : null;

            loadProducts(true);

            // Close mobile sidebar
            document.getElementById('filter-sidebar')?.classList.remove('active');
            document.getElementById('filter-overlay')?.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // ── Filter: Clear ─────────────────────────────────────────────────────────
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (minPriceInput) minPriceInput.value = '';
            if (maxPriceInput) maxPriceInput.value = '';
            document.querySelectorAll('input[name="rating_filter"]').forEach(r => r.checked = false);
            document.querySelectorAll('input[name="category_filter"]').forEach(r => r.checked = false);
            state = { ...state, min_price: null, max_price: null, min_rating: null, category_id: null };
            loadProducts(true);
        });
    }

    // ── Initial Load ──────────────────────────────────────────────────────────
    loadProducts(true);
});
