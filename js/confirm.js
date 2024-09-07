document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('confirm-form');
    const passwordInput = document.getElementById('password-input');
    const orderId = document.getElementById('order-id');
    const totalPrice = document.getElementById('total-price');
    const itemName = document.getElementById('item-name');

    // Ambil data dari sessionStorage
    orderId.value = sessionStorage.getItem('orderId');
    totalPrice.value = sessionStorage.getItem('totalPrice');
    itemName.value = sessionStorage.getItem('itemName');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (passwordInput.value === "123") {  // Password validation
            window.location.href = `succes.php?order_id=${encodeURIComponent(orderId.value)}&total_price=${encodeURIComponent(totalPrice.value)}&item_name=${encodeURIComponent(itemName.value)}`;
        } else {
            alert('Incorrect password. Please try again.');
        }
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const backButton = document.getElementById('backButton');
    
    backButton.addEventListener('click', () => {
        window.location.href = 'transaction.php';
    });
});