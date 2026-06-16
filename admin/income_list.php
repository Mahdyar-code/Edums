<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$list_payments = mysqli_query($conn, "
    SELECT payments.id, users.name AS student_name, courses.title AS course_title, payments.amount, payments.payment_date 
    FROM payments 
    JOIN users ON payments.student_id = users.id 
    JOIN classes ON payments.class_id = classes.id 
    JOIN courses ON classes.course_id = courses.id 
    ORDER BY payments.id DESC
");

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="lists.css">
     <link
      href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <div id="payments-section" class="section-box">
    <h3> <div class="title">💰تاریخچه فیش‌های مالی نقدی دریافتی</div>
         <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>
    </h3>
    <table>
        <thead>
            <tr>
                <th>شماره فیش</th>
                <th>نام شاگرد</th>
                <th>بابت کورس</th>
                <th>مبلغ دریافتی</th>
                <th>تاریخ پرداخت</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_payments)): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><strong><?php echo $row['course_title']; ?></strong></td>
                    <td style="color: green; font-weight: bold;"><?php echo number_format($row['amount']); ?> افغانی</td>
                    <td><?php echo $row['payment_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>