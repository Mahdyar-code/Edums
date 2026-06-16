<?php
// teacher/dashboard.php - داشبورد اختصاصی اساتید
session_start();
require_once '../db.php'; // خروج از پوشه teacher و اتصال به db.php
// avoid frome happen problem in  Intelephense extension 
/** @var mysqli $conn */
// امنیت پنل: اگر کاربر لاگین نکرده یا نقش او استاد نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
$teacher_id = $_SESSION['user_id']; // دریافت آی‌دی استاد لاگین شده از سشن
// $_SESSION['role'] = 'teacher';
// استخراج لیست صنف های مربوط به همین استاد به همراه نام دوره (با استفاده از JOIN)
$query = "SELECT classes.id, courses.title AS course_title, classes.class_room, classes.schedule, classes.capacity, classes.start_date 
          FROM classes 
          JOIN courses ON classes.course_id = courses.id 
          WHERE classes.teacher_id = '$teacher_id'
          ORDER BY classes.start_date DESC";
$classes_res = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پنل اساتید | سیستم EMS</title>
     <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="welcome-box">
    <a href="../login.php" class="logout-btn">خروج از سیستم</a>
    <h2>خوش آمدید استاد، <?php echo $_SESSION['user_name']; ?></h2>
    <p>لیست صنف های فعال و دوره‌های آموزشی تحت تدریس شما در مرکز:</p>
</div>

<?php if (mysqli_num_rows($classes_res) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>شماره صنف</th>
                <th>عنوان دوره آموزشی</th>
                <th>روزها و ساعت برگزاری</th>
                <th>مکان / صنف فیزیکی</th>
                <th>ظرفیت</th>
                <th>تاریخ شروع</th>
                <th>عملیات ارزیابی</th>
            </tr>
        </thead>
        <tbody>
            <?php while($class = mysqli_fetch_assoc($classes_res)): ?>
                <tr>
                    <td><?php echo $class['id']; ?></td>
                    <strong><td><?php echo $class['course_title']; ?></td></strong>
                    <td><?php echo $class['schedule']; ?></td>
                    <td><?php echo $class['class_room']; ?></td>
                    <td><?php echo $class['capacity']; ?> نفر</td>
                    <td><?php echo $class['start_date']; ?></td>
                    <td>
                        <!-- دکمه ورود به صفحه ثبت نمرات با فرستادن آی‌دی صنف از طریق متد GET -->
                        <a href="submit_grade.php?class_id=<?php echo $class['id']; ?>" class="action-btn">ثبت نمرات دانشجویان</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">در حال حاضر هیچ صنف فعالی برای شما در سیستم ثبت نشده است.</div>
<?php endif; ?>

</body>
</html>
