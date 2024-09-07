document.addEventListener('DOMContentLoaded', () => {
    // Simulate order data
    const order = {
        resiNumber: '1234567890',
        status: 'Pengiriman'
    };

    // Update resi number
    document.getElementById('resi-number').textContent = order.resiNumber;

    // Update status icons
    const statusElements = {
        'Pesanan Dibuat': 'ordered-status',
        'Dikemas': 'packed-status',
        'Pengiriman': 'shipping-status',
        'Terkirim': 'delivered-status'
    };

    let statusReached = false;
    Object.keys(statusElements).forEach(status => {
        const element = document.getElementById(statusElements[status]);
        const iconElement = element.querySelector('.status-icon');

        if (status === order.status) {
            iconElement.style.border = '2px solid blue'; // Current status border color
            statusReached = true;
        } else if (!statusReached) {
            iconElement.style.backgroundColor = 'lightblue'; // Completed status color
        }
    });

    // Cancel order
    document.querySelector('.cancel-button').addEventListener('click', () => {
        alert('Pesanan dibatalkan.');
        // Implement cancel order logic
    });
});

document.getElementById('backButton').addEventListener('click', () => {
    window.location.href = 'index.php';
});