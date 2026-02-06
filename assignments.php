<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
$assigns = mysqli_query($conn, "SELECT a.*, u.fullname FROM assignments a LEFT JOIN users u ON a.teacher_id=u.id WHERE u.school_id='$school_id' ORDER BY a.created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Assignments</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Assignments</h2>
  <?php while($a = mysqli_fetch_assoc($assigns)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <strong><?= htmlspecialchars($a['title']) ?></strong> by <?= htmlspecialchars($a['fullname']) ?> <br>
      Due: <?= $a['deadline'] ?><br>
      <?php if($a['file_path']) echo "<a href='".htmlspecialchars($a['file_path'])."' target='_blank'>Download</a>"; ?>
      <p><a href="submit_assignment.php?id=<?= $a['id'] ?>">Submit</a></p>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
