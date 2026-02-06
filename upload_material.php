<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'teacher') { header("Location: ../login.php"); exit; }

$msg = '';
if (isset($_POST['upload'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    if (!empty($_FILES['file']['tmp_name'])) {
        $updir = "../assets/uploads/materials/";
        if (!is_dir($updir)) mkdir($updir,0775,true);
        $fn = time().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/','_',basename($_FILES['file']['name']));
        $dest = $updir.$fn;
        if (move_uploaded_file($_FILES['file']['tmp_name'],$dest)) {
            $tid = $_SESSION['user']['id'];
            mysqli_query($conn, "INSERT INTO materials(teacher_id,title,file_path,uploaded_at) VALUES('$tid','$title','$dest',NOW())");
            $msg = "Uploaded.";
        } else $msg = "Upload failed.";
    } else $msg = "Select file.";
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Upload Material</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Upload Material</h2>
  <?php if($msg) echo "<p class='info'>$msg</p>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="file" name="file" required><br>
    <button name="upload" type="submit">Upload</button>
  </form>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
