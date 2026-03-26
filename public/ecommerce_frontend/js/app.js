document.addEventListener('DOMContentLoaded', () => {
    
    // 0. Auth Role Logic (Mock for Prototype)
    // Change this to test different roles: 'guest', 'user', 'vendor', 'admin'
    const currentUser = {
        isLoggedIn: true,
        role: 'user', // Default test role
        name: 'Alex Johnson'
    };
    
    // For demo purposes, check URL params to easily test roles: ?role=admin
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('role')) {
        currentUser.role = urlParams.get('role');
        currentUser.isLoggedIn = currentUser.role !== 'guest';
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

    // Logout mock
    document.querySelectorAll('.mobileLogoutBtn, .desktopLogoutBtn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = window.location.pathname + '?role=guest';
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
});
