<?php
$page_title = 'تسجيل الدخول - متجر خير بلادك';
$current_page = 'login';
require_once 'connect.php';

include 'header.php';
?>
    
       <main>
           <div class="form-container">
               <h2>تسجيل الدخول</h2>
               
               <?php
               // عرض رسائل النظام إن وجدت
               if (isset($_SESSION['message'])) {
                   echo '<div class="message info">' . $_SESSION['message'] . '</div>';
                   unset($_SESSION['message']);
               }
               
               if(isset($_POST['login'])){
                   $email = mysqli_real_escape_string($conn, $_POST['email']);
                   $password = mysqli_real_escape_string($conn, $_POST['password']);
                   
                   $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
                   $result = mysqli_query($conn, $sql);
                   
                   if(mysqli_num_rows($result) > 0){
                       $user = mysqli_fetch_assoc($result);
                       $_SESSION['user_id'] = $user['u_id'];
                       $_SESSION['user_name'] = $user['name'];
                       $_SESSION['user_email'] = $user['email'];
                       $_SESSION['role'] = $user['role'] ?? 'user';
                       
                       $_SESSION['message'] = 'تم تسجيل الدخول بنجاح!';
                       header("Location: index.php");
                       exit();
                   } else {
                       echo '<div class="message error">البريد الإلكتروني أو كلمة المرور غير صحيحة</div>';
                   }
               }
               ?>
               
               <form action="" method="post">
                   <div class="form-group">
                       <label for="email">البريد الإلكتروني</label>
                       <input type="email" id="email" name="email" required>
                   </div>
                   <div class="form-group">
                       <label for="password">كلمة المرور</label>
                       <input type="password" id="password" name="password" required>
                   </div>
                   <button type="submit" name="login" class="btn" style="width: 100%;">تسجيل الدخول</button>
                   <div class="form-footer">
                       <p>ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a></p>
                   </div>
               </form>
           </div>
       </main>

<?php include 'footer.php'; ?>