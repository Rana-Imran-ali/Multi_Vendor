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

/**
 * Global Cart API Handle
 */
const CartAPI = {
    async fetch() {
        if (!Auth.check()) return null;
        try {
            const res = await fetch('/api/cart', { headers: Auth.getAuthHeaders() });
            return await res.json();
        } catch (e) {
            return null;
        }
    },
    async add(productId, quantity = 1, variant = null) {
        if (!Auth.check()) {
            window.location.href = '/login';
            return null;
        }
        const res = await fetch('/api/cart', {
            method: 'POST',
            headers: Auth.getAuthHeaders(),
            body: JSON.stringify({ product_id: productId, quantity, variant })
        });
        return await res.json();
    },
    async update(itemId, quantity) {
        const res = await fetch(`/api/cart/${itemId}`, {
            method: 'PUT',
            headers: Auth.getAuthHeaders(),
            body: JSON.stringify({ quantity })
        });
        return await res.json();
    },
    async remove(itemId) {
        const res = await fetch(`/api/cart/${itemId}`, {
            method: 'DELETE',
            headers: Auth.getAuthHeaders()
        });
        return await res.json();
    }
};

/**
 * Global Wishlist API Handle
 */
const WishlistAPI = {
    async fetch() {
        if (!Auth.check()) return null;
        const res = await fetch('/api/wishlist', { headers: Auth.getAuthHeaders() });
        return await res.json();
    },
    async add(productId) {
        if (!Auth.check()) {
            window.location.href = '/login';
            return null;
        }
        const res = await fetch('/api/wishlist', {
            method: 'POST',
            headers: Auth.getAuthHeaders(),
            body: JSON.stringify({ product_id: productId })
        });
        return await res.json();
    },
    async remove(productId) {
        const res = await fetch(`/api/wishlist/${productId}`, {
            method: 'DELETE',
            headers: Auth.getAuthHeaders()
        });
        return await res.json();
    }
};

// Global Exposure
window.Auth = Auth;
window.CartAPI = CartAPI;
window.WishlistAPI = WishlistAPI;
