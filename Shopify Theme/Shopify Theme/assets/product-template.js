document.addEventListener('DOMContentLoaded', () => {
  class ProductTemplate {
    constructor(container) {
      this.container = container;
      this.mainImage = container.querySelector('#ProductMainImage');
      this.thumbnails = container.querySelectorAll('.product-template__thumbnail');
      this.variantSelect = container.querySelector('#ProductSelect');
      this.tabHeaders = container.querySelectorAll('.product-tabs__header');
      this.tabPanels = container.querySelectorAll('.product-tabs__panel');
      
      this.init();
    }

    init() {
      this.setupImageGallery();
      this.setupTabs();
      this.setupVariantSelection();
    }

    setupImageGallery() {
      this.thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
          const newSrc = thumbnail.querySelector('img').src.replace('150x', '800x');
          this.mainImage.src = newSrc;
          
          // Update active state
          this.thumbnails.forEach(thumb => thumb.classList.remove('active'));
          thumbnail.classList.add('active');
        });
      });
    }

    setupTabs() {
      this.tabHeaders.forEach(header => {
        header.addEventListener('click', () => {
          const tabId = header.getAttribute('data-tab');
          
          // Update active states
          this.tabHeaders.forEach(h => h.classList.remove('active'));
          this.tabPanels.forEach(p => p.classList.remove('active'));
          
          header.classList.add('active');
          this.container.querySelector(`[data-tab-content="${tabId}"]`).classList.add('active');
        });
      });
    }

    setupVariantSelection() {
      if (!this.variantSelect) return;

      this.variantSelect.addEventListener('change', () => {
        const selectedOption = this.variantSelect.options[this.variantSelect.selectedIndex];
        const variantPrice = selectedOption.textContent.split(' - ')[1];
        
        // Update price display
        const priceElement = this.container.querySelector('.product-template__current-price');
        if (priceElement) {
          priceElement.textContent = variantPrice;
        }

        // Update add to cart button state
        const addToCartButton = this.container.querySelector('.product-template__add-to-cart');
        if (addToCartButton) {
          const variantAvailable = !selectedOption.disabled;
          addToCartButton.disabled = !variantAvailable;
          addToCartButton.textContent = variantAvailable ? 'Add to Cart' : 'Sold Out';
        }
      });
    }
  }

  // Initialize all product templates on the page
  document.querySelectorAll('.product-template').forEach(template => {
    new ProductTemplate(template);
  });
});