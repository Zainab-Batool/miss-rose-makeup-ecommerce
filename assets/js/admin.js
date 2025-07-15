// Product management functions
function editProduct(id) {
    fetch(`get_product.php?id=${id}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('edit_product_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_description').value = product.description;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_category_id').value = product.category_id;
            document.getElementById('edit_stock').value = product.stock;
            
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        });
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="${id}">
        `;
        document.body.append(form);
        form.submit();
    }
}

// User management functions
function editUser(id) {
    fetch(`get_user.php?id=${id}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_is_admin').checked = user.is_admin == 1;
            
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="${id}">
        `;
        document.body.append(form);
        form.submit();
    }
}

// Order management functions
function updateStatus(orderId) {
    document.getElementById('status_order_id').value = orderId;
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}

function viewOrder(orderId) {
    window.location.href = `order-details.php?id=${orderId}`;
}
