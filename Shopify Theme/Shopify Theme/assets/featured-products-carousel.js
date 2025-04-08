document.addEventListener('DOMContentLoaded', () => {
  class FeaturedProductsCarousel {
    constructor(container) {
      this.container = container;
      this.wrapper = container.querySelector('.carousel-wrapper');
      this.items = container.querySelectorAll('.carousel-item');
      this.prevButton = container.querySelector('.carousel-control--prev');
      this.nextButton = container.querySelector('.carousel-control--next');
      this.currentIndex = 0;
      this.autoplay = this.wrapper.dataset.autoplay === 'true';
      this.autoplayInterval = null;
      
      this.init();
    }

    init() {
      this.setupEventListeners();
      if (this.autoplay) {
        this.startAutoplay();
      }
      this.updateAriaLabels();
    }

    setupEventListeners() {
      this.prevButton.addEventListener('click', () => this.navigate('prev'));
      this.nextButton.addEventListener('click', () => this.navigate('next'));
      
      this.container.addEventListener('mouseenter', () => this.stopAutoplay());
      this.container.addEventListener('mouseleave', () => {
        if (this.autoplay) {
          this.startAutoplay();
        }
      });

      // Touch events support
      let touchStartX = 0;
      let touchEndX = 0;

      this.wrapper.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
      });

      this.wrapper.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].clientX;
        this.handleSwipe(touchStartX, touchEndX);
      });
    }

    handleSwipe(startX, endX) {
      const swipeThreshold = 50;
      const diff = startX - endX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          this.navigate('next');
        } else {
          this.navigate('prev');
        }
      }
    }

    navigate(direction) {
      this.items[this.currentIndex].classList.remove('active');
      
      if (direction === 'next') {
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
      } else {
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
      }

      this.items[this.currentIndex].classList.add('active');
      this.updateAriaLabels();
    }

    startAutoplay() {
      if (this.autoplayInterval) return;
      
      this.autoplayInterval = setInterval(() => {
        this.navigate('next');
      }, 5000);
    }

    stopAutoplay() {
      if (this.autoplayInterval) {
        clearInterval(this.autoplayInterval);
        this.autoplayInterval = null;
      }
    }

    updateAriaLabels() {
      this.items.forEach((item, index) => {
        const isActive = index === this.currentIndex;
        item.setAttribute('aria-hidden', !isActive);
      });
    }
  }

  // Initialize all carousels on the page
  document.querySelectorAll('.featured-products-carousel').forEach(carousel => {
    new FeaturedProductsCarousel(carousel);
  });
});