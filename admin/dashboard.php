<?php  
session_start();
require_once '../db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
$name = $_SESSION['user_name'];
// تعداد دوره ها
$res_classes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM classes");
$total_classes = mysqli_fetch_assoc($res_classes)['total'];

//2 تعداد اساتید
$res_teacher = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users where role='teacher'");
$total_teacher=mysqli_fetch_assoc($res_teacher)['total'];


// ۳. تعداد شاگردان
$res_students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'");
$total_students = mysqli_fetch_assoc($res_students)['total'];

$res_employe = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE users.role='employ'");
$total_employe = mysqli_fetch_assoc($res_employe)['total'];
// ۴. کل درآمد
$res_income = mysqli_query($conn, "SELECT SUM(amount) AS total FROM payments");
$total_income = mysqli_fetch_assoc($res_income)['total'] ?? 0;

// ۵. کل مصارف
$res_expenses = mysqli_query($conn, "SELECT SUM(amount) AS total FROM expenses");
$total_expenses = mysqli_fetch_assoc($res_expenses)['total'] ?? 0;

// ۶. درآمد خالص
$net_profit = $total_income - $total_expenses;
?>
<!doctype html>
<html lang="fa" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>سیستم مدیریت مرکز آموزشی</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="dashboard.css" />
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <div class="logo">🎓 EMS</div>

        <ul class="menu">
          <li class="active"><a href="#">🏠 داشبورد</a></li>
          <li><a href="register_user.php">🤵ثبت کاربر جدید</a></li>
          <li><a href="enroll_student/enroll_student.php">👨‍🎓ثبت نام شاگردان</a></li>
          <li><a href="add_course/add_course.php">📚 تشکیل دوره</a></li>
          <li><a href="add_class/add_class.php">🏫 تشکیل صنف</a></li>
          <li><a href="add_payment/add_payment.php">💰 دریافت فس </a></li>
          <li><a href="add_expense/add_expense.php">📉 ثبت هزینه </a></li>
          
          <!-- <li><a href="#">📊 گزارشات</a></li>
          <li><a href="#">⚙️ تنظیمات</a></li> -->
        </ul>
      </div>

      <div class="main">
        <div class="navbar">
          <!-- <input class="search" placeholder="جستجو..." /> -->
           <div class="edu_name">مرکز عالی اموزشی <span>ناجی</span></div>

          <div class="right-box">
            <button class="dark-btn" onclick="toggleDark()">🌙 حالت شب</button>

            <div class="profile"><a href="../login.php">خروج از سیستم</a></div>
          </div>
        </div>

        <div class="hero">
          <h1>خوش آمدید <?php echo $name ?> 👋</h1>

          <p>  تم مدیریت مرکز آموزشی - داشبورد مدیریتی،     برای دیدن جزیات بیشتری هر کارت روی نام آن کلیک کنید.</p>
        </div>

        <div class="stats">
          <div class="card">
            <div class="show">
              <div class="icon blue">👨‍🎓</div>
              <div class="number"><?php echo $total_students   ?></div>
            </div>
            
            <div class="label"><a href="students_list.php">شاگردان</a></div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon green">👨‍🏫</div>
              <div class="number"><?php echo $total_teacher   ?></div>
            </div>
            <div class="label"><a href="teachers_list.php">استادان</a></div>
          </div>

           <div class="card">
            <div class="show">
              <div class="icon red">👷</div>
              <div class="number"><?php echo $total_employe  ?></div>
            </div>
            <div class="label"><a href="employe_list.php">کارمندان</a></div>
          </div>

           <div class="card">
            <div class="show">
              <div class="icon purple">📜</div>
              <div class="icon orange">📃</div>
            </div>
            <div class="label"><a href="grade_list.php">نمرات</a></div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon green">🏫</div>
              <div class="number"><?php echo $total_classes   ?></div>
            </div>
            <div class="label"><a href="class_list.php">صنف های فعال</a></div>
          </div>

          <div class="card">
            <div class="show">
              <div class="icon blue">📈</div>
              <div class="number"><?php echo $total_income   ?></div>
            </div>
            <div class="label"><a href="income_list.php">درآمد</a></div>
          </div>
          <!-- <a href="expenses_list.php"> -->

            <div class="card">
              <div class="show">
                <div class="icon red">📉</div>
                <div class="number"><?php echo $total_expenses   ?></div>
              </div>
              <div class="label"><a href="expenses_list.php">مصارف</a> </div>
            </div>
          <!-- </a> -->
          <div class="card">
            <div class="show">
              <div class="icon orange">💰</div>
              <div class="number"><?php echo $net_profit   ?></div>
            </div>
            <div class="label">درآمد خالص </div>
          </div>
          
        </div>

      </div>
    </div>

    <script>
        function toggleDark() {
        document.body.classList.toggle("dark");
      }
    </script>
  </body>
</html>
