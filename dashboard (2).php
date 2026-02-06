<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }
$teacher_id = $_SESSION['user']['id'];
// materials & assignments counts
$mcount = mysqli_query($conn, "SELECT COUNT(*) AS c FROM materials WHERE teacher_id='$teacher_id'")->fetch_assoc()['c'];
$acount = mysqli_query($conn, "SELECT COUNT(*) AS c FROM assignments WHERE teacher_id='$teacher_id'")->fetch_assoc()['c'];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Teacher Dashboard</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Teacher Dashboard</h2>
  <p>Welcome, <?=htmlspecialchars($_SESSION['user']['fullname'])?></p>
  <p>Materials: <?= $mcount ?> | Assignments: <?= $acount ?></p>
  <p>
    <a href="upload_material.php" class="btn">Upload Material</a>
    <a href="give_assignment.php" class="btn">Give Assignment</a>
    <a href="view_submissions.php" class="btn">View Submissions</a>
    <a href="forums.php" class="btn">Forums</a>
    <a href="../logout.php" class="btn">Logout</a>
  </p>
</div>
</body></html>
