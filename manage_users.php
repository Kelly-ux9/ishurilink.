<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];

// delete user if requested
if (isset($_GET['delete'])) {
    $uid = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE id='$uid' AND school_id='$school_id'");
    header("Location: manage_users.php");
    exit;
}

$users = mysqli_query($conn, "SELECT * FROM users WHERE school_id='$school_id' ORDER BY created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Manage Users</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Manage Users</h2>
  <table style="width:100%;border-collapse:collapse;">
    <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>
    <?php $i=1; while($u = mysqli_fetch_assoc($users)) { ?>
      <tr style="border-bottom:1px solid #eee;">
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($u['fullname']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= $u['role'] ?></td>
        <td><a href="manage_users.php?delete=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a></td>
      </tr>
    <?php } ?>
  </table>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body>
</html>
