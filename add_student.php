<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
$msg = '';
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");
    if (mysqli_num_rows($q)) $msg = "Email already used.";
    else {
        mysqli_query($conn, "INSERT INTO users(school_id, fullname, email, role, password, created_at) VALUES('$school_id','$name','$email','student','$pass',NOW())");
        $msg = "Student added.";
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Add Student</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Add Student</h2>
  <?php if($msg) echo "<p class='info'>$msg</p>"; ?>
  <form method="POST">
    <input type="text" name="fullname" placeholder="Full name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button name="add" type="submit">Add Student</button>
  </form>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
