/**
 * Vendo — Core App Logic
 * Handles: Auth, Navbar, Dark Mode, Animations, Cart, Toasts
 */
document.addEventListener('DOMContentLoaded', () => {

    /* ================================================================
       0. CONSTANTS & STATE
    ================================================================ */
    const API_BASE = '/api';
    const TAX_RATE = 0.08; // 8%

    /* ================================================================
       1. AUTH STATE — role-based UI
    ================================================================ */
    let currentUser = { isLoggedIn: false, role: 'guest', name: '' };

    const token    = localStorage.getItem('auth_token');
    const rawUser  = localStorage.getItem('user') || localStorage.getItem('user_data');

    if (token && rawUser) {
        try {
            const parsed = JSON.parse(rawUser);
            currentUser = {
                isLoggedIn: true,
                role: parsed.role || 'user',
                name: parsed.name || 'User',
                id:   parsed.id   || null,
            };
        } catch (e) {}
    }

    const applyAuthUI = () => {
        const { isLoggedIn, role, name } = currentUser;

        if (isLoggedIn) {
            // Hide guest elements
            document.querySelectorAll('.guest-only').forEach(el => {
                el.style.display = 'none';
            });

            // Show / filter auth elements
            document.querySelectorAll('.auth-only').forEach(el => {
                const isVendorOnly   = el.classList.contains('vendor-only');
                const isAdminOnly    = el.classList.contains('admin-only');
                const isUserOnly     = el.classList.contains('auth-user-only');

                let visible = true;
                if (isVendorOnly && role !== 'vendor') visible = false;
                if (isAdminOnly  && role !== 'admin')  visible = false;
                if (isUserOnly   && (role === 'vendor' || role === 'admin')) visible = false;

                if (visible) {
                    // Determine the right display value
                    let display = 'block';
                    if (el.tagName === 'LI') display = '';
                    else if (el.classList.contains('desktop-only') ||
                             el.classList.contains('dropdown')     ||
                             el.classList.contains('nav-actions')  ||
                             el.classList.contains('d-flex')) display = 'flex';
                    el.style.display = display;
                } else {
                    el.style.display = 'none';
                }
            });

            // Populate user name + role labels everywhere
            document.querySelectorAll('.navUserName').forEach(el => el.textContent = name);
            document.querySelectorAll('.navUserRole').forEach(el => {
                el.textContent = role.charAt(0).toUpperCase() + role.slice(1);
            });
            document.querySelectorAll('.vendorStoreName').forEach(el => el.textContent = name + "'s Store");

            // Trigger vendor dashboard if on seller page
            if (role === 'vendor' && typeof window.loadVendorDashboard === 'function') {
                window.loadVendorDashboard();
            }

        } else {
            // Hide all auth elements
            document.querySelectorAll('.auth-only').forEach(el => el.style.display = 'none');

            // Show guest elements
            document.querySelectorAll('.guest-only').forEach(el => {
                let display = 'block';
                if (el.tagName === 'LI') display = '';
                else if (el.classList.contains('desktop-only') ||
                         el.classList.contains('d-flex')       ||
                         el.classList.contains('dropdown')) display = 'flex';
                el.style.display = display;
            });
        }
    };

    applyAuthUI();

    /* ================================================================
       2. LOGOUT
    ================================================================ */
    document.querySelectorAll('.mobileLogoutBtn, .desktopLogoutBtn').forEach(btn => {
        btn.addEventListener('click', async e => {
            e.preventDefault();
            const savedToken = localStorage.getItem('auth_token');
            if (savedToken) {
                try {
                    await fetch(`${API_BASE}/logout`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${savedToken}`,
                            'Accept': 'application/json'
                        }
                    });
                } catch {}
            }
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            localStorage.removeItem('user_data');
            showToast('Logged out successfully.', 'success');
            setTimeout(() => window.location.href = 'index.html', 900);
        });
    });

    /* ================================================================
       3. STICKY NAVBAR
    ================================================================ */
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    /* ================================================================
       4. MOBILE MENU TOGGLE
    ================================================================ */
    const hamburger = document.querySelector('.hamburger');
    const navLinks  = document.querySelector('.nav-links');
    const mobileOverlay = document.querySelector('.mobile-overlay');

    if (hamburger && navLinks && mobileOverlay) {
        const menuIcon = hamburger.querySelector('i');

        const openMenu = () => {
            navLinks.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            menuIcon?.classList.replace('fa-bars-staggered', 'fa-xmark');
        };
        const closeMenu = () => {
            navLinks.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
            menuIcon?.classList.replace('fa-xmark', 'fa-bars-staggered');
            document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));
        };

        hamburger.addEventListener('click', () => {
            navLinks.classList.contains('active') ? closeMenu() : openMenu();
        });
        mobileOverlay.addEventListener('click', closeMenu);
    }

    /* ================================================================
       5. MOBILE DROPDOWN ACCORDION
    ================================================================ */
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', e => {
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                e.stopPropagation();
                toggle.parentElement.classList.toggle('active');
            }
        });
    });

    /* ================================================================
       6. MEGA MENU (Desktop)
    ================================================================ */
    const megaDropdown = document.querySelector('.mega-dropdown');
    const megaMenu     = document.querySelector('.mega-menu');
    if (megaDropdown && megaMenu) {
        let closeTimer;
        const openMega = () => { clearTimeout(closeTimer); megaMenu.classList.add('active'); };
        const closeMega = () => { closeTimer = setTimeout(() => megaMenu.classList.remove('active'), 180); };

        if (window.innerWidth > 1024) {
            megaDropdown.addEventListener('mouseenter', openMega);
            megaDropdown.addEventListener('mouseleave', closeMega);
            megaMenu.addEventListener('mouseenter', openMega);
            megaMenu.addEventListener('mouseleave', closeMega);
        }
    }

    /* ================================================================
       7. DARK MODE
    ================================================================ */
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);

    const setTheme = (dark) => {
        if (dark) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-theme');
        }
        document.querySelectorAll('.theme-toggle i').forEach(i => {
            i.className = dark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        });
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    };

    setTheme(isDark);

    document.querySelectorAll('.theme-toggle').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            setTheme(document.documentElement.getAttribute('data-theme') !== 'dark');
        });
    });

    /* ================================================================
       8. SCROLL ANIMATIONS (Intersection Observer)
    ================================================================ */
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -40px 0px', threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    } else {
        // Fallback: just show all
        document.querySelectorAll('.fade-in').forEach(el => el.classList.add('visible'));
    }

    /* ================================================================
       9. CART — LIVE BADGE COUNT
    ================================================================ */
    const updateCartBadge = async () => {
        const badges = document.querySelectorAll('#cartBadge, .badge.badge-primary');
        if (!token) {
            badges.forEach(b => b.textContent = '0');
            return;
        }
        try {
            const res = await fetch(`${API_BASE}/cart`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            if (res.ok) {
                const data = await res.json();
                const count = data.data?.items?.length ?? data.data?.length ?? 0;
                badges.forEach(b => {
                    b.textContent = count;
                    b.style.display = count > 0 ? 'flex' : 'none';
                });
            }
        } catch {}
    };

    if (token) updateCartBadge();

    /* ================================================================
       10. CART PAGE — SELECTION & TOTALS
    ================================================================ */
    const selectAllCart    = document.getElementById('selectAllCart');
    const cartItemSelects  = document.querySelectorAll('.cart-item-select');
    const proceedCheckoutBtn = document.getElementById('proceedCheckoutBtn');

    if (selectAllCart && cartItemSelects.length > 0) {

        const recalcTotals = () => {
            let count = 0, subtotal = 0;
            const selectedIds = [];

            cartItemSelects.forEach(cb => {
                const itemEl = cb.closest('.cart-item');
                if (cb.checked) {
                    count++;
                    const qty   = parseInt(itemEl.querySelector('.qty-input')?.value || 1, 10);
                    const price = parseFloat(itemEl.dataset.price || 0);
                    subtotal   += price * qty;
                    selectedIds.push(cb.value);
                    itemEl.classList.remove('deselected');
                } else {
                    itemEl.classList.add('deselected');
                }
            });

            const tax   = subtotal * TAX_RATE;
            const total = subtotal + tax;

            document.getElementById('summaryItemsCount').textContent    = `Items (${count})`;
            document.getElementById('summaryItemsSubtotal').textContent  = formatCurrency(subtotal);
            document.getElementById('summaryTax').textContent           = formatCurrency(tax);
            document.getElementById('summaryTotal').textContent         = formatCurrency(total);

            // Sync select-all state
            selectAllCart.checked       = count > 0 && count === cartItemSelects.length;
            selectAllCart.indeterminate = count > 0 && count < cartItemSelects.length;

            return selectedIds;
        };

        // Select all toggle
        selectAllCart.addEventListener('change', e => {
            cartItemSelects.forEach(cb => { cb.checked = e.target.checked; });
            recalcTotals();
        });

        // Individual checkboxes
        cartItemSelects.forEach(cb => cb.addEventListener('change', recalcTotals));

        // Qty buttons
        document.querySelectorAll('.cart-item').forEach(item => {
            const minusBtn = item.querySelectorAll('.qty-btn')[0];
            const plusBtn  = item.querySelectorAll('.qty-btn')[1];
            const input    = item.querySelector('.qty-input');
            if (!input) return;

            minusBtn?.addEventListener('click', () => {
                const v = parseInt(input.value) - 1;
                if (v >= 1) { input.value = v; recalcTotals(); }
            });
            plusBtn?.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
                recalcTotals();
            });

            // Remove button
            item.querySelector('.remove-btn')?.addEventListener('click', () => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                item.style.transition = 'opacity 0.25s, transform 0.25s';
                setTimeout(() => { item.remove(); recalcTotals(); }, 260);
            });
        });

        // Proceed to checkout
        proceedCheckoutBtn?.addEventListener('click', () => {
            if (!currentUser.isLoggedIn) {
                showToast('Please log in to proceed to checkout.', 'error');
                setTimeout(() => window.location.href = 'auth.html', 1200);
                return;
            }
            const ids = recalcTotals();
            if (ids.length === 0) {
                showToast('Select at least one item to checkout.', 'error');
                return;
            }
            window.location.href = `checkout.html?items=${ids.join(',')}`;
        });

        // Initial calculation
        recalcTotals();
    }

    /* ================================================================
       11. ADD-TO-CART BUTTONS (product cards on index/shop pages)
    ================================================================ */
    document.querySelectorAll('.add-to-cart, .product-action-btn.add-to-cart').forEach(btn => {
        btn.addEventListener('click', async e => {
            e.preventDefault();
            e.stopPropagation();

            if (!currentUser.isLoggedIn) {
                showToast('Please log in to add items to cart.', 'error');
                setTimeout(() => window.location.href = 'auth.html', 1200);
                return;
            }

            // Get product id from closest card or data attribute
            const card      = btn.closest('[data-product-id]');
            const productId = card?.dataset?.productId;
            if (!productId) {
                showToast('Item added to cart!', 'success');
                return;
            }

            btn.disabled = true;
            const origHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            try {
                const res = await fetch(`${API_BASE}/cart`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: 1 })
                });
                if (res.ok) {
                    showToast('Added to cart!', 'success');
                    updateCartBadge();
                } else {
                    const d = await res.json();
                    showToast(d.message || 'Could not add item.', 'error');
                }
            } catch {
                showToast('Network error. Please try again.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHTML;
            }
        });
    });

    /* ================================================================
       12. WISHLIST BUTTONS
    ================================================================ */
    document.querySelectorAll('.product-wishlist').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();
            if (!currentUser.isLoggedIn) {
                showToast('Please log in to save items.', 'error');
                return;
            }
            const icon = btn.querySelector('i');
            const inWish = icon.classList.contains('fa-solid');
            icon.className = inWish ? 'fa-regular fa-heart' : 'fa-solid fa-heart';
            btn.style.background = inWish ? '' : 'var(--accent-light)';
            btn.style.color      = inWish ? '' : 'var(--accent)';
            showToast(inWish ? 'Removed from wishlist.' : 'Saved to wishlist!', inWish ? '' : 'success');
        });
    });

    /* ================================================================
       13. GLOBAL TOAST UTILITY
    ================================================================ */
    window.showToast = function(message, type = '') {
        let toast = document.getElementById('vendoToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'vendoToast';
            toast.className = 'toast';
            document.body.appendChild(toast);
        }

        toast.className = 'toast' + (type ? ` toast-${type}` : '');
        const icon = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>'
                   : type === 'error'   ? '<i class="fa-solid fa-circle-exclamation"></i>'
                   : '<i class="fa-solid fa-circle-info"></i>';
        toast.innerHTML = `${icon} ${message}`;

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.add('show');
            clearTimeout(toast._timer);
            toast._timer = setTimeout(() => toast.classList.remove('show'), 3000);
        });
    };

    /* ================================================================
       14. HELPER — Currency Formatter
    ================================================================ */
    function formatCurrency(amount) {
        return '$' + parseFloat(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /* ================================================================
       15. PAYMENT SUCCESS REDIRECT HANDLER
    ================================================================ */
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('payment') === 'success') {
        showToast('Payment successful! Your order has been placed.', 'success');
        // Clean URL
        window.history.replaceState({}, '', window.location.pathname);
    }
    if (urlParams.get('payment') === 'cancelled') {
        showToast('Payment was cancelled. Your cart is still saved.', 'error');
        window.history.replaceState({}, '', window.location.pathname);
    }

    /* ================================================================
       16. PAGE-SPECIFIC INIT on index.html (featured products from API)
    ================================================================ */
    const featuredGrid = document.getElementById('featuredProductsGrid');
    if (featuredGrid && typeof window.loadFeaturedFromAPI !== 'function') {
        // Will only fire if shop.js hasn't already taken over
        const alreadyHandled = document.getElementById('productGrid');
        if (!alreadyHandled) {
            loadFeaturedProducts(featuredGrid);
        }
    }

    async function loadFeaturedProducts(grid) {
        try {
            const res  = await fetch(`${API_BASE}/products?limit=8&sort=latest`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const products = data.data?.data || data.data || [];
            if (!products.length) return; // Keep static placeholder cards

            grid.innerHTML = products.slice(0, 4).map(p => `
                <div class="product-card fade-in" data-product-id="${p.id}">
                    <button class="product-wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="product-img">
                        ${p.image ? `<img src="${p.image}" alt="${escHtml(p.name)}" loading="lazy">` : `<i class="fa-solid fa-box-open"></i>`}
                        <div class="product-actions">
                            <button class="product-action-btn add-to-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                            <button class="product-action-btn" onclick="window.location.href='product.html?id=${p.id}'"><i class="fa-regular fa-eye"></i> View</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <a href="vendor.html?id=${p.vendor_id || ''}" class="product-vendor">${escHtml(p.vendor?.store_name || 'Vendor')}</a>
                        <a href="product.html?id=${p.id}" class="product-title">${escHtml(p.name)}</a>
                        <div class="product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star-half-stroke"></i>
                            <span>(${p.reviews_count || 0})</span>
                        </div>
                        <div class="product-price-row">
                            <div class="price-box">
                                <span class="price">${formatCurrency(p.price)}</span>
                                ${p.old_price ? `<span class="old-price">${formatCurrency(p.old_price)}</span>` : ''}
                            </div>
                            <button class="btn btn-xs btn-primary add-to-cart"><i class="fa-solid fa-plus"></i> Add</button>
                        </div>
                    </div>
                </div>
            `).join('');

            // Re-observe new fade-in elements
            grid.querySelectorAll('.fade-in').forEach(el => {
                observer?.observe?.(el);
                setTimeout(() => el.classList.add('visible'), 100);
            });

            // Re-attach event listeners for new add-to-cart buttons
            grid.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', async e => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (!currentUser.isLoggedIn) {
                        showToast('Please log in to add items to cart.', 'error');
                        return;
                    }
                    const card = btn.closest('[data-product-id]');
                    const pid  = card?.dataset?.productId;
                    if (!pid) return;
                    try {
                        const r = await fetch(`${API_BASE}/cart`, { method:'POST', headers:{'Content-Type':'application/json','Authorization':`Bearer ${token}`,'Accept':'application/json'}, body: JSON.stringify({product_id:pid, quantity:1}) });
                        if (r.ok) { showToast('Added to cart!', 'success'); updateCartBadge(); }
                    } catch {}
                });
            });
        } catch {}
    }

    /* ================================================================
       17. HELPER — HTML Escaper
    ================================================================ */
    function escHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

}); // END DOMContentLoaded
