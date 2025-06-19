<?php
require_once 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - متجر إلكتروني</title>
    <link rel="stylesheet" href="static/styles.css">
    <style>
        .about-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .about-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
        }
        
        .about-container h1::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color:rgb(68, 0, 0);
        }
        
        .about-container p {
            margin-bottom: 20px;
            line-height: 1.6;
            color: #555;
            font-size: 16px;
        }
        
        .team-section {
            margin-top: 40px;
        }
        
        .team-section h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
        }
        
        .team-section h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color:rgb(68, 0, 0);
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        
        .team-member {
            text-align: center;
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 10px;
        }
        
        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background-color: #f8f9fa;
        }
        
        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .team-member:hover img {
            transform: scale(1.05);
            border-color:rgb(68, 0, 0);
        }
        
        .team-member h3 {
            margin-bottom: 5px;
            color: #333;
            font-size: 18px;
        }
        
        .team-member p {
            color: #666;
            margin-bottom: 10px;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        
        .social-links a {
            display: inline-block;
            width: 32px;
            height: 32px;
            background-color:rgb(68, 0, 0);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color:rgb(68, 0, 0);
            transform: scale(1.1);
        }
        
        .mission-section {
            margin-top: 40px;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            border-right: 4px solid rgb(68, 0, 0);
        }
        
        .mission-section h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        @media (max-width: 768px) {
            .team-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 20px;
            }
            
            .team-member img {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">متجرنا</div>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                
                <li><a href="products.php">المنتجات</a></li>
                <li><a href="about.php" class="active">من نحن</a></li>
                <li>
                    <a href="cart.php">السلة
                        <?php if (isset($_SESSION['user_id'])):
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; endif; ?>
                    </a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])): ?>
                    <li><a href="orders.php">طلباتي</a></li>
                    <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="about-container">
            <h1>من نحن</h1>
            <p>مرحباً بكم في متجرنا الإلكتروني، وجهتكم المثالية للتسوق عبر الإنترنت. تأسس متجرنا في عام 2020 بهدف توفير منتجات عالية الجودة بأسعار مناسبة لجميع العملاء.</p>
            
            <p>نحن نؤمن بأن تجربة التسوق يجب أن تكون سهلة وممتعة، ولذلك نسعى جاهدين لتوفير واجهة سهلة الاستخدام وخدمة عملاء متميزة. نلتزم بتقديم أفضل المنتجات وضمان رضا عملائنا من خلال سياسات مرنة للإرجاع والاستبدال.</p>
            
            <p>نفتخر بتقديم مجموعة متنوعة من المنتجات التي تلبي احتياجات جميع أفراد الأسرة، مع ضمان جودة عالية وأسعار تنافسية. نعمل باستمرار على توسيع نطاق منتجاتنا وتحسين خدماتنا لنكون دائمًا الخيار الأول لعملائنا.</p>
            
            <div class="mission-section">
                <h2>رؤيتنا ورسالتنا</h2>
                <p><strong>رؤيتنا:</strong> أن نكون الوجهة الرائدة للتسوق الإلكتروني في المنطقة، ونقدم تجربة تسوق فريدة تجمع بين الجودة والراحة والقيمة.</p>
                <p><strong>رسالتنا:</strong> تمكين عملائنا من الوصول إلى منتجات عالية الجودة بأسعار معقولة، مع توفير تجربة تسوق سلسة وآمنة، ودعم مستمر لضمان رضا العملاء.</p>
            </div>
            
            <div class="team-section">
                <h2>فريقنا</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <img src="team1.jpg" alt="عضو الفريق 1">
                        <h3>محمد زغلول</h3>
                        <p>المدير التنفيذي</p>
                        <div class="social-links">
                            <a href="#" title="تويتر">ت</a>
                            <a href="#" title="لينكد إن">ل</a>
                        </div>
                    </div>
                    <div class="team-member">
                        <img src="team2.jpg" alt="عضو الفريق 2">
                        <h3>مي عامر</h3>
                        <p>مديرة المبيعات</p>
                        <div class="social-links">
                            <a href="#" title="تويتر">ت</a>
                            <a href="#" title="لينكد إن">ل</a>
                        </div>
                    </div>
                    <div class="team-member">
                        <img src="team3.jpg" alt="عضو الفريق 3">
                        <h3>تميم التميمي </h3>
                        <p>مدير خدمة العملاء</p>
                        <div class="social-links">
                            <a href="#" title="تويتر">ت</a>
                            <a href="#" title="لينكد إن">ل</a>
                        </div>
                    </div>
                    <div class="team-member">
                        <img src="team4.jpg" alt="عضو الفريق 4">
                        <h3>فائقة حداد</h3>
                        <p>مديرة التسويق</p>
                        <div class="social-links">
                            <a href="#" title="تويتر">ت</a>
                            <a href="#" title="لينكد إن">ل</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجرنا الإلكتروني</p>
    </footer>
    
    <script src="static/script.js"></script>
</body>
</html>
