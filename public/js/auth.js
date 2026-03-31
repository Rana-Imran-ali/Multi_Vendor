const Auth = {
    /**
     * Get the stored Sanctum token
     */
    getToken() {
        return localStorage.getItem('auth_token');
    },

    /**
     * Get the stored user object
     */
    getUser() {
        const user = localStorage.getItem('auth_user');
        return user ? JSON.parse(user) : null;
    },

    /**
     * Check if user is authenticated
     */
    check() {
        return !!this.getToken();
    },

    /**
     * Set Authentication Data
     */
    setAuth(token, user) {
        localStorage.setItem('auth_token', token);
        localStorage.setItem('auth_user', JSON.stringify(user));
    },

    /**
     * Clear Authentication Data
     */
    clearAuth() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('auth_user');
    },

    /**
     * Headers for API Requests
     */
    getAuthHeaders() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${this.getToken()}`
        };
    },
    
    /**
     * Non-Auth Headers
     */
    getHeaders() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
    },

    /**
     * Perform API Login
     */
    async login(email, password) {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: this.getHeaders(),
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        if (response.ok && data.status === 'success') {
            this.setAuth(data.data.token, data.data.user);
            return { success: true, user: data.data.user };
        }
        return { success: false, message: data.message || 'Login failed', errors: data.errors };
    },

    /**
     * Perform API Registration
     */
    async register(name, email, password, password_confirmation, role = 'customer') {
        const payload = { name, email, password, password_confirmation, role };
        
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: this.getHeaders(),
            body: JSON.stringify(payload)
        });
        
        const data = await response.json();
        
        // Sanctum validation returns 422 with an 'errors' unbagged object
        if (response.ok && data.status === 'success') {
            this.setAuth(data.data.token, data.data.user);
            return { success: true, user: data.data.user };
        }
        
        return { success: false, message: data.message || 'Registration failed', errors: data.errors };
    },

    /**
     * Perform API Logout
     */
    async logout() {
        if (!this.check()) return true;
        
        const response = await fetch('/api/logout', {
            method: 'POST',
            headers: this.getAuthHeaders()
        });
        
        this.clearAuth();
        return true;
    },

    /**
     * Get Role-based redirect URL
     */
    getRedirectUrl() {
        const user = this.getUser();
        if (!user) return '/login';
        
        if (user.role === 'admin') return '/admin/dashboard';
        if (user.role === 'vendor') return '/vendor/dashboard';
        return '/user/dashboard';
    }
};

// Global Exposure
window.Auth = Auth;
