<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
$result = mysqli_query($conn, "SELECT m.*, u.fullname FROM materials m LEFT JOIN users u ON m.teacher_id=u.id WHERE u.school_id='$school_id' ORDER BY m.uploaded_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Materials</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Learning Materials</h2>
  <?php while($m = mysqli_fetch_assoc($result)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <strong><?= htmlspecialchars($m['title']) ?></strong><br>
      By <?= htmlspecialchars($m['fullname']) ?> — <?= $m['uploaded_at'] ?><br>
      <?php if($m['file_path']) echo "<a href='".htmlspecialchars($m['file_path'])."' download>Download</a>"; ?>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
