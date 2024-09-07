function removeItem(itemId) {
    if (confirm('Are you sure you want to remove this item from the cart?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === 'success') {
                    document.querySelector(`.cart-item[data-id='${itemId}']`).remove();
                    updateTotalPrice();
                } else {
                    alert('Failed to remove item. Please try again.');
                }
            } else {
                alert('An error occurred. Please try again.');
            }
        };
        xhr.send('id=' + itemId);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Update total price on page load
    updateTotalPrice();

    // Add event listeners for checkboxes
    const checkboxes = document.querySelectorAll('.select-item');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            updateTotalPrice();
        });
    });

    // Add event listeners for quantity buttons
    const quantityButtons = document.querySelectorAll('.quantity-btn');
    quantityButtons.forEach(button => {
        button.addEventListener('click', () => {
            updateTotalPrice();
        });
    });
});

function updateQuantity(button, change) {
    const input = button.parentNode.querySelector('.quantity-input');
    let quantity = parseInt(input.value, 10) + change;
    quantity = Math.max(quantity, 1); // Ensure quantity is at least 1
    input.value = quantity;
    updateTotalPrice();
}

function updateTotalPrice() {
    const items = document.querySelectorAll('.cart-item');
    let totalPrice = 0;

    items.forEach(item => {
        const checkbox = item.querySelector('.select-item');
        if (checkbox.checked) {
            const price = parseFloat(item.getAttribute('data-price'));
            const quantity = parseInt(item.querySelector('.quantity-input').value, 10);
            totalPrice += price * quantity;
        }
    });

    document.getElementById('total-price').textContent = `IDR ${totalPrice.toLocaleString('id-ID')}`;
}

function proceedToCheckout() {
    const selectedItems = Array.from(document.querySelectorAll('.cart-item'))
        .filter(item => item.querySelector('.select-item').checked)
        .map(item => ({
            name: item.querySelector('.item-details h3').textContent,
            price: parseFloat(item.getAttribute('data-price')),
            quantity: parseInt(item.querySelector('.quantity-input').value, 10)
        }));

    if (selectedItems.length === 0) {
        alert('No items selected.');
        return;
    }

    const queryString = selectedItems.map(item => 
        `name[]=${encodeURIComponent(item.name)}&price[]=${item.price}&quantity[]=${item.quantity}`
    ).join('&');

    window.location.href = `transaction.php?${queryString}`;
}

// Calculate the total price on cart.php
function saveTotalPriceToLocalStorage(totalPrice) {
    localStorage.setItem('totalPrice', totalPrice);
}

