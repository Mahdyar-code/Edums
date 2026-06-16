<?php
session_start();
require_once '../db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$res_classes=mysqli_query($conn,"
    SELECT courses.title, courses.price, classes.schedule, users.name, classes.start_date, classes.end_date, classes.capacity FROM courses JOIN classes ON courses.id=classes.course_id JOIN users ON classes.teacher_id=users.id WHERE classes.end_date >= curdate() ORDER BY classes.start_date DESC;
");

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
    <div id="courses-section" class="section-box">
    <h3> <div class="title">
        📚 صنف های فعال
    </div>
        <div class="button">
            <a href="../login.php">خروج</a>
            <a href="dashboard.php">برگشت</a>
        </div>
    </h3>
    <table>
        <thead>
            <tr>
                <th>صنف</th>
                <th>فس (افغانی)</th>
                <th> تایم</th>
                <th>استاد</th>
                <th>تاریخ شروع</th>
                <th>تاریخ ختم</th>
                <th>ظرفیت صنف</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res_classes)): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><strong><?php echo $row['price']; ?> افغانی </strong></td>
                    <td><?php echo $row['schedule']; ?> </td>
                    <td><?php echo $row['name']; ?> </td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>