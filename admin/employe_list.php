<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$list_employe = mysqli_query($conn,"SELECT users.id, users.name ,users.email,users.create_at FROM users WHERE users.role='employ'");

?>

<!DOCTYPE html>
<html lang="fa"  dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لیست کارمندان</title>
    <link rel="stylesheet" href="lists.css">
</head>
<body>
    <div id="teachers-section" class="section-box">
    <h3> <div class="title">🦸 لیست کارمندان</div>
 <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>

    </h3>
    <table>
        <thead>
            <tr>
                <th>آی‌دی</th>
                <th>نام کارمند</th>
                <th>آدرس ایمیل</th>
                <th>تاریخ عضویت</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_employe)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['name']; ?></strong></td>
                    <td><?php echo $row['email']; ?></td>
                   
                    <td><?php echo $row['create_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>