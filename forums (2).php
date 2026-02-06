<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
if (isset($_POST['post'])) {
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    $uid = $_SESSION['user']['id'];
    mysqli_query($conn, "INSERT INTO forum_posts(school_id,user_id,message,created_at) VALUES('$school_id','$uid','$msg',NOW())");
}
$posts = mysqli_query($conn, "SELECT f.*, u.fullname FROM forum_posts f LEFT JOIN users u ON f.user_id=u.id WHERE f.school_id='$school_id' ORDER BY f.created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Forums</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>School Forum</h2>
  <form method="POST">
    <textarea name="message" placeholder="Write message" style="width:85%;height:80px;"></textarea><br>
    <button name="post" type="submit">Post</button>
  </form>
  <h3>Recent</h3>
  <?php while($p = mysqli_fetch_assoc($posts)) { ?>
    <div style="text-align:left;border-bottom:1px solid #eee;padding:8px;">
      <small><?= $p['created_at'] ?> — <strong><?= htmlspecialchars($p['fullname']) ?></strong></small>
      <p><?= nl2br(htmlspecialchars($p['message'])) ?></p>
    </div>
  <?php } ?>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
