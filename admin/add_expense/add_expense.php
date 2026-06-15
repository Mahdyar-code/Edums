<?php
session_start();
require_once '../../db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../../login.php");
    exit();
}
$message = "";
if($_SERVER['REQUEST_METHOD'] =="POST"){
     $title = mysqli_real_escape_string($conn, $_POST['title']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);
      $amount = mysqli_real_escape_string($conn, $_POST['amount']);
       $expense_date = mysqli_real_escape_string($conn, $_POST['expense_date']);
       $description = mysqli_real_escape_string($conn, $_POST['description']);


    $query = "INSERT INTO expenses (title, category, amount, expense_date, description) 
              VALUES ('$title', '$category', '$amount', '$expense_date', '$description')";

     if (mysqli_query($conn, $query)) {
        $message = "<div class='success-msg'>هزینه با موفقیت در سیستم ثبت شد .</div>";
    } else {
        $message = "<div class='error-msg'>خطا در ثبت اطلاعات: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت هزینه های جاری</title>
    <link rel="stylesheet" href="add_expense.css">
</head>
<body>
    <div class="form_container">
        <h2>ثبت مصارف و مخاریج روزانه</h2>
        <?php  echo $message; ?>

        <form action="add_expense.php" method="post">
            <div class="form_group">
                <label for="">عنوان هزینه</label>
                <input type="text" name="title" placeholder="مثال: خرید مواد غذایی رفاهی" required>
            </div>
            <div class="form_group">
                <label>دسته بندی مصارف</label>
                <select name="category" required >
                    <option value="food">مصارف غذا و رفاهی</option>
                        <option value="bills">قبوض (برق، آب، انترنت)</option>
                            <option value="salary">معاش و دستمزد اساتید/کارکنان</option>
                                <option value="rent">کرایه ساختمان مرکز</option>
                                 <option value="equipment">تجهیزات و مصارف اداری</option>
                                <option value="other">سایر مصارف...</option>
                                
    
                </select>
            </div>
            <div class="form_group">
                <label>مبلغ هزینه(افغانی)</label>
                <input type="number" step="0.01" name="amount" placeholder="مقدار عددی دقیق" required>
            </div>
            <div class="form group">
                <label>تاریخ هزینه</label>
                <input type="date" name="expense_date" value="<?php  echo date('y-m-d')  ?>" required>
            </div>
            <div class="form_group">
                <label>توضیحات تکمیلی:</label>
                <textarea name="description" placeholder="جزئیات بیشتر درباره این مصرف..."></textarea>
            </div>
            <button type="submit" > ثبت در بخش مالی</button>
        </form>
        <a href="../dashboard.php" class="back_link">برگشت به داشبورد اصلی</a>
    </div>
</body>
</html>