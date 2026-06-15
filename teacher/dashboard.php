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
    <style>
        body { font-family: Tahoma, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; direction: rtl; }
        .welcome-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .logout-btn { background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; float: left; }
        h2 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: right; border-bottom: 1px solid #eee; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f8f9fa; }
        .action-btn { background-color: #28a745; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .action-btn:hover { background-color: #218838; }
        .no-data { text-align: center; padding: 20px; color: #777; background: white; border-radius: 8px; }
    </style>
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
