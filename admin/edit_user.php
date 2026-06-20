<?php
// admin/edit_teacher.php - نسخه اصلاح شده بدون خطای Undefined Variable
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// $teacher = ['id' => '', 'name' => '', 'email' => '']; // تعریف اولیه متغیر برای جلوگیری از خطا

// ۱. لود کردن اطلاعات فعلی کاربر بابت پر کردن کادرها (در حالت لود اولیه صفحه)
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
   
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
    } else {
        die("<h1>کاربر یافت نشد!</h1>");
    }
}
else{
    echo ('no recive');
}

// ۲. پردازش فرم پس از ویرایش و سابمیت (در حالت ارسال فرم)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "UPDATE users SET name='$name', email='$email' WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>اطلاعات کاربر با موفقیت به‌روزرسانی شد.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ویرایش: " . mysqli_error($conn) . "</div>";
    }
    if($user['role'] = 'teacher'){

        header("Location: teachers_list.php");
    }
    if($user['role'] = 'student'){

        header("Location: students_list.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش اطلاعات کاربر</title>
    <link rel="stylesheet" href="edit_user.css">
</head>
<body>

<div class="form-container">
    <h2>ویرایش پروفایل کاربر</h2>
    <form action="edit_user.php" method="POST">
        <!-- ارسال ایدی به صورت مخفی -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        
        <div class="form-group">
            <label>نام و نام خانوادگی:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>آدرس ایمیل:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <button type="submit">ذخیره تغییرات جدید</button>
    </form>
    <a href="teachers_list.php" class="back-link">انصراف و بازگشت</a>
</div>

</body>
</html>
