<?php
include "config/db.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $district = $_POST['district'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    mysqli_query($conn, "INSERT INTO schools(name,district,email,password) VALUES('$name','$district','$email','$pass')");
    $school_id = mysqli_insert_id($conn);

    // Create admin account automatically
    mysqli_query($conn, "INSERT INTO users(school_id, fullname, email, role, password) 
    VALUES('$school_id', '$name School Admin', '$email', 'admin', '$pass')");

    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register School - IshuriLink</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-box">
  <h2>Register a School</h2>

  <form method="POST">
    <input type="text" name="name" placeholder="School Name" required><br>
    <input type="text" name="district" placeholder="District" required><br>
    <input type="email" name="email" placeholder="School Email" required><br>
    <input type="password" name="password" placeholder="Create Password" required><br>
    <button type="submit" name="register">Register</button>
  </form>
</div>

</body>
</html>
