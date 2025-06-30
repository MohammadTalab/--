/**
 * Main JavaScript File
 * Common UI interactions and functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initBackToTop();
    initDropdowns();
    initSearchForm();
    initQuantityControls();
    initAddToCart();
    initFlashMessages();
    initMobileMenu();
    initNewsletterForm();
});

/**
 * Back to Top Button
 */
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    if (!backToTopBtn) return;

    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });

    // Smooth scroll to top when clicked
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Dropdown Menus
 */
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.user-dropdown');
    
    dropdowns.forEach(dropdown => {
        const menu = dropdown.querySelector('.dropdown-menu');
        const button = dropdown.querySelector('.user-btn');
        
        if (!menu || !button) return;
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target)) {
                menu.style.opacity = '0';
                menu.style.visibility = 'hidden';
                menu.style.transform = 'translateY(-10px)';
            }
        });
        
        // Toggle dropdown on button click
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const isVisible = menu.style.opacity === '1';
            
            if (isVisible) {
                menu.style.opacity = '0';
                menu.style.visibility = 'hidden';
                menu.style.transform = 'translateY(-10px)';
            } else {
                menu.style.opacity = '1';
                menu.style.visibility = 'visible';
                menu.style.transform = 'translateY(0)';
            }
        });
    });
}

/**
 * Search Form Enhancement
 */
function initSearchForm() {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');
    
    if (!searchForm || !searchInput) return;
    
    // Add loading state
    searchForm.addEventListener('submit', function() {
        const submitBtn = searchForm.querySelector('.search-btn');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
        }
    });
    
    // Auto-submit on Enter key
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            searchForm.submit();
        }
    });
}

/**
 * Quantity Controls
 */
function initQuantityControls() {
    const quantityControls = document.querySelectorAll('.quantity-control');
    
    quantityControls.forEach(control => {
        const input = control.querySelector('.quantity-input');
        const decreaseBtn = control.querySelector('.quantity-decrease');
        const increaseBtn = control.querySelector('.quantity-increase');
        
        if (!input || !decreaseBtn || !increaseBtn) return;
        
        // Decrease quantity
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                triggerQuantityChange(input);
            }
        });
        
        // Increase quantity
        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
            triggerQuantityChange(input);
        });
        
        // Direct input change
        input.addEventListener('change', function() {
            const value = parseInt(input.value) || 1;
            if (value < 1) {
                input.value = 1;
            }
            triggerQuantityChange(input);
        });
    });
}

/**
 * Trigger quantity change event
 */
function triggerQuantityChange(input) {
    const event = new Event('change', { bubbles: true });
    input.dispatchEvent(event);
}

/**
 * Add to Cart AJAX
 */
function initAddToCart() {
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإضافة...';
            submitBtn.disabled = true;
            
            // Send AJAX request
            fetch('/api/cart/add.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showFlashMessage('success', data.message);
                    updateCartCount(data.cartCount);
                } else {
                    showFlashMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showFlashMessage('error', 'حدث خطأ أثناء إضافة المنتج للسلة');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    });
}

/**
 * Update cart count in header
 */
function updateCartCount(count) {
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        if (count > 0) {
            cartBadge.textContent = count;
            cartBadge.style.display = 'block';
        } else {
            cartBadge.style.display = 'none';
        }
    }
}

/**
 * Flash Messages
 */
function initFlashMessages() {
    const flashMessages = document.querySelectorAll('.flash-message');
    
    flashMessages.forEach(message => {
        const closeBtn = message.querySelector('.flash-close');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    message.remove();
                }, 300);
            });
        }
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (message.parentNode) {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.remove();
                    }
                }, 300);
            }
        }, 5000);
    });
}

/**
 * Show flash message programmatically
 */
function showFlashMessage(type, message) {
    const flashContainer = document.querySelector('.main-content');
    if (!flashContainer) return;
    
    const flashMessage = document.createElement('div');
    flashMessage.className = `flash-message flash-${type}`;
    flashMessage.innerHTML = `
        <div class="container">
            <div class="flash-content">
                <span class="flash-text">${message}</span>
                <button class="flash-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    // Insert at the beginning of main content
    flashContainer.insertBefore(flashMessage, flashContainer.firstChild);
    
    // Initialize the new flash message
    initFlashMessages();
}

/**
 * Mobile Menu Toggle
 */
function initMobileMenu() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.nav');
    
    if (!mobileToggle || !nav) return;
    
    mobileToggle.addEventListener('click', function() {
        nav.classList.toggle('active');
        
        // Animate hamburger menu
        const spans = mobileToggle.querySelectorAll('span');
        spans.forEach((span, index) => {
            if (nav.classList.contains('active')) {
                if (index === 0) span.style.transform = 'rotate(45deg) translate(5px, 5px)';
                if (index === 1) span.style.opacity = '0';
                if (index === 2) span.style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                span.style.transform = 'none';
                span.style.opacity = '1';
            }
        });
    });
    
    // Close mobile menu when clicking on a link
    const navLinks = nav.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            nav.classList.remove('active');
            const spans = mobileToggle.querySelectorAll('span');
            spans.forEach(span => {
                span.style.transform = 'none';
                span.style.opacity = '1';
            });
        });
    });
}

/**
 * Newsletter Form
 */
function initNewsletterForm() {
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (!newsletterForm) return;
    
    newsletterForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = newsletterForm.querySelector('.newsletter-input').value;
        const submitBtn = newsletterForm.querySelector('.newsletter-btn');
        const originalText = submitBtn.innerHTML;
        
        // Validate email
        if (!isValidEmail(email)) {
            showFlashMessage('error', 'يرجى إدخال بريد إلكتروني صحيح');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        submitBtn.disabled = true;
        
        // Simulate API call (replace with actual endpoint)
        setTimeout(() => {
            showFlashMessage('success', 'تم الاشتراك في النشرة البريدية بنجاح!');
            newsletterForm.reset();
            
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 1000);
    });
}

/**
 * Email validation
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Smooth scrolling for anchor links
 */
function initSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Lazy loading for images
 */
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
}

/**
 * Form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(form)) {
                event.preventDefault();
            }
        });
    });
}

/**
 * Validate form fields
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'هذا الحقل مطلوب');
            isValid = false;
        } else {
            clearFieldError(field);
        }
        
        // Email validation
        if (field.type === 'email' && field.value.trim()) {
            if (!isValidEmail(field.value)) {
                showFieldError(field, 'يرجى إدخال بريد إلكتروني صحيح');
                isValid = false;
            }
        }
    });
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
}

/**
 * Initialize all components when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    initSmoothScrolling();
    initLazyLoading();
    initFormValidation();
});

/**
 * Utility function to debounce function calls
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Utility function to throttle function calls
 */
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
} 