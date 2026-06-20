<?php
session_start();
require_once '../db.php'; 

// امنیت پنل: اگر کاربر مدیر نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$list_teachers = mysqli_query($conn,"SELECT users.id, users.name ,users.email,users.create_at FROM users  WHERE users.role='teacher'");

?>

<!DOCTYPE html>
<html lang="fa"  dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="lists.css">
</head>
<body>
    <div id="teachers-section" class="section-box">
    <h3> <div class="title">🦸 لیست کامل اساتید مرکز</div>
 <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>

    </h3>
    <table>
        <thead>
            <tr>
                <th>آی‌دی</th>
                <th>نام استاد</th>
                <th>آدرس ایمیل</th>
                <th>تاریخ عضویت</th>
                <th>تغیرات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($list_teachers)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['name']; ?></strong></td>
                    <td><?php echo $row['email']; ?></td>
                    
                    <td><?php echo $row['create_at']; ?></td>
                    <td class="actions">
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" target="_blank">✏️ ویرایش</a>
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('آیا مطمئن هستید که می‌خواهید این استاد را حذف کنید؟');">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>