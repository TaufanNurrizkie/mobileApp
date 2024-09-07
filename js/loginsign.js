document.querySelectorAll('.submit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const container = this.closest('.container');
        container.classList.add('hide');
        setTimeout(() => {
            // Redirect or perform the login/sign-in action here
            alert('Login/Sign In process triggered!');
        }, 300); // Match the transition duration in the CSS
    });
});
