<?php

session_start();
// require_once "../../ems/db.php";
require_once "../db.php";
// avoid frome happen problem in  Intelephense extension 
/** @var mysqli $conn */

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location:../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

// ۱. دریافت آی‌دی صنف از آدرس مرورگر (متد GET)
if (!isset($_GET['class_id'])) {
    header("Location: dashboard.php");
    exit();
}
$class_id = mysqli_real_escape_string($conn, $_GET['class_id']);
$cnQuery="SELECT title FROM courses JOIN classes ON courses.id=classes.course_id AND classes.teacher_id='$teacher_id'";
$excutt= mysqli_query($conn,$cnQuery);

// ۲. امنیت مضاعف: بررسی اینکه این صنف حتماً متعلق به این استاد باشد
$class_check = mysqli_query($conn, "SELECT * FROM classes WHERE id = '$class_id' AND teacher_id = '$teacher_id'");
if (mysqli_num_rows($class_check) == 0) {
    die("<h1>خطای امنیتی: شما اجازه دسترسی به این صنف را ندارید!</h1>");
}

// پردازش فرم پس از ارسال نمرات (تکنیک PRG)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enrollment_id = mysqli_real_escape_string($conn, $_POST['enrollment_id']);
    $grade_value = mysqli_real_escape_string($conn, $_POST['grade']);
    $exam_date = date('Y-m-d'); // ثبت تاریخ امروز به عنوان تاریخ ثبت نمره

    // الف) بررسی اینکه آیا قبلاً برای این دانشجو در این صنف نمره ثبت شده یا خیر
    $grade_check = mysqli_query($conn, "SELECT * FROM grades WHERE enrollment_id = '$enrollment_id'");
    
    if (mysqli_num_rows($grade_check) > 0) {
        // اگر قبلاً نمره ثبت شده بود، آن را آپدیت (UPDATE) کن
        $query = "UPDATE grades SET grade = '$grade_value', exam_date = '$exam_date' WHERE enrollment_id = '$enrollment_id'";
    } else {
        // اگر نمره جدید است، آن را درج (INSERT) کن
        $query = "INSERT INTO grades (enrollment_id, grade, exam_date) VALUES ('$enrollment_id', '$grade_value', '$exam_date')";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>نمره با موفقیت در کارنامه دانشجو ثبت شد.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ثبت نمره: " . mysqli_error($conn) . "</div>";
    }

    // هدایت به همین صفحه به همراه صنف آی‌دی برای جلوگیری از ارسال مجدد فرم با رفرش
    header("Location: submit_grade.php?class_id=" . $class_id);
    exit();
}

// دریافت فلاش‌مسج
$message = "";
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// ۳. استخراج لیست شاگردان ثبت‌نام شده در این صنف به همراه نمره‌شان (در صورت وجود) با استفاده از LEFT JOIN
$students_query = "
    SELECT enrollments.id AS enrollment_id, users.name AS student_name, users.id AS student_id, grades.grade
    FROM enrollments
    JOIN users ON enrollments.student_id = users.id
    LEFT JOIN grades ON enrollments.id = grades.enrollment_id
    WHERE enrollments.class_id = '$class_id' AND enrollments.status = 'active'";
$students_res = mysqli_query($conn, $students_query);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت و ارزیابی نمرات</title>
    <link rel="stylesheet" href="submit_grade.css" >
</head>
<body>

<div class="container">
    <div class="header-box">
       
        <h2>مدیریت و ثبت نمرات صنف شماره <?php echo $class_id; ?>  
        <?php if(mysqli_num_rows($excutt) >0){
            $rrow = mysqli_fetch_assoc($excutt);
            echo "(". $rrow['title'].")";
        } ?></h2>
        <p>در این بخش می‌توانید نمرات آزمون نهایی شاگردان را وارد یا ویرایش کنید.</p>
    </div>

    <?php echo $message; ?>

    <table>
        <thead>
            <tr>
                <th>آیدی دانشجو</th>
                <th>نام دانشجو</th>
                <th>نمره جاری در سیستم</th>
                <th>ثبت / ویرایش نمره جدید</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($students_res) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($students_res)): ?>
                    <tr>
                        <td><?php echo $row['student_id']   ?>  </td>
                        <td><?php echo $row['student_name']; ?></td>
                        <td>
                            <!-- نمایش نمره قبلی یا واژه ثبت نشده -->
                            <strong><?php echo ($row['grade'] !== null) ? $row['grade'] : "<span style='color:orange;'>ثبت نشده</span>"; ?></strong>
                        </td>
                        <td>
                            <!-- فرم‌های تکی برای هر ردیف دانشجو -->
                            <form action="submit_grade.php?class_id=<?php echo $class_id; ?>" method="POST" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="enrollment_id" value="<?php echo $row['enrollment_id']; ?>">
                                <input type="number" name="grade" min="0" max="20" step="0.25" placeholder="0-20" required value="<?php echo $row['grade']; ?>">
                                <button type="submit" class="submit-btn">ثبت</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: #777;">هیچ دانشجوی فعالی در این صنف ثبت‌نام نکرده است.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="back-link">بازگشت به پنل صنف‌ها</a>
</div>

</body>
</html>
