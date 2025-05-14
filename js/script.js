// Get DOM elements
const buttonOpen = document.getElementById("form-tambah");
const buttonClose = document.getElementById("form-close");
const form = document.getElementById("tambah-produk");
let isFormOpen = false; // Track form state

// Initialize event listeners
if (buttonOpen && buttonClose && form) {
    // Open form button
    buttonOpen.addEventListener("click", () => {
        openForm();
    });

    // Close form button
    buttonClose.addEventListener("click", () => {
        closeForm();
    });
}

// Function to open form with overlay
function openForm() {
    if (!isFormOpen) {
        form.classList.add("open");
        createOverlay();
        isFormOpen = true;
    }
}

// Function to close form and remove overlay
function closeForm() {
    if (isFormOpen) {
        form.classList.remove("open");
        removeOverlay();
        isFormOpen = false;
    }
}

// Function to create overlay
function createOverlay() {
    // Remove any existing overlay first to prevent duplicates
    removeOverlay();
    
    const overlay = document.createElement("div");
    overlay.className = "overlay";
    document.body.appendChild(overlay);
    document.body.classList.add("blur-background");
    
    // Close form when clicking overlay
    overlay.addEventListener("click", () => {
        closeForm();
    });
}

// Function to remove overlay
function removeOverlay() {
    const overlay = document.querySelector(".overlay");
    if (overlay) {
        overlay.remove();
    }
    document.body.classList.remove("blur-background");
}

// Toggle blur function for the Add Product button
function toggleBlur() {
    if (isFormOpen) {
        closeForm();
    } else {
        openForm();
    }
}

//carousel
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.carousel');
    const items = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.indicator');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');

    if (!carousel || items.length === 0) {
        console.log("Carousel elements not found");
        return;
    }
    
    let currentIndex = 0;
    const totalItems = items.length;
    
    // Function to update carousel position
    function updateCarousel() {
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        // Update active indicator
        indicators.forEach((indicator, index) => {
            if (index === currentIndex) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Previous button click
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalItems - 1;
            updateCarousel();
        });
    }
    
    // Next button click
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            currentIndex = (currentIndex < totalItems - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        });
    }
    
    // Indicator clicks
    indicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            currentIndex = parseInt(this.getAttribute('data-index'));
            updateCarousel();
        });
    });
    
    // Auto slide every 3 seconds
    let autoSlide = setInterval(function() {
        currentIndex = (currentIndex < totalItems - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    }, 3000);
    
    // Pause auto slide when hovering over carousel
    carousel.addEventListener('mouseenter', function() {
        clearInterval(autoSlide);
    });
    
    // Resume auto slide when mouse leaves carousel
    carousel.addEventListener('mouseleave', function() {
        autoSlide = setInterval(function() {
            currentIndex = (currentIndex < totalItems - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        }, 3000);
    });
    
    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    carousel.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        // Detect direction of swipe and change slide accordingly
        if (touchEndX < touchStartX - 50) {
            // Swipe left - next slide
            currentIndex = (currentIndex < totalItems - 1) ? currentIndex + 1 : 0;
            updateCarousel();
        } else if (touchEndX > touchStartX + 50) {
            // Swipe right - previous slide
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalItems - 1;
            updateCarousel();
        }
    }
});

// Handle notifications
const notification = document.querySelector('.notification');
if (notification) {
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}