function validatePassword() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    
    if (password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('كلمات المرور غير متطابقة');
    } else {
        confirmPassword.setCustomValidity('');
    }
}

function animateCart() {
    const cartLink = document.querySelector('a[href="cart.php"]');
    if (cartLink) {
        cartLink.classList.add('cart-shake');
        setTimeout(() => {
            cartLink.classList.remove('cart-shake');
        }, 500);
    }
}

function showNotification(message) {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => {
        notification.remove();
    });
    
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `✓ ${message}`;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateY(10px)';
    }, 10);
    
    setTimeout(() => {
        notification.style.transform = 'translateY(0)';
    }, 50);
    
    setTimeout(() => {
        notification.classList.add('hide');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 500);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('form');
    if (registerForm && window.location.href.includes('register.php')) {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');
        
        if (password && confirmPassword) {
            password.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
            
            registerForm.addEventListener('submit', function(event) {
                if (password.value !== confirmPassword.value) {
                    event.preventDefault();
                    alert('كلمات المرور غير متطابقة');
                }
            });
        }
    }
    
    if (window.location.href.includes('about.php')) {
        const teamMembers = document.querySelectorAll('.team-member');
        
        teamMembers.forEach(member => {
            const img = member.querySelector('img');
            if (img) {
                img.addEventListener('click', function() {
                    this.classList.toggle('enlarged');
                    if (this.classList.contains('enlarged')) {
                        this.style.transform = 'scale(1.2)';
                        this.style.cursor = 'zoom-out';
                    } else {
                        this.style.transform = '';
                        this.style.cursor = 'zoom-in';
                    }
                });
                
                img.style.cursor = 'zoom-in';
            }
        });
        
        const missionSection = document.querySelector('.mission-section');
        if (missionSection) {
            window.addEventListener('scroll', function() {
                const sectionPosition = missionSection.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (sectionPosition < screenPosition) {
                    missionSection.style.opacity = '1';
                    missionSection.style.transform = 'translateY(0)';
                }
            });
            
            missionSection.style.opacity = '0';
            missionSection.style.transform = 'translateY(20px)';
            missionSection.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                window.dispatchEvent(new Event('scroll'));
            }, 100);
        }
    }

    // تحسينات إضافية للتفاعلية

    // تأثير سلس للتمرير
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // تأثير عند إضافة منتج للسلة
    const addToCartButtons = document.querySelectorAll('button[name="add_to_cart"]');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // إضافة تأثير بصري
            this.style.transform = 'scale(0.95)';
            const originalText = this.innerHTML;
            this.innerHTML = '🔄 جاري الإضافة...';

            setTimeout(() => {
                this.style.transform = 'scale(1)';
                this.innerHTML = originalText;
            }, 1000);
        });
    });

    // تأثير hover للبطاقات
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // تحسين تجربة النماذج
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (this.parentElement) {
                this.parentElement.style.transform = 'scale(1.02)';
            }
        });

        input.addEventListener('blur', function() {
            if (this.parentElement) {
                this.parentElement.style.transform = 'scale(1)';
            }
        });
    });

    // تأثير للوجو
    const logo = document.querySelector('.logo-img');
    if (logo) {
        logo.addEventListener('click', function() {
            this.style.animation = 'spin 0.5s ease-in-out';
            setTimeout(() => {
                this.style.animation = '';
            }, 500);
        });
    }

    console.log('🌟 مرحباً بك في متجر خير بلادك! 🇵🇸');
});
