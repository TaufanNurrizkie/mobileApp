document.addEventListener('DOMContentLoaded', () => {
    // Generate a dummy order ID for demo purposes
    const orderId = 'ORD-' + Math.floor(Math.random() * 1000000);
    
    // Get total price and address from localStorage
    const totalPrice = localStorage.getItem('totalPrice') || 'IDR 0';
    const shippingAddress = localStorage.getItem('shippingAddress') || 'Not provided';

    // Update the page with order details
    document.getElementById('order-id').textContent = orderId;
    document.getElementById('transaction-total').textContent = totalPrice;
    document.getElementById('shipping-address').textContent = shippingAddress;

    // Event listeners for buttons
    document.getElementById('view-orders').addEventListener('click', () => {
        window.location.href = 'order-history.html'; // Adjust the path if needed
    });

    document.getElementById('continue-shopping').addEventListener('click', () => {
        window.location.href = 'main.php'; // Adjust the path if needed
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const orderId = 'ORD-' + Math.floor(Math.random() * 1000000);
    const totalPrice = localStorage.getItem('totalPrice') || 'IDR 0';
    const shippingAddress = localStorage.getItem('shippingAddress') || 'Not provided';
    const items = JSON.parse(localStorage.getItem('items')) || [];

    // Add order to localStorage orders list
    const orders = JSON.parse(localStorage.getItem('orders')) || [];
    orders.push({
        id: orderId,
        totalPrice: totalPrice,
        shippingAddress: shippingAddress,
        paymentMethod: 'credit-card', // This should be dynamic based on user's choice
        items: items,
        status: 'Pending' // Initial status
    });
    localStorage.setItem('orders', JSON.stringify(orders));

    // Existing code to display order summary
    document.getElementById('order-id').textContent = orderId;
    document.getElementById('transaction-total').textContent = totalPrice;
    document.getElementById('shipping-address').textContent = shippingAddress;
    const itemListContainer = document.getElementById('item-list-container');
    items.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'item';
        itemDiv.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div>
                <p>${item.name}</p>
                <p>Price: ${item.price}</p>
                <p>Quantity: ${item.quantity}</p>
            </div>
        `;
        itemListContainer.appendChild(itemDiv);
    });

    document.getElementById('view-orders').addEventListener('click', () => {
        window.location.href = 'track-order.php';
    });

    document.getElementById('continue-shopping').addEventListener('click', () => {
        window.location.href = 'main.php';
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const bayarButton = document.getElementById('bayar');
    const modal = document.getElementById('payment-modal');
    const closeModalButton = document.getElementById('close-modal');
    const confirmPaymentButton = document.getElementById('confirm-payment');

    bayarButton.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    confirmPaymentButton.addEventListener('click', () => {
        const passwordInput = document.getElementById('password-input').value;
        if (passwordInput === "yourpassword") {  // Replace "yourpassword" with actual password validation
            window.location.href = 'success.php';
        } else {
            alert('Incorrect password. Please try again.');
        }
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});

// modal.js

// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("passwordModal");
    var btn = document.getElementById("bayar");
    var span = document.getElementsByClassName("close")[0];
    var form = document.getElementById("passwordForm");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        // Handle the password validation here, e.g., AJAX request to validate the password
        alert("Password submitted. Implement validation logic here.");
        modal.style.display = "none";
    }
});



