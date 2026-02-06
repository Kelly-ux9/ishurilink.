<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }

$msg = '';
if (isset($_POST['give'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $due = $_POST['deadline'] ?: null;
    $filePath = null;
    if (!empty($_FILES['file']['tmp_name'])) {
        $updir = "../assets/uploads/assignments/";
        if (!is_dir($updir)) mkdir($updir,0775,true);
        $fn = time().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/','_',basename($_FILES['file']['name']));
        $dest = $updir.$fn;
        if (move_uploaded_file($_FILES['file']['tmp_name'],$dest)) $filePath = $dest;
    }
    $tid = $_SESSION['user']['id'];
    $dq = "INSERT INTO assignments(teacher_id,title,description,deadline,file_path,created_at) VALUES('$tid','$title','$desc','$due','$filePath',NOW())";
    if (mysqli_query($conn,$dq)) $msg = "Assignment created.";
    else $msg = "Error.";
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Give Assignment</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Create Assignment</h2>
  <?php if($msg) echo "<p class='info'>$msg</p>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="description" placeholder="Description" style="width:85%;height:80px;"></textarea><br>
    <input type="date" name="deadline"><br>
    <input type="file" name="file"><br>
    <button name="give" type="submit">Create</button>
  </form>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
