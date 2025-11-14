// Simple filter system
document.addEventListener('DOMContentLoaded', function() {
    // Price slider
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const maxPrice = document.getElementById('maxPrice');

    priceRange.addEventListener('input', function() {
        priceValue.textContent = this.value;
        maxPrice.value = this.value;
    });

    maxPrice.addEventListener('input', function() {
        priceRange.value = this.value;
        priceValue.textContent = this.value;
    });
});

// Filter products function
function filterProducts() {
    console.log('Filter button clicked');
    
    // Get filter values
    const categorySelect = document.getElementById('categoryFilter');
    const modelSelect = document.getElementById('modelFilter');
    const stockSelect = document.getElementById('stockFilter');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    
    const selectedCategory = categorySelect.value;
    const selectedModel = modelSelect.value;
    const selectedStock = stockSelect.value;
    const minPrice = parseInt(minPriceInput.value) || 0;
    const maxPrice = parseInt(maxPriceInput.value) || 999999;
    
    console.log('Filters:', {selectedCategory, selectedModel, selectedStock, minPrice, maxPrice});
    
    // Get category and model text
    const categoryText = selectedCategory ? categorySelect.options[categorySelect.selectedIndex].text : '';
    const modelText = selectedModel ? modelSelect.options[modelSelect.selectedIndex].text : '';
    
    console.log('Filter texts:', {categoryText, modelText});
    
    // Get all product cards
    const productCards = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    productCards.forEach(function(card) {
        let showCard = true;
        
        // Get product data from card
        const productCategory = card.querySelector('.product-meta span:first-child').textContent;
        const productModel = card.querySelector('.product-meta span:last-child').textContent;
        const productPriceText = card.querySelector('.product-price').textContent.replace('₹', '').replace(/,/g, '');
        const productPrice = parseFloat(productPriceText);
        const stockBadge = card.querySelector('.stock-badge');
        const stockText = stockBadge ? stockBadge.textContent.toLowerCase() : '';
        
        console.log('Product:', {productCategory, productModel, productPrice, stockText});
        
        // Apply category filter
        if (selectedCategory && categoryText !== productCategory) {
            showCard = false;
            console.log('Category filter failed');
        }
        
        // Apply model filter
        if (selectedModel && modelText !== productModel) {
            showCard = false;
            console.log('Model filter failed');
        }
        
        // Apply price filter
        if (productPrice < minPrice || productPrice > maxPrice) {
            showCard = false;
            console.log('Price filter failed');
        }
        
        // Apply stock filter
        if (selectedStock === 'in_stock' && !stockText.includes('in stock')) {
            showCard = false;
            console.log('Stock filter failed - in stock');
        }
        if (selectedStock === 'low_stock' && !stockText.includes('low stock')) {
            showCard = false;
            console.log('Stock filter failed - low stock');
        }
        
        // Show or hide the card
        if (showCard) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    console.log('Total visible products:', visibleCount);
    
    // Hide empty category sections
    const categorySections = document.querySelectorAll('.category-section');
    categorySections.forEach(function(section) {
        const visibleCards = section.querySelectorAll('.product-card:not([style*="none"])');
        if (visibleCards.length > 0) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}

// Clear all filters
function clearFilters() {
    console.log('Clear button clicked');
    
    // Reset all form elements
    document.getElementById('categoryFilter').value = '';
    document.getElementById('modelFilter').value = '';
    document.getElementById('stockFilter').value = '';
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '50000';
    document.getElementById('priceRange').value = '50000';
    document.getElementById('priceValue').textContent = '50000';
    
    // Show all products
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(function(card) {
        card.style.display = 'block';
    });
    
    // Show all category sections
    const categorySections = document.querySelectorAll('.category-section');
    categorySections.forEach(function(section) {
        section.style.display = 'block';
    });
    
    console.log('Filters cleared');
}

// Sort products
function sortProducts() {
    const sortBy = document.getElementById('sortBy').value;
    const categorySections = document.querySelectorAll('.category-section');
    
    categorySections.forEach(function(section) {
        const productsGrid = section.querySelector('.products-grid');
        const productCards = Array.from(productsGrid.querySelectorAll('.product-card'));
        
        productCards.sort(function(a, b) {
            const nameA = a.querySelector('.product-title').textContent;
            const nameB = b.querySelector('.product-title').textContent;
            const priceA = parseFloat(a.querySelector('.product-price').textContent.replace('₹', '').replace(/,/g, ''));
            const priceB = parseFloat(b.querySelector('.product-price').textContent.replace('₹', '').replace(/,/g, ''));
            
            switch(sortBy) {
                case 'name_asc':
                    return nameA.localeCompare(nameB);
                case 'name_desc':
                    return nameB.localeCompare(nameA);
                case 'price_asc':
                    return priceA - priceB;
                case 'price_desc':
                    return priceB - priceA;
                default:
                    return 0;
            }
        });
        
        productCards.forEach(function(card) {
            productsGrid.appendChild(card);
        });
    });
}

// Add sort event listener
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sortBy');
    if (sortSelect) {
        sortSelect.addEventListener('change', sortProducts);
    }
});

// Product actions
function addToCart(productId) {
    console.log('addToCart function called with productId:', productId);
    
    if (!productId) {
        console.error('No product ID provided');
        return;
    }
    
    // Check if user is logged in
    fetch('check-login.php')
    .then(response => {
        console.log('Login check response:', response);
        return response.json();
    })
    .then(loginData => {
        console.log('Login data:', loginData);
        if (!loginData.logged_in) {
            alert('Please login to add items to cart');
            window.location.href = 'login.php';
            return;
        }
        
        console.log('User is logged in, adding to cart...');
        // User is logged in, proceed with adding to cart
        return fetch('cart-actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=add&product_id=' + productId
        });
    })
    .then(response => {
        if (!response) return;
        console.log('Cart action response:', response);
        return response.json();
    })
    .then(data => {
        if (!data) return;
        console.log('Cart action data:', data);
        if (data.success) {
            alert('Product added to cart!');
            // Update header counts
            updateCartCount(data.cart_count);
            if (typeof updateHeaderCounts === 'function') {
                updateHeaderCounts();
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error in addToCart:', error);
        alert('Failed to add product to cart');
    });
}

function addToWishlist(productId) {
    // Check if user is logged in
    fetch('check-login.php')
    .then(response => response.json())
    .then(loginData => {
        if (!loginData.logged_in) {
            if (confirm('You need to login to add items to wishlist. Go to login page?')) {
                window.location.href = 'login.php';
            }
            return;
        }
        
        // User is logged in, proceed with adding to wishlist
        fetch('wishlist-actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=add&product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Success', data.message, 'success');
                // Update header counts immediately
                updateWishlistCount(data.wishlist_count);
                // Also try the header function if available
                setTimeout(() => {
                    if (typeof updateHeaderCounts === 'function') {
                        updateHeaderCounts();
                    }
                }, 100);
            } else {
                showToast('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error', 'Failed to add product to wishlist', 'error');
        });
    });
}

function inquireProduct(productId) {
    window.location.href = 'inquiry.php?product_id=' + productId;
}

// Toast notification function
function showToast(title, message, type = 'success') {
    const toastElement = document.getElementById('actionToast');
    const toastHeader = toastElement.querySelector('.toast-header strong');
    const toastBody = document.getElementById('toastMessage');
    const toastIcon = toastElement.querySelector('.toast-header i');
    
    toastHeader.textContent = title;
    toastBody.textContent = message;
    
    toastIcon.className = type === 'success' ? 'fas fa-check-circle text-success me-2' : 'fas fa-exclamation-triangle text-danger me-2';
    
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
}

// Update counters
function updateCartCount(count) {
    const cartBadge = document.getElementById('cartCount');
    if (cartBadge) {
        cartBadge.textContent = count || 0;
    }
}

function updateWishlistCount(count) {
    const wishlistBadge = document.getElementById('wishlistCount');
    if (wishlistBadge) {
        wishlistBadge.textContent = count || 0;
    }
}

function viewProductDetails(productId) {
    // Show loading in modal
    const modalBody = document.getElementById('modalBody');
    modalBody.innerHTML = '<div class="text-center p-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading product details...</p></div>';
    
    // Show the modal
    const productModal = new bootstrap.Modal(document.getElementById('productModal'));
    productModal.show();
    
    // Fetch product details via AJAX
    fetch('product-details.php?id=' + productId)
        .then(response => response.text())
        .then(data => {
            modalBody.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = '<div class="text-center p-4 text-danger"><i class="fas fa-exclamation-triangle"></i><p class="mt-2">Error loading product details. Please try again.</p></div>';
        });
}