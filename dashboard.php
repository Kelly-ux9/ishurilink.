<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php"); exit;
}
$school_id = $_SESSION['user']['school_id'];

// counts
$teachers = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE school_id='$school_id' AND role='teacher'")->fetch_assoc()['c'];
$students = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE school_id='$school_id' AND role='student'")->fetch_assoc()['c'];
$materials = mysqli_query($conn, "SELECT COUNT(*) AS c FROM materials m LEFT JOIN users u ON m.teacher_id=u.id WHERE u.school_id='$school_id'")->fetch_assoc()['c'];
$assigns = mysqli_query($conn, "SELECT COUNT(*) AS c FROM assignments a LEFT JOIN users u ON a.teacher_id=u.id WHERE u.school_id='$school_id'")->fetch_assoc()['c'];
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>School Admin - Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>School Admin Dashboard</h2>
  <p>Welcome, <?=htmlspecialchars($_SESSION['user']['fullname'])?></p>
  <p>Teachers: <?= $teachers ?> | Students: <?= $students ?> | Materials: <?= $materials ?> | Assignments: <?= $assigns ?></p>
  <p>
    <a href="add_teacher.php" class="btn">Add Teacher</a>
    <a href="add_student.php" class="btn">Add Student</a>
    <a href="manage_users.php" class="btn">Manage Users</a>
      <a href="../forum.php" class="btn">💬 Forum</a>

    <a href="announcements.php" class="btn">Announcements</a>
    <a href="../logout.php" class="btn">Logout</a>
  </p>
</div>
</body>
</html>
