<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }
$tid = $_SESSION['user']['id'];
$assigns = mysqli_query($conn, "SELECT * FROM assignments WHERE teacher_id='$tid' ORDER BY created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Your Assignments</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Your Assignments</h2>
  <?php while($a = mysqli_fetch_assoc($assigns)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <strong><?= htmlspecialchars($a['title']) ?></strong> - <?= $a['deadline'] ?> <br>
      <?php if($a['file_path']) echo "<a href='".htmlspecialchars($a['file_path'])."' target='_blank'>Download file</a>"; ?>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
