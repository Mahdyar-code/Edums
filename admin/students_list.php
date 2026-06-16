<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

  $list_students = mysqli_query($conn, "SELECT users.id AS student_id,users.name AS student_name, users.email AS student_email,users.create_at,courses.title FROM users JOIN enrollments ON users.id=enrollments.student_id JOIN classes ON classes.id = enrollments.class_id JOIN courses ON classes.course_id = courses.id");


?>



<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="lists.css">
</head>
<body>
    <div id="students-section" class="section-box">
    <h3>👥 لیست کامل شاگردان ثبت‌نام شده</h3>
    <table>
        <thead>
            <tr>
                <th>آی‌دی</th>
                <th>نام و نام خانوادگی</th>
                <th>آدرس ایمیل</th>
                <th>صنف</th>
                <th>تاریخ ثبت‌نام در سیستم</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_students)): ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><strong><?php echo $row['student_name']; ?></strong></td>
                    <td><?php echo $row['student_email']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['create_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>