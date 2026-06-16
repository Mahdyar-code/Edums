<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$list_expenses = mysqli_query($conn, "SELECT * FROM expenses ORDER BY id DESC");
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
    <div id="expenses-section" class="section-box">
    <h3> <div class="title">
        📉 لیست مصارف و مخارج روزانه مرکز
    </div>
         <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>
    </h3>
    <table>
        <thead>
            <tr>
                <th>کد هزینه</th>
                <th>عنوان مخارج</th>
                <th>دسته‌بندی</th>
                <th>مبلغ مصرف شده</th>
                <th>تاریخ ثبت</th>
                <th>توضیحات فیش</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_expenses)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo number_format($row['amount']); ?> افغانی</td>
                    <td><?php echo $row['expense_date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>