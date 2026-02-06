<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }
$tid = $_SESSION['user']['id'];
// show assignments authored by this teacher
$assigns = mysqli_query($conn, "SELECT * FROM assignments WHERE teacher_id='$tid' ORDER BY created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>View Submissions</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Submissions for your assignments</h2>
  <?php while($a = mysqli_fetch_assoc($assigns)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <strong><?= htmlspecialchars($a['title']) ?></strong> (<?= $a['created_at'] ?>) <br>
      <?php
        $subs = mysqli_query($conn, "SELECT s.*, u.fullname FROM submissions s LEFT JOIN users u ON s.student_id=u.id WHERE s.assignment_id='".$a['id']."' ORDER BY s.submitted_at DESC");
        if (mysqli_num_rows($subs)) {
          echo "<ul>";
          while($s = mysqli_fetch_assoc($subs)) {
            echo "<li>".$s['fullname']." - <a href='".htmlspecialchars($s['file_path'])."' target='_blank'>Download</a> - ".$s['submitted_at']."</li>";
          }
          echo "</ul>";
        } else echo "<p>No submissions yet.</p>";
      ?>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
