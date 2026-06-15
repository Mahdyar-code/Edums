<?php
session_start();
require_once "db.php";
$error = "";

// بررسی اینکه آیا کاربر دکمه ورود را زده است یا خیر
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];

    $query = "select * from users where email ='$email' ";
    $result = mysqli_query($conn,$query);
    
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            if($user['role'] == 'admin'){
                header("Location: admin/dashboard.php");
                }
                elseif ($user['role'] == 'teacher'){
                    header("Location: teacher/dashboard.php");
            }
            elseif ($user['role']== 'student'){
                header("Location: student/dashboard.php");
            }
            exit();
        }
        else{
            $error = "رمز عبور اشتباه است";
        }
      
    }
    else {
        $error = "کاربری با این ایمیل یافت نشد!";
    }

}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم مدریت  مرکز اموزشی</title>
    <link rel="stylesheet" href="login.css">
</head>
<style>
    
body {
  font-family: Tahoma, sans-serif;
  background: #f1f5f9;
  color: #0f172a;

  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}
.login-box {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 18px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  width: 350px;
  text-align: center;
}
input{
    background:  #f1f5f9;
}
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #e2e8f0;
  border-radius: 4px;
}
button {
  width: 100%;
  margin: 10px;
  padding: 10px;
  background-color: #2563eb;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
.error-msg {
  color: red;
  margin-bottom: 15px;
}

</style>
<body>
    <div class="login-box">
        <h2>ورود به سیستم</h2>
        <?php if(!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
            <input type="password" name="password" placeholder="رمز عبور خود را وارد کنید" required>
            <button type="submit"> ورود</button>
        </form>
    </div>
    
</body>
</html>