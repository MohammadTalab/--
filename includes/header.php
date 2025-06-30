<?php
/**
 * Header Template
 * Common header for all pages
 */

// Ensure config is loaded
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../config/config.php';
}

// Get current page for navigation highlighting
$current_page = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? APP_NAME; ?></title>
    <meta name="description" content="<?php echo $page_description ?? 'متجر إلكتروني متخصص في بيع المنتجات المحلية والعالمية'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <a href="/" class="logo-link">
                        <img src="/assets/images/logo.png" alt="<?php echo APP_NAME; ?>" class="logo-img">
                        <span class="logo-text"><?php echo APP_NAME; ?></span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="/" class="nav-link <?php echo isActivePage('index') ? 'active' : ''; ?>">
                                <i class="fas fa-home"></i>
                                الرئيسية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/products.php" class="nav-link <?php echo isActivePage('products') ? 'active' : ''; ?>">
                                <i class="fas fa-shopping-bag"></i>
                                المنتجات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/about.php" class="nav-link <?php echo isActivePage('about') ? 'active' : ''; ?>">
                                <i class="fas fa-info-circle"></i>
                                من نحن
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/contact.php" class="nav-link <?php echo isActivePage('contact') ? 'active' : ''; ?>">
                                <i class="fas fa-envelope"></i>
                                اتصل بنا
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- User Menu -->
                <div class="user-menu">
                    <!-- Search -->
                    <div class="search-container">
                        <form action="/products.php" method="GET" class="search-form">
                            <input type="text" name="search" placeholder="ابحث عن منتج..." class="search-input">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Cart -->
                    <a href="/cart.php" class="cart-link <?php echo isActivePage('cart') ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">السلة</span>
                        <?php if (isLoggedIn()): ?>
                            <?php 
                            $cart = new Cart();
                            $cartCount = $cart->getCount($_SESSION['user_id']);
                            if ($cartCount > 0): 
                            ?>
                                <span class="cart-badge"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                    
                    <!-- User Account -->
                    <?php if (isLoggedIn()): ?>
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user"></i>
                                <span><?php echo e($_SESSION['user_name']); ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/profile.php" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    الملف الشخصي
                                </a>
                                <a href="/orders.php" class="dropdown-item">
                                    <i class="fas fa-list"></i>
                                    طلباتي
                                </a>
                                <?php if (isAdmin()): ?>
                                    <a href="/admin/" class="dropdown-item">
                                        <i class="fas fa-cog"></i>
                                        لوحة التحكم
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="/logout.php" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    تسجيل خروج
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="auth-buttons">
                            <a href="/login.php" class="btn btn-outline btn-sm">
                                <i class="fas fa-sign-in-alt"></i>
                                تسجيل دخول
                            </a>
                            <a href="/register.php" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus"></i>
                                تسجيل جديد
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Flash Messages -->
    <?php $flash = getFlashMessage(); ?>
    <?php if ($flash): ?>
        <div class="flash-message flash-<?php echo $flash['type']; ?>">
            <div class="container">
                <div class="flash-content">
                    <span class="flash-text"><?php echo e($flash['message']); ?></span>
                    <button class="flash-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="main-content"> 