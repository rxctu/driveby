import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
window.L = L;

Alpine.plugin(intersect);

// ---------------------------------------------------------------------------
// CSRF helper — returns headers object for fetch requests
// ---------------------------------------------------------------------------
function csrfHeaders(extra = {}) {
    return {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': window.csrfToken ?? '',
        ...extra,
    };
}

// ---------------------------------------------------------------------------
// Toast notification system (Alpine store)
// ---------------------------------------------------------------------------
Alpine.store('toast', {
    visible: false,
    message: '',
    type: 'success', // 'success' | 'error' | 'info'
    _timeout: null,

    show(message, type = 'success', duration = 3000) {
        this.message = message;
        this.type = type;
        this.visible = true;

        clearTimeout(this._timeout);
        this._timeout = setTimeout(() => {
            this.visible = false;
        }, duration);
    },
});

// ---------------------------------------------------------------------------
// Cart badge count (Alpine store)
// ---------------------------------------------------------------------------
Alpine.store('cart', {
    count: parseInt(document.querySelector('[data-cart-count]')?.dataset.cartCount ?? '0', 10),
    justAdded: false,
    _bounceTimeout: null,

    setCount(n) {
        this.count = n;
        // Trigger bounce animation on badge
        this.justAdded = true;
        clearTimeout(this._bounceTimeout);
        this._bounceTimeout = setTimeout(() => { this.justAdded = false; }, 600);
    },
});

// ---------------------------------------------------------------------------
// Cart functionality — global Alpine helpers
// ---------------------------------------------------------------------------
window.addToCart = async function (productId, quantity = 1) {
    try {
        const res = await fetch('/panier/ajouter', {
            method: 'POST',
            headers: csrfHeaders(),
            body: JSON.stringify({ product_id: productId, quantity }),
        });

        if (!res.ok) throw new Error('Erreur lors de l\'ajout au panier');

        const data = await res.json();
        Alpine.store('cart').setCount(data.cart_count ?? Alpine.store('cart').count + quantity);
        Alpine.store('toast').show('Produit ajout\u00e9 au panier');
    } catch (err) {
        console.error(err);
        Alpine.store('toast').show('Impossible d\'ajouter au panier', 'error');
    }
};

window.updateCart = async function (productId, quantity) {
    try {
        const res = await fetch('/panier/modifier', {
            method: 'PATCH',
            headers: csrfHeaders(),
            body: JSON.stringify({ product_id: productId, quantity }),
        });

        if (!res.ok) throw new Error('Erreur lors de la mise \u00e0 jour du panier');

        const data = await res.json();
        Alpine.store('cart').setCount(data.cart_count ?? Alpine.store('cart').count);
        Alpine.store('toast').show('Panier mis \u00e0 jour');
    } catch (err) {
        console.error(err);
        Alpine.store('toast').show('Impossible de mettre \u00e0 jour le panier', 'error');
    }
};

window.removeFromCart = async function (productId) {
    try {
        const res = await fetch(`/panier/supprimer/${productId}`, {
            method: 'DELETE',
            headers: csrfHeaders(),
        });

        if (!res.ok) throw new Error('Erreur lors de la suppression');

        const data = await res.json();
        Alpine.store('cart').setCount(data.cart_count ?? Math.max(0, Alpine.store('cart').count - 1));
        Alpine.store('toast').show('Produit retir\u00e9 du panier');
    } catch (err) {
        console.error(err);
        Alpine.store('toast').show('Impossible de retirer du panier', 'error');
    }
};

// ---------------------------------------------------------------------------
// Delivery fee calculator
// ---------------------------------------------------------------------------
window.calculateDelivery = async function (address) {
    try {
        const res = await fetch('/checkout/delivery-estimate', {
            method: 'POST',
            headers: csrfHeaders(),
            body: JSON.stringify({ address }),
        });

        if (!res.ok) throw new Error('Erreur lors du calcul des frais de livraison');

        return await res.json();
    } catch (err) {
        console.error(err);
        Alpine.store('toast').show('Impossible de calculer les frais de livraison', 'error');
        return null;
    }
};

// ---------------------------------------------------------------------------
// Mobile menu toggle (Alpine data component)
// ---------------------------------------------------------------------------
Alpine.data('mobileMenu', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    },
}));

// ---------------------------------------------------------------------------
// Delivery estimator (Alpine data component for checkout page)
// ---------------------------------------------------------------------------
Alpine.data('deliveryEstimator', () => ({
    address: '',
    loading: false,
    result: null,

    async estimate() {
        if (!this.address.trim()) return;
        this.loading = true;
        this.result = await calculateDelivery(this.address);
        this.loading = false;
    },
}));

// ---------------------------------------------------------------------------
// Start Alpine
// ---------------------------------------------------------------------------
window.Alpine = Alpine;
Alpine.start();
