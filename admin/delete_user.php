<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// $teacher = ['id' => '', 'name' => '', 'email' => '']; // تعریف اولیه متغیر برای جلوگیری از خطا

// ۱. لود کردن اطلاعات فعلی استاد بابت پر کردن کادرها (در حالت لود اولیه صفحه)
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query=("DELETE FROM users WHERE id = '$id'");
   if (mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>اطلاعات استاد با موفقیت به‌روزرسانی شد.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ویرایش: " . mysqli_error($conn) . "</div>";
    }
    echo $_SESSION['flahs_message'];
    header("Location: teachers_list.php");
    exit();
}
 ?>
