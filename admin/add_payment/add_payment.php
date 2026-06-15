<?php
// admin/add_payment.php - ثبت پرداخت فس نقدی شاگردان
session_start();
require_once '../../db.php';

// avoid frome happen problem in  Intelephense extension 
/** @var mysqli $conn */
// امنیت پنل: فقط مدیر حق دسترسی دارد
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    // کوئری درج اطلاعات در جدول پرداخت‌ها (payments)
    $query = "INSERT INTO payments (student_id, class_id, amount) VALUES ('$student_id', '$class_id', '$amount')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['flash_message'] = "<div class='success-msg'>مبلغ پرداخت فس با موفقیت در فیش مالی ثبت شد.</div>";
    } else {
        $_SESSION['flash_message'] = "<div class='error-msg'>خطا در ثبت تراکنش: " . mysqli_error($conn) . "</div>";
    }

    header("Location: add_payment.php");
    exit();
}

// دریافت پیام زودگذر (Flash Message)
$message = "";
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// استخراج لیست شاگردانی که حداقل در یک صنف ثبت‌نام کرده‌اند به همراه مشخصات صنفشان (با استفاده از JOIN)
$enrollments_res = mysqli_query($conn, "
    SELECT enrollments.student_id, enrollments.class_id, users.name AS student_name, courses.title AS course_title
    FROM enrollments
    JOIN users ON enrollments.student_id = users.id
    JOIN classes ON enrollments.class_id = classes.id
    JOIN courses ON classes.course_id = courses.id
    WHERE enrollments.status = 'active'
");
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت پرداخت فس</title>
    <link rel="stylesheet" href="add_payment.css">
</head>
<body>

<div class="form-container">
    <h2>ثبت رسید پرداخت فس نقدی</h2>
    
    <?php echo $message; ?>

    <form action="add_payment.php" method="POST">
        <div class="form-group">
            <label>انتخاب شاگرد و صنف مربوطه:</label>
            <select name="student_enrollment" id="student_enrollment" required onchange="updateHiddenFields()">
                <option value="">-- انتخاب کنید --</option>
                <?php while($row = mysqli_fetch_assoc($enrollments_res)): ?>
                    <option value="<?php echo $row['student_id'] . '-' . $row['class_id']; ?>">
                        <?php echo "(".$row['student_id'].")".$row['student_name'] . " - صنف " . $row['course_title']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- فیلدهای مخفی برای تفکیک ایدی شاگرد و صنف هنگام ارسال فرم -->
        <input type="hidden" name="student_id" id="hidden_student_id">
        <input type="hidden" name="class_id" id="hidden_class_id">

        <div class="form-group">
            <label>مبلغ دریافتی (به افغانی):</label>
            <input type="number" step="0.01" name="amount" placeholder="مثال: 1500" required>
        </div>

        <button type="submit">ثبت تراکنش مالی</button>
    </form>

    <a href="../dashboard.php" class="back-link">بازگشت به داشبورد اصلی</a>
</div>

<script>
// این اسکریپت کوچک جادویی، مقدار انتخابی منو کشویی (مثل 3-1) را تفکیک کرده و در فیلدهای مخفی می‌گذارد
function updateHiddenFields() {
    var selectElement = document.getElementById("student_enrollment").value;
    if(selectElement) {
        var ids = selectElement.split('-');
        document.getElementById("hidden_student_id").value = ids[0];
        document.getElementById("hidden_class_id").value = ids[1];
    }
}
</script>

</body>
</html>
