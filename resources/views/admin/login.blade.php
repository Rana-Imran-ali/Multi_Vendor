<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Vendo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary:       #3b82f6;
            --primary-dark:  #2563eb;
            --sidebar-dark:  #0f172a;
            --text-main:     #1e293b;
            --text-sub:      #64748b;
            --border:        #e2e8f0;
            --bg:            #f8fafc;
            --radius:        12px;
            --font:          'Inter', sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ── Split Layout ── */
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.12);
        }

        /* ── Left Brand Panel ── */
        .brand-panel {
            flex: 1;
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .brand-panel::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);
            top: -80px; right: -80px;
        }
        .brand-panel::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.15), transparent 70%);
            bottom: -40px; left: -40px;
        }
        .brand-logo {
            font-size: 2rem; font-weight: 800;
            color: #fff; letter-spacing: -1px; margin-bottom: 2rem;
            position: relative; z-index: 1;
        }
        .brand-logo span { color: #38bdf8; }
        .brand-headline {
            font-size: 1.5rem; font-weight: 700;
            color: #fff; line-height: 1.4; margin-bottom: 1rem;
            position: relative; z-index: 1;
        }
        .brand-sub {
            font-size: 0.9rem; color: #94a3b8; line-height: 1.7;
            position: relative; z-index: 1;
        }
        .brand-stats {
            display: flex; gap: 1.5rem; margin-top: 2.5rem;
            position: relative; z-index: 1;
        }
        .stat-item { text-align: left; }
        .stat-num { font-size: 1.4rem; font-weight: 800; color: #38bdf8; line-height: 1; margin-bottom: 0.25rem; }
        .stat-label { font-size: 0.72rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }

        @media (max-width: 640px) { .brand-panel { display: none; } }

        /* ── Right Form Panel ── */
        .form-panel {
            flex: 0 0 420px;
            background: #fff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        @media (max-width: 640px) { .form-panel { flex: 1; padding: 2rem 1.5rem; } }

        .form-heading { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.35rem; }
        .form-sub    { font-size: 0.875rem; color: var(--text-sub); margin-bottom: 2rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; font-size: 0.8rem; font-weight: 600;
            color: var(--text-main); margin-bottom: 0.5rem; letter-spacing: 0.1px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-sub); font-size: 0.9rem; transition: color 0.2s;
        }
        .form-input {
            width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid var(--border); border-radius: 10px;
            font-family: var(--font); font-size: 0.9rem;
            color: var(--text-main); background: #fafafa;
            transition: all 0.2s; outline: none;
        }
        .form-input:focus {
            border-color: var(--primary); background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .form-input.is-invalid { border-color: #ef4444; box-shadow: 0 0 0 4px rgba(239,68,68,0.1); }
        .toggle-pw {
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-sub); cursor: pointer;
            padding: 0; font-size: 0.9rem; transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--primary); }

        .btn-login {
            width: 100%; padding: 0.8rem;
            background: var(--primary); color: #fff;
            font-family: var(--font); font-size: 0.95rem; font-weight: 600;
            border: none; border-radius: 10px; cursor: pointer;
            transition: all 0.2s; position: relative; overflow: hidden;
            margin-top: 0.5rem;
        }
        .btn-login:hover:not(:disabled) { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,130,246,0.35); }
        .btn-login:active:not(:disabled) { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.7; cursor: not-allowed; }
        .btn-spinner { display: none; width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Alert */
        .alert-error {
            display: none; padding: 0.8rem 1rem; border-radius: 10px;
            background: #fef2f2; border: 1px solid #fee2e2;
            color: #dc2626; font-size: 0.85rem; font-weight: 500;
            margin-bottom: 1.25rem; align-items: center; gap: 0.6rem;
        }

        .divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }
        .hint { font-size: 0.78rem; color: var(--text-sub); text-align: center; }
        .hint code { background: #f1f5f9; padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.78rem; color: var(--text-main); }
    </style>
</head>
<body>

    <div class="login-wrapper">

        {{-- ── Left: Brand Panel ── --}}
        <div class="brand-panel">
            <div class="brand-logo">Vendo<span>.</span></div>
            <h2 class="brand-headline">Your Multi‑Vendor<br>Command Centre</h2>
            <p class="brand-sub">Manage vendors, products, orders and customers from one powerful dashboard.</p>
            <div class="brand-stats">
                <div class="stat-item">
                    <div class="stat-num" id="statUsers">—</div>
                    <div class="stat-label">Customers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num" id="statVendors">—</div>
                    <div class="stat-label">Vendors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num" id="statOrders">—</div>
                    <div class="stat-label">Orders</div>
                </div>
            </div>
        </div>

        {{-- ── Right: Form Panel ── --}}
        <div class="form-panel">
            <h1 class="form-heading">Welcome back</h1>
            <p class="form-sub">Sign in to your admin account</p>

            {{-- Error Alert --}}
            <div class="alert-error" id="alertError" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span id="alertMsg">Invalid credentials.</span>
            </div>

            <form id="loginForm" autocomplete="off" novalidate>
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input
                            id="email" name="email" type="email"
                            class="form-input" placeholder="admin@example.com"
                            autocomplete="username" required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input
                            id="password" name="password" type="password"
                            class="form-input" placeholder="••••••••"
                            autocomplete="current-password" required
                        >
                        <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span id="btnText">Sign In</span>
                    <div class="btn-spinner" id="btnSpinner"></div>
                </button>
            </form>

            <hr class="divider">
            <p class="hint">
                Default: <code>ranaimranali3310@gmail.com</code> / <code>@12345678</code>
            </p>
        </div>
    </div>

    <script>
    (function () {
        // ── If already logged in, go straight to dashboard ──
        if (localStorage.getItem('admin_token')) {
            window.location.replace('/admin/dashboard');
        }

        const form       = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const pwInput    = document.getElementById('password');
        const btnText    = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const loginBtn   = document.getElementById('loginBtn');
        const alertBox   = document.getElementById('alertError');
        const alertMsg   = document.getElementById('alertMsg');

        // ── Password toggle ──
        document.getElementById('togglePw').addEventListener('click', function () {
            const isText = pwInput.type === 'text';
            pwInput.type = isText ? 'password' : 'text';
            document.getElementById('eyeIcon').className = isText ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        });

        // ── Show/hide error alert ──
        function showError(msg) {
            alertMsg.textContent = msg;
            alertBox.style.display = 'flex';
            emailInput.classList.add('is-invalid');
            pwInput.classList.add('is-invalid');
        }
        function hideError() {
            alertBox.style.display = 'none';
            emailInput.classList.remove('is-invalid');
            pwInput.classList.remove('is-invalid');
        }

        // ── Loading state ──
        function setLoading(on) {
            loginBtn.disabled = on;
            btnText.style.display     = on ? 'none' : 'inline';
            btnSpinner.style.display  = on ? 'block' : 'none';
        }

        // ── Form Submit ──
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            hideError();

            const email    = emailInput.value.trim();
            const password = pwInput.value;

            if (!email || !password) {
                showError('Please enter your email and password.');
                return;
            }

            setLoading(true);

            try {
                const res = await fetch('/api/login', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body:    JSON.stringify({ email, password }),
                });

                const json = await res.json();

                if (!res.ok || json.status !== 'success') {
                    showError(json.message || 'Invalid credentials.');
                    return;
                }

                const user = json.data.user;

                // ── Role guard: only allow admins ──
                if (user.role !== 'admin') {
                    showError('Access denied. This panel is for admins only.');
                    return;
                }

                // ── Persist session ──
                localStorage.setItem('admin_token', json.data.token);
                localStorage.setItem('admin_user',  JSON.stringify({
                    name:  user.name,
                    email: user.email,
                    role:  user.role,
                }));

                // ── Redirect ──
                window.location.replace('/admin/dashboard');

            } catch (err) {
                showError('Network error. Please check your connection and try again.');
            } finally {
                setLoading(false);
            }
        });

        // ── Clear invalid styles on input ──
        [emailInput, pwInput].forEach(el => el.addEventListener('input', hideError));
    })();
    </script>

</body>
</html>
