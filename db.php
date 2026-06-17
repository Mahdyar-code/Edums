<?php
$conn = mysqli_connect("localhost","root","","educational_center_db");
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

else{
    // echo "Connected successfully";
    
// $name ='mosa';
// $email = 'mosa@gmail.com';
// $password = '123456';
// $rol = 'admin';

//     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// $query = "INSERT INTO users (name, email, password,role)
// VALUES ('$name', '$email', '$hashed_password','$rol')";

// mysqli_query($conn, $query);
}
mysqli_set_charset($conn, "utf8");
?>