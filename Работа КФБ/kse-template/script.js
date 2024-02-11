$(document).ready(function(){
    const carouselSlide = document.querySelector('.carousel-slide');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const carouselDots = document.querySelector('.carousel-dots');
    const carousel = document.querySelector('.carousel-container');
    const carouselPrev = document.querySelector('.carousel-prev');
    const carouselNext = document.querySelector('.carousel-next');
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;
    

    // Create dots
    for (let i = 0; i < carouselItems.length; i++) {
        const dot = document.createElement('div');
        dot.classList.add('carousel-dot');
        if (i === 0) {
            dot.classList.add('active');
        }
        dot.addEventListener('click', () => {
            goToSlide(i);
            stopCarousel()
        });
        carouselDots.appendChild(dot);
    }
    const dots = document.querySelectorAll('.carousel-dot');
    let slideIndex = 0;
    let interval;
    
    // Start autoplay
    function startCarousel() {
                interval = setInterval(() => {
                    slideIndex++;
                    if (slideIndex >= carouselItems.length) {
                        slideIndex = 0;
                    }
                    goToSlide(slideIndex);
                }, 8000);
    }
    // Stop autoplay
    function stopCarousel() {
        clearInterval(interval);
        startCarousel()
    }
    // Go to a specific slide
    function goToSlide(index) {
        carouselSlide.style.transform = `translateX(-${index * 100 / carouselItems.length}%)`;
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        slideIndex = index;
    }

    // Previous slide button
    carouselPrev.addEventListener('click', () => {
        slideIndex--;
        if (slideIndex < 0) {
            slideIndex = carouselItems.length - 1;
        }
        goToSlide(slideIndex);
        stopCarousel();
    });
    
    // Next slide button
    carouselNext.addEventListener('click', () => {
        slideIndex++;
        if (slideIndex >= carouselItems.length) {
            slideIndex = 0;
        }
        goToSlide(slideIndex);
        stopCarousel();
    });

    // Touch events
    carouselSlide.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY
    });

    carouselSlide.addEventListener('touchmove', e => {
        let styy = 0;
        let enyy = 0;
        carouselSlide.addEventListener('touchstart', tt => {
            styy = tt.touches[0].clientY
        });
        carouselSlide.addEventListener('touchend', yy => {
            enyy = yy.changedTouches[0].clientY
        })
        if (styy != enyy) {
            e.preventDefault()
        }
    });

    carouselSlide.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].clientX;
        touchEndY = e.changedTouches[0].clientY
        if (touchStartY == touchEndY) {
        if (touchEndX < touchStartX && touchStartX - touchEndX > 100) {
            slideIndex++;
            if (slideIndex >= carouselItems.length) {
                slideIndex = 0;
            }
        } else if (touchEndX > touchStartX && touchEndX-touchStartX > 100) {
            slideIndex--;
            if (slideIndex < 0) {
                slideIndex = carouselItems.length - 1;
            }
        }
    } else {
        e.preventDefault()
    }
        goToSlide(slideIndex);
        stopCarousel();
    });
   
    
    startCarousel();


    
});
