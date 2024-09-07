<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="content" id="content">
        <!-- Dynamic content will be loaded here -->
    </div>
    
    <div class="bottom-bar">
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('track_order.php')">
                <img src="img/truckLogo.png" alt="Track Order">
                <span>Trace</span>
            </a>
        </div>
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('product.php')">
                <img src="img/homeLogo.png" alt="Home">
                <span>Beranda</span>
            </a>
        </div>
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('notifications.php')">
                <img src="img/notifLogo.png" alt="Notifications">
                <span>Notif</span>
            </a>
        </div>
    </div>
    
 
    <script>
    function loadPage(page) {
        const contentElement = document.getElementById('content');
        
        // Tambahkan kelas untuk memulai fade-out
        contentElement.classList.remove('loaded');
        
        fetch(page)
            .then(response => response.text())
            .then(data => {
                // Tunggu transisi fade-out selesai sebelum mengganti konten
                setTimeout(() => {
                    contentElement.innerHTML = data;
                    
                    // Tambahkan kelas untuk fade-in konten baru
                    contentElement.classList.add('loaded');
                }, 500); // Waktu delay harus sama dengan durasi transisi fade-out
            })
            .catch(error => console.error('Error loading page:', error));
    }

    window.onload = function() {
        loadPage('product.php');
    };



    let currentSlide = 0;
const slideInterval = 3000; // Time in milliseconds (e.g., 3000ms = 3 seconds)

function moveSlide(step) {
    const slides = document.querySelectorAll('.carousel-images img');
    const totalSlides = slides.length;
    currentSlide = (currentSlide + step + totalSlides) % totalSlides;
    const offset = -currentSlide * 100;
    document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;
}

// Function to automatically move to the next slide
function autoSlide() {
    moveSlide(1); // Move to the next slide
}

// Set up automatic sliding
let autoSlideInterval = setInterval(autoSlide, slideInterval);

// Optional: Reset the interval if the user interacts with the carousel (e.g., using controls)
document.querySelectorAll('.carousel-control').forEach(button => {
    button.addEventListener('click', () => {
        clearInterval(autoSlideInterval); // Stop automatic sliding
        autoSlideInterval = setInterval(autoSlide, slideInterval); // Restart the interval
    });
});


</script>

</body>
</html>
