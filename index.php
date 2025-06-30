<?php
/**
 * Home Page
 * Main landing page for the e-commerce site
 */

// Page configuration
$page_title = 'الرئيسية - ' . APP_NAME;
$page_description = 'مرحباً بكم في متجر خير بلادك - أفضل المنتجات المحلية والعالمية بأسعار منافسة وجودة عالية';

// Include required files
require_once 'config/config.php';
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Cart.php';

// Initialize models
$productModel = new Product();
$categoryModel = new Category();

// Get featured products
$featuredProducts = $productModel->getFeatured(6);

// Get categories with product count
$categories = $categoryModel->getWithProductCount();

// Handle add to cart form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isLoggedIn()) {
        setFlashMessage('error', 'يجب تسجيل الدخول أولاً لإضافة المنتجات للسلة');
        redirect('/login.php');
    }
    
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'خطأ في التحقق من الأمان');
        redirect('/');
    }
    
    try {
        $cart = new Cart();
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if ($productId <= 0 || $quantity <= 0) {
            throw new Exception('بيانات غير صحيحة');
        }
        
        $cart->addItem($_SESSION['user_id'], $productId, $quantity);
        setFlashMessage('success', 'تم إضافة المنتج للسلة بنجاح');
        
    } catch (Exception $e) {
        setFlashMessage('error', $e->getMessage());
    }
    
    redirect('/');
}

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">مرحباً بكم في متجر خير بلادك</h1>
                <p class="hero-description">
                    وجهتك الأولى للتسوق الإلكتروني. نقدم أفضل المنتجات المحلية والعالمية 
                    بأسعار منافسة وجودة عالية مع خدمة عملاء مميزة.
                </p>
                <div class="hero-actions">
                    <a href="/products.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag"></i>
                        تصفح المنتجات
                    </a>
                    <a href="/categories.php" class="btn btn-outline btn-lg">
                        <i class="fas fa-th-large"></i>
                        استكشف الفئات
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="/assets/images/hero-image.jpg" alt="متجر خير بلادك" class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">فئات المنتجات</h2>
            <p class="section-description">اكتشف مجموعتنا المتنوعة من المنتجات عالية الجودة</p>
        </div>
        
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <div class="category-image">
                    <img src="<?php echo getFileUrl($category['img'], 'categories'); ?>" 
                         alt="<?php echo e($category['name']); ?>" 
                         class="category-img">
                </div>
                <div class="category-content">
                    <h3 class="category-name"><?php echo e($category['name']); ?></h3>
                    <p class="category-description"><?php echo e($category['description']); ?></p>
                    <div class="category-meta">
                        <span class="product-count"><?php echo $category['product_count']; ?> منتج</span>
                    </div>
                    <a href="/products.php?category=<?php echo $category['c_id']; ?>" class="category-link">
                        تصفح الفئة
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">منتجات مميزة</h2>
            <p class="section-description">أحدث وأفضل المنتجات المختارة خصيصاً لك</p>
        </div>
        
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo getFileUrl($product['img']); ?>" 
                         alt="<?php echo e($product['name']); ?>" 
                         class="product-img">
                    <div class="product-overlay">
                        <a href="/product.php?id=<?php echo $product['p_id']; ?>" class="product-link">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content">
                    <div class="product-category"><?php echo e($product['category_name']); ?></div>
                    <h3 class="product-name"><?php echo e($product['name']); ?></h3>
                    <p class="product-description">
                        <?php echo e(substr($product['description'], 0, 100)); ?>...
                    </p>
                    <div class="product-price"><?php echo formatPrice($product['price']); ?></div>
                    
                    <?php if (isLoggedIn()): ?>
                    <form method="post" class="add-to-cart-form">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                            <i class="fas fa-cart-plus"></i>
                            إضافة للسلة
                        </button>
                    </form>
                    <?php else: ?>
                    <a href="/login.php" class="btn btn-secondary btn-sm">
                        <i class="fas fa-sign-in-alt"></i>
                        تسجيل دخول للشراء
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-footer">
            <a href="/products.php" class="btn btn-outline">
                عرض جميع المنتجات
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3 class="feature-title">شحن سريع</h3>
                <p class="feature-description">توصيل سريع وآمن لجميع أنحاء فلسطين</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">ضمان الجودة</h3>
                <p class="feature-description">جميع منتجاتنا مضمونة الجودة والصلاحية</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="feature-title">دعم العملاء</h3>
                <p class="feature-description">فريق دعم متخصص لمساعدتك على مدار الساعة</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <h3 class="feature-title">إرجاع مجاني</h3>
                <p class="feature-description">إمكانية الإرجاع المجاني خلال 14 يوم</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>