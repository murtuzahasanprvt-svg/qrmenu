// QR Menu System - Main JavaScript
class QRMenuApp {
    constructor() {
        this.apiBase = '/qrmenu/api';
        this.currentBranch = null;
        this.cart = [];
        this.favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadBranches();
        this.hideLoadingScreen();
    }

    setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(this.handleSearch.bind(this), 300));
        }

        // Category filtering
        const categoryFilter = document.getElementById('categoryFilter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', this.handleCategoryFilter.bind(this));
        }

        // Cart actions
        document.addEventListener('click', (e) => {
            if (e.target.matches('.add-to-cart')) {
                this.addToCart(e.target.dataset.itemId);
            } else if (e.target.matches('.remove-from-cart')) {
                this.removeFromCart(e.target.dataset.itemId);
            } else if (e.target.matches('.update-quantity')) {
                this.updateQuantity(e.target.dataset.itemId, e.target.dataset.action);
            }
        });

        // Order submission
        const orderForm = document.getElementById('orderForm');
        if (orderForm) {
            orderForm.addEventListener('submit', this.handleOrderSubmit.bind(this));
        }

        // Branch selection
        const branchSelect = document.getElementById('branchSelect');
        if (branchSelect) {
            branchSelect.addEventListener('change', this.handleBranchChange.bind(this));
        }
    }

    async loadBranches() {
        try {
            const response = await fetch(`${this.apiBase}/branches`);
            const data = await response.json();
            
            if (data.data) {
                this.populateBranchSelect(data.data);
                if (data.data.length > 0) {
                    this.currentBranch = data.data[0];
                    this.loadCategories();
                    this.loadMenuItems();
                }
            }
        } catch (error) {
            console.error('Error loading branches:', error);
            this.showError('Failed to load branches');
        }
    }

    populateBranchSelect(branches) {
        const branchSelect = document.getElementById('branchSelect');
        if (!branchSelect) return;

        branchSelect.innerHTML = '<option value="">Select Branch</option>';
        branches.forEach(branch => {
            const option = document.createElement('option');
            option.value = branch.id;
            option.textContent = `${branch.name} - ${branch.area}`;
            branchSelect.appendChild(option);
        });
    }

    async loadCategories() {
        if (!this.currentBranch) return;

        try {
            const response = await fetch(`${this.apiBase}/categories?branch_id=${this.currentBranch.id}`);
            const data = await response.json();
            
            if (data.data) {
                this.populateCategories(data.data);
            }
        } catch (error) {
            console.error('Error loading categories:', error);
            this.showError('Failed to load categories');
        }
    }

    populateCategories(categories) {
        const categoryFilter = document.getElementById('categoryFilter');
        if (!categoryFilter) return;

        categoryFilter.innerHTML = '<option value="">All Categories</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name_bn;
            categoryFilter.appendChild(option);
        });
    }

    async loadMenuItems() {
        if (!this.currentBranch) return;

        try {
            const search = document.getElementById('searchInput')?.value || '';
            const categoryId = document.getElementById('categoryFilter')?.value || '';
            
            let url = `${this.apiBase}/menu-items?branch_id=${this.currentBranch.id}`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (categoryId) url += `&category_id=${categoryId}`;

            const response = await fetch(url);
            const data = await response.json();
            
            if (data.data) {
                this.displayMenuItems(data.data);
            }
        } catch (error) {
            console.error('Error loading menu items:', error);
            this.showError('Failed to load menu items');
        }
    }

    displayMenuItems(items) {
        const menuContainer = document.getElementById('menuContainer');
        if (!menuContainer) return;

        menuContainer.innerHTML = '';
        
        if (items.length === 0) {
            menuContainer.innerHTML = '<div class="col-12 text-center"><p class="text-muted">No menu items found</p></div>';
            return;
        }

        items.forEach(item => {
            const itemCard = this.createMenuItemCard(item);
            menuContainer.appendChild(itemCard);
        });
    }

    createMenuItemCard(item) {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 mb-4';
        
        const isFavorite = this.favorites.includes(item.id);
        const isAvailable = item.is_available;
        
        col.innerHTML = `
            <div class="card menu-card h-100 ${!isAvailable ? 'unavailable' : ''}">
                <div class="card-img-top">
                    ${item.image ? `<img src="${item.image}" class="card-img-top" alt="${item.name_bn}">` : '<div class="placeholder-image"><i class="fas fa-utensils"></i></div>'}
                    <div class="menu-item-badges">
                        ${item.is_popular ? '<span class="badge bg-warning">Popular</span>' : ''}
                        ${item.is_vegetarian ? '<span class="badge bg-success">Veg</span>' : ''}
                        ${item.is_spicy !== 'none' ? `<span class="badge bg-danger">${item.is_spicy}</span>` : ''}
                        ${!isAvailable ? '<span class="badge bg-secondary">Unavailable</span>' : ''}
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title">${item.name_bn}</h5>
                        <button class="btn btn-sm btn-outline-danger favorite-btn ${isFavorite ? 'active' : ''}" data-item-id="${item.id}">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    <p class="card-text text-muted small">${item.description_bn || ''}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-tag">৳${item.price}</span>
                            <button class="btn btn-primary btn-sm add-to-cart ${!isAvailable ? 'disabled' : ''}" data-item-id="${item.id}">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add event listeners
        const favoriteBtn = col.querySelector('.favorite-btn');
        const addToCartBtn = col.querySelector('.add-to-cart');
        
        favoriteBtn.addEventListener('click', () => this.toggleFavorite(item.id));
        if (isAvailable) {
            addToCartBtn.addEventListener('click', () => this.addToCart(item.id));
        }

        return col;
    }

    addToCart(itemId) {
        const item = this.findMenuItemById(itemId);
        if (!item) return;

        const existingItem = this.cart.find(cartItem => cartItem.id === itemId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push({
                id: item.id,
                name_bn: item.name_bn,
                price: item.price,
                quantity: 1
            });
        }

        this.updateCartDisplay();
        this.saveCart();
    }

    removeFromCart(itemId) {
        this.cart = this.cart.filter(item => item.id !== itemId);
        this.updateCartDisplay();
        this.saveCart();
    }

    updateQuantity(itemId, action) {
        const item = this.cart.find(cartItem => cartItem.id === itemId);
        if (!item) return;

        if (action === 'increase') {
            item.quantity += 1;
        } else if (action === 'decrease' && item.quantity > 1) {
            item.quantity -= 1;
        }

        this.updateCartDisplay();
        this.saveCart();
    }

    updateCartDisplay() {
        const cartCount = document.getElementById('cartCount');
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');

        if (cartCount) {
            const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
        }

        if (cartItems) {
            cartItems.innerHTML = '';
            this.cart.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">${item.name_bn}</h6>
                            <small class="text-muted">৳${item.price} x ${item.quantity}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary update-quantity" data-item-id="${item.id}" data-action="decrease">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary update-quantity" data-item-id="${item.id}" data-action="increase">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger remove-from-cart ms-2" data-item-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });
        }

        if (cartTotal) {
            const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `৳${total.toFixed(2)}`;
        }
    }

    toggleFavorite(itemId) {
        const index = this.favorites.indexOf(itemId);
        if (index > -1) {
            this.favorites.splice(index, 1);
        } else {
            this.favorites.push(itemId);
        }
        
        localStorage.setItem('favorites', JSON.stringify(this.favorites));
        this.loadMenuItems(); // Refresh to update favorite buttons
    }

    async handleOrderSubmit(e) {
        e.preventDefault();
        
        if (this.cart.length === 0) {
            this.showError('Your cart is empty');
            return;
        }

        const formData = new FormData(e.target);
        const orderData = {
            branch_id: this.currentBranch.id,
            table_id: formData.get('table_id') || null,
            customer_name: formData.get('customer_name'),
            customer_phone: formData.get('customer_phone'),
            payment_method: formData.get('payment_method'),
            notes: formData.get('notes'),
            order_type: formData.get('order_type') || 'dine_in',
            items: this.cart.map(item => ({
                menu_item_id: item.id,
                quantity: item.quantity,
                unit_price: item.price,
                notes: ''
            }))
        };

        // Calculate totals
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const vatAmount = subtotal * 0.15; // 15% VAT
        const serviceCharge = subtotal * 0.10; // 10% service charge
        const totalAmount = subtotal + vatAmount + serviceCharge;

        orderData.subtotal = subtotal;
        orderData.vat_amount = vatAmount;
        orderData.service_charge = serviceCharge;
        orderData.discount_amount = 0;
        orderData.total_amount = totalAmount;

        try {
            const response = await fetch(`${this.apiBase}/orders`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();
            
            if (result.success) {
                this.showSuccess('Order placed successfully!');
                this.cart = [];
                this.updateCartDisplay();
                this.saveCart();
                this.closeOrderModal();
            } else {
                this.showError(result.error || 'Failed to place order');
            }
        } catch (error) {
            console.error('Error placing order:', error);
            this.showError('Failed to place order');
        }
    }

    handleSearch(e) {
        this.loadMenuItems();
    }

    handleCategoryFilter(e) {
        this.loadMenuItems();
    }

    handleBranchChange(e) {
        const branchId = parseInt(e.target.value);
        this.currentBranch = { id: branchId };
        this.loadCategories();
        this.loadMenuItems();
    }

    findMenuItemById(itemId) {
        // This would need to be implemented to get item details
        // For now, we'll assume the item is in the cart
        return this.cart.find(item => item.id === itemId);
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
    }

    loadCart() {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            this.cart = JSON.parse(savedCart);
            this.updateCartDisplay();
        }
    }

    hideLoadingScreen() {
        const loadingScreen = document.querySelector('.loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.classList.add('hidden');
            }, 500);
        }
    }

    showError(message) {
        // Simple error notification
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    showSuccess(message) {
        // Simple success notification
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    closeOrderModal() {
        const orderModal = document.getElementById('orderModal');
        if (orderModal) {
            const modal = bootstrap.Modal.getInstance(orderModal);
            if (modal) {
                modal.hide();
            }
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.qrMenuApp = new QRMenuApp();
});