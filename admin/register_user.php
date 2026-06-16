<?php
// admin/register_user.php - ثبت شاگرد یا استاد جدید فقط با مشخصات اصلی
session_start();
require_once '../db.php';

// امنیت پنل: فقط مدیر حق دسترسی دارد
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // ۱. بررسی تکراری نبودن ایمیل در سیستم
    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا: این ایمیل قبلاً در سیستم ثبت شده است!</div>";
    } else {
        // ۲. هش کردن رمز عبور برای امنیت بالا بر اساس تصمیم قبلی شما
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // ۳. درج کاربر جدید در جدول users
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['flash_message'] = "<div class='success-msg'>کاربر جدید ($name) با موفقیت به عنوان $role در سیستم ثبت شد.</div>";
        } else {
            $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ثبت کاربر: " . mysqli_error($conn) . "</div>";
        }
    }

    header("Location: register_user.php");
    exit();
}

// دریافت پیام زودگذر (Flash Message)
$message = "";
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت نام کاربر جدید</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

<div class="form-container">
    <h2>ثبت نام شاگرد یا استاد جدید</h2>
    
    <?php echo $message; ?>

    <form action="register_user.php" method="POST">
        <div class="form-group">
            <label>نام و نام خانوادگی:</label>
            <input type="text" name="name" placeholder="مثال: علی احمدی" required>
        </div>

        <div class="form-group">
            <label>آدرس ایمیل (نام کاربری ورود):</label>
            <input type="email" name="email" placeholder="مثال: ali@gmail.com" required>
        </div>

        <div class="form-group">
            <label>رمز عبور اولیه:</label>
            <input type="password" name="password" placeholder="حداقل ۶ کاراکتر" required>
        </div>

        <div class="form-group">
            <label>تعیین نقش کاربر:</label>
            <select name="role" required>
                <option value="student">شاگرد (Student)</option>
                <option value="teacher">استاد (Teacher)</option>
                <option value="admin">مدیر سیستم (Admin)</option>
                <option value="employ"> کارمند (employe)</option>
            </select>
        </div>

        <button type="submit">ایجاد حساب کاربری</button>
    </form>

    <a href="dashboard.php" class="back-link">بازگشت به داشبورد اصلی</a>
</div>
 <script src='../js.js></script>
</body>
</html>
