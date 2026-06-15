<?php
// student/dashboard.php - پنل اختصاصی مشاهده وضعیت دانشجویان
session_start();
require_once '../db.php'; // اتصال به دیتابیس با خروج از پوشه student

// امنیت پنل: اگر کاربر لاگین نکرده یا نقش او دانشجو نیست، هدایت به صفحه ورود
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id']; // دریافت آی‌دی دانشجوی لاگین شده از سشن

// ۱. استخراج کلاس‌ها، مشخصات دوره و نمرات دانشجو (با استفاده از LEFT JOIN)
$report_query = "
    SELECT courses.title AS course_title, classes.schedule, classes.class_room, grades.grade
    FROM enrollments
    JOIN classes ON enrollments.class_id = classes.id
    JOIN courses ON classes.course_id = courses.id
    LEFT JOIN grades ON enrollments.id = grades.enrollment_id
    WHERE enrollments.student_id = '$student_id' AND enrollments.status = 'active'
";
$report_res = mysqli_query($conn, $report_query);

// ۲. استخراج تاریخچه پرداخت‌های نقدی این دانشجو
$payments_query = "
    SELECT payments.amount, payments.payment_date, courses.title AS course_title
    FROM payments
    JOIN classes ON payments.class_id = classes.id
    JOIN courses ON classes.course_id = courses.id
    WHERE payments.student_id = '$student_id'
    ORDER BY payments.payment_date DESC
";
$payments_res = mysqli_query($conn, $payments_query);

// ۳. محاسبه مجموع مبالغ پرداخت شده توسط این دانشجو
$total_paid_query = "SELECT SUM(amount) AS total FROM payments WHERE student_id = '$student_id'";
$total_paid_res = mysqli_query($conn, $total_paid_query);
$total_paid = mysqli_fetch_assoc($total_paid_res)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پنل دانشجویان | سیستم EMS</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="welcome-box">
    <a href="../login.php" class="logout-btn">خروج از سیستم</a>
    <h2>خوش آمدید، <?php echo $_SESSION['user_name']; ?> (پنل دانشجو)</h2>
    <p>در این بخش می‌توانید وضعیت آموزشی و مالی خود را پیگیری کنید.</p>
</div>

<!-- بخش اول: وضعیت درسی و کارنامه نمرات -->
<div class="section-box">
    <h3>۱. وضعیت آموزشی و کارنامه نمرات</h3>
    <table>
        <thead>
            <tr>
                <th>عنوان دوره آموزشی</th>
                <th>زمان‌بندی کلاس</th>
                <th>اتاق / محل برگزاری</th>
                <th>نمره‌ی نهایی آزمون</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($report_res) > 0): ?>
                <?php while($class = mysqli_fetch_assoc($report_res)): ?>
                    <tr>
                        <td><?php echo $class['course_title']; ?></td>
                        <td><?php echo $class['schedule']; ?></td>
                        <td><?php echo $class['class_room']; ?></td>
                        <td>
                            <?php echo ($class['grade'] !== null) ? "<span class='grade-badge'>".$class['grade']."</span>" : "<span class='no-grade'>هنوز ثبت نشده</span>"; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #777;">شما در حال حاضر در هیچ کلاسی عضویت فعال ندارید.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- بخش دوم: وضعیت فیش‌های مالی و پرداخت‌ها -->
<div class="section-box">
    <h3>۲. تاریخچه پرداخت‌های شهریه (نقدی)</h3>
    <table>
        <thead>
            <tr>
                <th>بابت کلاس / دوره</th>
                <th>مبلغ پرداخت شده</th>
                <th>تاریخ و زمان پرداخت</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($payments_res) > 0): ?>
                <?php while($pay = mysqli_fetch_assoc($payments_res)): ?>
                    <tr>
                        <td><?php echo $pay['course_title']; ?></td>
                        <td><?php echo number_format($pay['amount']); ?> افغانی</td>
                        <td><?php echo $pay['payment_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: #777;">هیچ سابقه پرداختی برای شما در سیستم ثبت نشده است.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="financial-summary">
        مجموع کل مبالغ نقدی تحویل داده شده به مدیریت: <?php echo number_format($total_paid); ?> افغانی
    </div>
</div>

</body>
</html>
