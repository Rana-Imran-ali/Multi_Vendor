<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Vendo – Pakistan\'s modern multi-vendor marketplace. Shop from thousands of trusted sellers.')">

    <title>@yield('title', 'Vendo — Modern Multi-Vendor Marketplace')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        /* ============================================================
           GLOBAL DESIGN TOKENS
        ============================================================ */
        :root {
            --brand-primary:   #f04f23;   /* vibrant coral-orange */
            --brand-dark:      #c93e1b;
            --brand-light:     #fff3ef;
            --surface-dark:    #0f0f0f;
            --surface-nav:     #ffffff;
            --surface-footer:  #111418;
            --text-primary:    #1a1a2e;
            --text-secondary:  #5a6071;
            --text-muted:      #9099a7;
            --border-light:    #e8eaed;
            --shadow-sm:       0 1px 4px rgba(0,0,0,.08);
            --shadow-md:       0 4px 20px rgba(0,0,0,.10);
            --shadow-lg:       0 8px 40px rgba(0,0,0,.14);
            --radius-sm:       6px;
            --radius-md:       10px;
            --radius-lg:       16px;
            --transition:      all .22s cubic-bezier(.4,0,.2,1);
            --font-base:       'Inter', sans-serif;
        }

        /* ============================================================
           RESETS & BASE
        ============================================================ */
        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-base);
            color: var(--text-primary);
            background: #f7f8fa;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        img { max-width: 100%; height: auto; }

        ::selection {
            background: var(--brand-primary);
            color: #fff;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0f0f0; }
        ::-webkit-scrollbar-thumb { background: #c0c4cc; border-radius: 10px; }

        /* ============================================================
           UTILITY OVERRIDES
        ============================================================ */
        .btn-brand {
            background: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #fff;
            font-weight: 600;
            letter-spacing: .3px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        .btn-brand:hover, .btn-brand:focus {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
            color: #fff;
            box-shadow: 0 4px 16px rgba(240,79,35,.35);
        }

        .btn-outline-brand {
            border: 1.5px solid var(--brand-primary);
            color: var(--brand-primary);
            font-weight: 600;
            border-radius: var(--radius-sm);
            background: transparent;
            transition: var(--transition);
        }
        .btn-outline-brand:hover {
            background: var(--brand-primary);
            color: #fff;
        }

        /* ============================================================
           MAIN CONTENT WRAPPER
        ============================================================ */
        #main-content {
            min-height: 60vh;
        }

        /* Page-level flash messages */
        .flash-wrapper {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1100;
            min-width: 280px;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ===== TOP ANNOUNCEMENT BAR ===== --}}
    <div class="topbar bg-dark text-white py-1 d-none d-md-block" style="font-size:.78rem;">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <span><i class="fa fa-truck me-1" style="color:var(--brand-primary);"></i> Free shipping on orders over <strong>Rs 2,000</strong></span>
            <div class="d-flex gap-3">
                <a href="#" class="text-white-50 text-hover-white">Sell on Vendo</a>
                <span class="text-white-50">|</span>
                <a href="#" class="text-white-50 text-hover-white">Track Order</a>
                <span class="text-white-50">|</span>
                <a href="#" class="text-white-50 text-hover-white">Help Center</a>
            </div>
        </div>
    </div>

    {{-- ===== NAVBAR ===== --}}
    @include('components.navbar')

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success') || session('error') || session('info'))
    <div class="flash-wrapper">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fa fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fa fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="fa fa-circle-info me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>
    @endif

    {{-- ===== PAGE CONTENT ===== --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    @include('components.footer')

    {{-- ===== SCRIPTS ===== --}}
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* Auto-dismiss flash alerts */
        document.querySelectorAll('.flash-wrapper .alert').forEach(el => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                bsAlert.close();
            }, 5000);
        });

        /* Navbar shrink on scroll */
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 60) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
