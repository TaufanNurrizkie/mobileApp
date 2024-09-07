document.addEventListener('DOMContentLoaded', () => {
    const addToCartButton = document.querySelector('.add-cart');
    const buyNowButton = document.querySelector('.buy-now');
    
    if (addToCartButton) {
        addToCartButton.addEventListener('click', () => {
            const productId = new URLSearchParams(window.location.search).get('id');
            
            if (productId) {
                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': productId
                    })
                })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('Product ID is missing.');
            }
        });
    }

    if (buyNowButton) {
        buyNowButton.addEventListener('click', () => {
            const productId = new URLSearchParams(window.location.search).get('id');
            
            if (productId) {
                fetch('buy-now.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': productId
                    })
                })
                .then(response => response.text())
                .then(result => {
                    window.location.href = 'cart.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('Product ID is missing.');
            }
        });
    }
});
