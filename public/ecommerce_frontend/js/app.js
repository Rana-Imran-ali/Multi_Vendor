document.addEventListener('DOMContentLoaded', () => {
    
    // 0. Auth Role Logic (Actual API Integration)
    let currentUser = { isLoggedIn: false, role: 'guest', name: '' };
    const token = localStorage.getItem('auth_token');
    const userData = localStorage.getItem('user_data');
    if (token && userData) {
        try {
            const user = JSON.parse(userData);
            currentUser = {
                isLoggedIn: true,
                role: user.role,
                name: user.name
            };
        } catch(e) {}
    }

    if (currentUser.isLoggedIn) {
        document.querySelectorAll('.guest-only').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.auth-only').forEach(el => {
            // Check if it has specific role classes
            const isVendorOnly = el.classList.contains('vendor-only');
            const isAdminOnly = el.classList.contains('admin-only');
            const isAuthUserOnly = el.classList.contains('auth-user-only');
            
            if (isVendorOnly && currentUser.role !== 'vendor') {
                el.style.display = 'none';
            } else if (isAdminOnly && currentUser.role !== 'admin') {
                el.style.display = 'none';
            } else if (isAuthUserOnly && (currentUser.role === 'vendor' || currentUser.role === 'admin')) {
                el.style.display = 'none';
            } else {
                if (el.tagName === 'LI' || el.classList.contains('dropdown')) {
                    el.style.display = '';
                } else if (el.classList.contains('icon-btn') || el.classList.contains('btn') || el.classList.contains('desktop-only')){
                    el.style.display = 'flex'; 
                } else {
                    el.style.display = 'block';
                }
            }
        });
        
        // Update Name
        document.querySelectorAll('.navUserName').forEach(el => el.textContent = currentUser.name);
        document.querySelectorAll('.navUserRole').forEach(el => el.textContent = currentUser.role.charAt(0).toUpperCase() + currentUser.role.slice(1));
    } else {
        document.querySelectorAll('.auth-only').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.guest-only').forEach(el => {
            if (el.tagName === 'LI' || el.classList.contains('dropdown')) {
                el.style.display = '';
            } else if (el.classList.contains('desktop-only') || el.classList.contains('btn')){
                el.style.display = 'flex';
            } else {
                el.style.display = 'block';
            }
        });
    }

    // Logout Logic
    document.querySelectorAll('.mobileLogoutBtn, .desktopLogoutBtn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            if (localStorage.getItem('auth_token')) {
                try {
                    await fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                            'Accept': 'application/json'
                        }
                    });
                } catch(e) {}
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user_data');
            }
            window.location.href = 'index.html';
        });
    });

    // Mega menu desktop interaction logic
    const megaDropdown = document.querySelector('.mega-dropdown');
    const megaMenu = document.querySelector('.mega-menu');
    if(megaDropdown && megaMenu && window.innerWidth > 1024) {
        let timeout;
        megaDropdown.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            megaMenu.classList.add('active');
        });
        megaDropdown.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                megaMenu.classList.remove('active');
            }, 200);
        });
    }

    // 1. Sticky Navbar & Shadow
    const navbar = document.querySelector('.navbar');
    if(navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // 2. Mobile Menu Toggle
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const overlay = document.querySelector('.mobile-overlay');
    
    if (hamburger && navLinks && overlay) {
        const icon = hamburger.querySelector('i');
        
        const toggleMenu = () => {
            navLinks.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
            
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars-staggered');
                icon.classList.add('fa-xmark');
            } else {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars-staggered');
                // Close inner dropdowns when drawer closes
                document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));
            }
        };

        hamburger.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    }

    // 3. Mobile Dropdown Accordion
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024) {
                e.preventDefault();
                toggle.parentElement.classList.toggle('active');
            }
        });
    });

    // 4. Dark Mode Toggle
    const themeToggleBtns = document.querySelectorAll('.theme-toggle');
    
    // Check local storage or system preference
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.setAttribute('data-theme', 'dark');
        themeToggleBtns.forEach(btn => {
            const icon = btn.querySelector('i');
            if(icon) { icon.classList.replace('fa-moon', 'fa-sun'); }
        });
    }

    themeToggleBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                document.querySelectorAll('.theme-toggle i').forEach(i => i.classList.replace('fa-sun', 'fa-moon'));
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                document.querySelectorAll('.theme-toggle i').forEach(i => i.classList.replace('fa-moon', 'fa-sun'));
            }
        });
    });

    // 5. Scroll Animations (Intersection Observer for fade-in effect)
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Optional: only animate once
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });

    // 6. Cart Selection & Total Logic
    const selectAllCart = document.getElementById('selectAllCart');
    const cartItemSelects = document.querySelectorAll('.cart-item-select');
    const proceedCheckoutBtn = document.getElementById('proceedCheckoutBtn');

    if (selectAllCart && cartItemSelects.length > 0) {
        const updateCartTotals = () => {
            let totalItems = 0;
            let subtotal = 0;
            let selectedIds = [];

            cartItemSelects.forEach(cb => {
                if (cb.checked) {
                    totalItems++;
                    const itemEl = cb.closest('.cart-item');
                    subtotal += parseFloat(itemEl.getAttribute('data-price') || 0);
                    selectedIds.push(cb.value);
                }
            });

            // Update DOM
            const tax = subtotal > 0 ? 120.00 : 0;
            document.getElementById('summaryItemsCount').textContent = `Items (${totalItems})`;
            document.getElementById('summaryItemsSubtotal').textContent = `$${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            document.getElementById('summaryTax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('summaryTotal').textContent = `$${(subtotal + tax).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
            
            // Check selectAll state
            selectAllCart.checked = (totalItems === cartItemSelects.length && totalItems > 0);
            
            return selectedIds;
        };

        selectAllCart.addEventListener('change', (e) => {
            cartItemSelects.forEach(cb => cb.checked = e.target.checked);
            updateCartTotals();
        });

        cartItemSelects.forEach(cb => {
            cb.addEventListener('change', updateCartTotals);
        });

        proceedCheckoutBtn.addEventListener('click', () => {
            const selectedIds = updateCartTotals();
            if (selectedIds.length === 0) {
                alert('Please select at least one item to proceed.');
                return;
            }
            
            // Note: in a real application, we would pass these to checkout 
            // via URL params or session storage. For HTML demo:
            const params = new URLSearchParams();
            params.append('items', selectedIds.join(','));
            window.location.href = `checkout.html?${params.toString()}`;
        });
        
        updateCartTotals(); // Initial calc
    }
});
