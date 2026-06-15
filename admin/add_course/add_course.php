<?php
// admin/add_course.php - تعریف دوره آموزشی جدید توسط مدیریت
session_start();
require_once '../../db.php';
// avoid frome happen problem in  Intelephense extension 
/** @var mysqli $conn */
// امنیت پنل: فقط مدیر حق دسترسی دارد
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);

    // کوئری درج اطلاعات در جدول دوره‌ها (courses)
    $query = "INSERT INTO courses (title, description, price, duration) 
              VALUES ('$title', '$description', '$price', '$duration')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>دوره آموزشی جدید با موفقیت در سیستم تعریف شد.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ثبت دوره: " . mysqli_error($conn) . "</div>";
    }

    // هدایت به همین صفحه برای پاکسازی حافظه مرورگر و جلوگیری از ثبت تکراری با رفرش
    header("Location: add_course.php");
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
    <title>تعریف دوره آموزشی جدید</title>
    <link rel="stylesheet" href="add_course.css">
</head>
<body>

<div class="form-container">
    <h2>تعریف دوره آموزشی جدید</h2>
    
    <?php echo $message; ?>

    <form action="add_course.php" method="POST">
        <div class="form-group">
            <label>نام دوره (عنوان):</label>
            <input type="text" name="title" placeholder="مثال:ریاضی پایه" required>
        </div>

        <div class="form-group">
            <label>هزینه دوره (فس به افغانی):</label>
            <input type="number" step="0.01" name="price" placeholder="مثال: 3500" required>
        </div>

        <div class="form-group">
            <label>طول دوره (به دقیقه):</label>
            <input type="number" name="duration" placeholder="مثال: 45" required>
        </div>

        <div class="form-group">
            <label>توضیحات و سرفصل‌ها:</label>
            <textarea name="description" placeholder="خلاصه‌ای از سرفصل‌های آموزشی این دوره..."></textarea>
        </div>

        <button type="submit">ثبت و ایجاد دوره</button>
    </form>

    <a href="../dashboard.php" class="back-link">بازگشت به داشبورد اصلی</a>
</div>

</body>
</html>
