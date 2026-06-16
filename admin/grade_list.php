<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

  $list_grade = mysqli_query($conn, "SELECT users.name AS student_name, users.email AS student_email, grades.grade, courses.title, classes.schedule, grades.exam_date FROM users JOIN enrollments ON users.id = enrollments.student_id JOIN classes ON classes.id = enrollments.class_id JOIN courses ON courses.id = classes.course_id JOIN grades ON enrollments.id = grades.enrollment_id ORDER BY grades.grade desc");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لست نمرات</title>
    <link rel="stylesheet" href="lists.css">
</head>
<body>
    <div id="students-section" class="section-box">
    <h3>
        <div class="title">📃 لیست کامل نمرات</div>
        <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>
    </h3>
    <table>
        <thead>
            <tr>
                <th>نام</th>
                <th>آدرس ایمیل</th>
                <th>صنف</th>
                <th>نمره</th>
                <th>تقسیم اوقات</th>
                <th>تاریخ امتحان</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_grade)): ?>
                <tr>
                    <td><strong><?php echo $row['student_name']; ?></strong></td>
                    <td><?php echo $row['student_email']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['grade']; ?></td>
                    <td><?php echo $row['schedule']; ?></td>
                    <td><?php echo $row['exam_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>