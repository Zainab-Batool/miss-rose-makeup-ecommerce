// Add to cart functionality
function addToCart(productId) {
    const quantity = document.querySelector('#quantity').value;
    fetch('/pages/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart!');
            updateCartCount(data.cartCount);
        } else {
            alert('Error adding product to cart');
        }
    });
}

// Update cart count in navbar
function updateCartCount(count) {
    const cartCount = document.querySelector('#cart-count');
    if (cartCount) {
        cartCount.textContent = count;
    }
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    return isValid;
}
