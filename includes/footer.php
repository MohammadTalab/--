    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Company Info -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="/assets/images/logo.png" alt="<?php echo APP_NAME; ?>" class="footer-logo-img">
                        <h3 class="footer-logo-text"><?php echo APP_NAME; ?></h3>
                    </div>
                    <p class="footer-description">
                        وجهتك الأولى للتسوق الإلكتروني. نقدم أفضل المنتجات المحلية والعالمية 
                        بأسعار منافسة وجودة عالية مع خدمة عملاء مميزة.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" title="فيسبوك">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" title="تويتر">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="إنستغرام">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="واتساب">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-title">روابط سريعة</h4>
                    <ul class="footer-links">
                        <li><a href="/" class="footer-link">الرئيسية</a></li>
                        <li><a href="/products.php" class="footer-link">المنتجات</a></li>
                        <li><a href="/about.php" class="footer-link">من نحن</a></li>
                        <li><a href="/contact.php" class="footer-link">اتصل بنا</a></li>
                        <li><a href="/privacy.php" class="footer-link">سياسة الخصوصية</a></li>
                        <li><a href="/terms.php" class="footer-link">شروط الاستخدام</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div class="footer-section">
                    <h4 class="footer-title">فئات المنتجات</h4>
                    <ul class="footer-links">
                        <?php
                        $categoryModel = new Category();
                        $categories = $categoryModel->getAll();
                        foreach (array_slice($categories, 0, 6) as $category):
                        ?>
                        <li>
                            <a href="/products.php?category=<?php echo $category['c_id']; ?>" class="footer-link">
                                <?php echo e($category['name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="footer-section">
                    <h4 class="footer-title">معلومات الاتصال</h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>فلسطين - رام الله</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+970 59 123 4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@kheirbiladak.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>الأحد - الخميس: 9:00 - 18:00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="newsletter-section">
                <div class="newsletter-content">
                    <h4 class="newsletter-title">اشترك في النشرة البريدية</h4>
                    <p class="newsletter-description">احصل على آخر العروض والمنتجات الجديدة</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="البريد الإلكتروني" class="newsletter-input" required>
                        <button type="submit" class="newsletter-btn">
                            <i class="fas fa-paper-plane"></i>
                            اشتراك
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="footer-bottom">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. جميع الحقوق محفوظة.</p>
                </div>
                <div class="footer-bottom-links">
                    <a href="/privacy.php">سياسة الخصوصية</a>
                    <a href="/terms.php">شروط الاستخدام</a>
                    <a href="/sitemap.php">خريطة الموقع</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- JavaScript -->
    <script src="/assets/js/main.js"></script>
    
    <!-- Additional Scripts -->
    <?php if (isset($additional_scripts)): ?>
        <?php foreach ($additional_scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html> 