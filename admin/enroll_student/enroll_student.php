<?php
// admin/enroll_student.php - ثبت‌نام دانشجو در کلاس توسط مدیریت
session_start();
require_once '../../db.php';


if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'teacher')) {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);

    // ۱. بررسی اینکه آیا این دانشجو قبلاً در این کلاس ثبت‌نام کرده است یا خیر
    $check_query = "SELECT * FROM enrollments WHERE student_id = '$student_id' AND class_id = '$class_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['flash_message'] = "<div class='error-msg'>این دانشجو قبلاً در این کلاس ثبت‌نام شده است!</div>";
    } else {
        // ۲. ثبت‌نام دانشجو در جدول enrollments
        $query = "INSERT INTO enrollments (student_id, class_id, status) VALUES ('$student_id', '$class_id', 'active')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['flash_message'] = "<div class='success-msg'>دانشجو با موفقیت در کلاس ثبت‌نام شد.</div>";
        } else {
            $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ثبت‌نام: " . mysqli_error($conn) . "</div>";
        }
    }

    // هدایت به همین صفحه برای جلوگیری از ارسال مجدد با رفرش
    header("Location: enroll_student.php");
    exit();
}

// دریافت پیام زودگذر (Flash Message)
$message = "";
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// ۳. استخراج لیست تمام دانشجویان برای نمایش در منوی کشویی (Drop-down)
$students_res = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'student'");

// ۴. استخراج لیست تمام کلاس‌ها به همراه نام دوره مربوطه (با استفاده از JOIN)
$classes_res = mysqli_query($conn, "
    SELECT classes.id, courses.title, classes.schedule 
    FROM classes 
    JOIN courses ON classes.course_id = courses.id
");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام دانشجو در کلاس</title>
    <link rel="stylesheet" href="enroll.css">
</head>
<body>

 <div class="form-container">
    <h2>ثبت‌نام جدید در کلاس‌ها</h2>
    
    <?php echo $message; ?>

    <form action="enroll_student.php" method="POST">
        
        <div class="form-group">
            <label>انتخاب دانشجو:</label>
            <select name="student_id" required>
                <option value="">-- انتخاب کنید --</option>
                <?php while($student = mysqli_fetch_assoc($students_res)): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>انتخاب کلاس و دوره:</label>
            <select name="class_id" required>
                <option value="">-- انتخاب کنید --</option>
                <?php while($class = mysqli_fetch_assoc($classes_res)): ?>
                    <option value="<?php echo $class['id']; ?>">
                        <?php echo $class['title'] . " (" . $class['schedule'] . ")"; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit">قطعی کردن ثبت‌نام</button>
    </form>

    <a href="../dashboard.php" class="back-link">بازگشت به داشبورد</a>
 </div>

</body>
</html>