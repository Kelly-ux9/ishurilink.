<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
// counts
$mat = mysqli_query($conn, "SELECT COUNT(*) AS c FROM materials m LEFT JOIN users u ON m.teacher_id=u.id WHERE u.school_id='$school_id'")->fetch_assoc()['c'];
$ass = mysqli_query($conn, "SELECT COUNT(*) AS c FROM assignments a LEFT JOIN users u ON a.teacher_id=u.id WHERE u.school_id='$school_id'")->fetch_assoc()['c'];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Student Dashboard</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Student Dashboard</h2>
  <p>Welcome, <?=htmlspecialchars($_SESSION['user']['fullname'])?></p>
  <p>Materials: <?= $mat ?> | Assignments: <?= $ass ?></p>
  <p>
    <a href="materials.php" class="btn">Materials</a>
    <a href="assignments.php" class="btn">Assignments</a>
    <a href="forums.php" class="btn">Forums</a>
    <a href="../logout.php" class="btn">Logout</a>
  </p>
</div>
</body></html>
