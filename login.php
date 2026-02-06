<?php
session_start();
include "config/db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

    if (mysqli_num_rows($q) == 1) {
        $user = mysqli_fetch_assoc($q);
        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') header("Location: school_admin/dashboard.php");
        if ($user['role'] == 'teacher') header("Location: teacher/dashboard.php");
        if ($user['role'] == 'student') header("Location: student/dashboard.php");
    } 
    else $error = "Wrong email or password!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>IshuriLink Login</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-box">
  <h2>Login</h2>

  <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
  </form>
</div>

</body>
</html>
