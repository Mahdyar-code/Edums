<?php
// admin/add_class.php - تعریف صنف جدید توسط مدیریت
session_start();
require_once '../../db.php';
// avoid frome happen problem in  Intelephense extension 
/** @var mysqli $conn */
// امنیت پنل: فقط مدیر حق دسترسی دارد
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// پردازش فرم پس از ارسال (تکنیک PRG)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $class_room = mysqli_real_escape_string($conn, $_POST['class_room']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    // کوئری درج اطلاعات در جدول صنف‌ها (classes)
    $query = "INSERT INTO classes (course_id, teacher_id, class_room, schedule, capacity, start_date, end_date) 
              VALUES ('$course_id', '$teacher_id', '$class_room', '$schedule', '$capacity', '$start_date','$end_date')";

       
    if(mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>صنف جدید با موفقیت تشکیل شد و استاد به آن اختصاص یافت.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در تشکیل صنف: " . mysqli_error($conn) . "</div>";
    }

    header("Location: add_class.php");
    exit();
}

// دریافت پیام زودگذر (Flash Message)
$message = "";
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// استخراج لیست دوره‌ها برای منوی کشویی
$courses_res = mysqli_query($conn, "SELECT id, title FROM courses");

// استخراج لیست اساتید برای منوی کشویی
$teachers_res = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'teacher'");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تشکیل صنف جدید</title>
    <link rel="stylesheet" href="add_class.css">
</head>
<body>

<div class="form-container">
    <h2>تشکیل صنف جدید</h2>
    
    <?php echo $message; ?>

    <form action="add_class.php" method="POST">
        <div class="form-group">
            <!-- <label>انتخاب دوره آموزشی:</label> -->
            <select name="course_id" required>
                <option value="">-- انتخاب دوره --</option>
                <?php while($course = mysqli_fetch_assoc($courses_res)): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo $course['title']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <!-- <label>انتخاب استاد مدرس:</label> -->
            <select name="teacher_id" required>
                <option value="">-- انتخاب استاد --</option>
                <?php while($teacher = mysqli_fetch_assoc($teachers_res)): ?>
                    <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <!-- <label>شماره یا نام اتاق صنف:</label> -->
            <input type="text" name="class_room" placeholder="مثال: لابراتوار کامپیوتر ۱" required>
        </div>

        <div class="form-group">
            <!-- <label>روزها و ساعت برگزاری:</label> -->
            <input type="text" name="schedule" placeholder="مثال: جفت روزها (۱۴:۰۰ - ۱۶:۰۰)" required>
        </div>

        <div class="form-group">
            <!-- <label>ظرفیت صنف (نفر):</label> -->
            <input type="number" name="capacity" placeholder="مثال: ۲۵" required>
        </div>

        <div class="form-group">
            <!-- <label>تاریخ شروع صنف:</label> -->
            <input type="date" name="start_date"  placeholder="تاریخ شروع صنف" required>
        </div>
        <div class="form_group">
            <!-- <label for="">ختم صنف</label> -->
            <input type="date" name="end_date"  placeholder="تاریخ ختم صنف" required>
        </div>

        <button type="submit">ثبت و ایجاد صنف</button>
    </form>

    <a href="../dashboard.php" class="back-link">بازگشت به داشبورد اصلی</a>
</div>

</body>
</html>
