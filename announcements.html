<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
$msg = '';
if (isset($_POST['post'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    mysqli_query($conn, "INSERT INTO announcements(school_id,message,created_at) VALUES('$school_id','$message',NOW())");
    $msg = "Announcement posted.";
}
$anns = mysqli_query($conn, "SELECT * FROM announcements WHERE school_id='$school_id' ORDER BY created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Announcements</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Announcements</h2>
  <?php if($msg) echo "<p class='info'>$msg</p>"; ?>
  <form method="POST">
    <textarea name="message" placeholder="Write announcement" required style="width:85%;height:90px;"></textarea><br>
    <button name="post" type="submit">Post</button>
  </form>
  <h3>Recent</h3>
  <?php while($a = mysqli_fetch_assoc($anns)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <small><?= $a['created_at'] ?></small>
      <p><?= nl2br(htmlspecialchars($a['message'])) ?></p>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
