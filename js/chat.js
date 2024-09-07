document.addEventListener('DOMContentLoaded', () => {
    const chatItems = document.querySelectorAll('.chat-item');
    chatItems.forEach(item => {
        item.addEventListener('click', () => {
            window.location.href = 'chatDetail.php';
            // Implement the chat click logic
        });
    });
});
document.addEventListener('DOMContentLoaded', (event) => {
    const backButton = document.getElementById('backButton');
    
    backButton.addEventListener('click', () => {
        window.location.href = 'index.php';
    });
});
