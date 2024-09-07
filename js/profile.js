document.addEventListener('DOMContentLoaded', () => {
    const menuMappings = {
        'history-button': 'history.php',
        'voucher-button': 'voucher.php',
        'list-item-button': 'list-item.php',
        'input-item-button': 'add-item.php',
        'maps-button': 'maps.php',
        'trace-button': 'track_order.php',
        'message-button': 'chat.php',
        'notification-button': 'notification.php',
        'cart-button': 'cart.php',
        'help-button': 'help.php',
        'rating-button': 'rating.php',
        'logout-button': 'login.php'
    };

    Object.keys(menuMappings).forEach(buttonId => {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', () => {
                window.location.href = menuMappings[buttonId];
            });
        }
    });
});
