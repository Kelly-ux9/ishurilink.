<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') { header("Location: ../login.php"); exit; }
$student_id = $_SESSION['user']['id'];
$assignment_id = intval($_GET['id'] ?? 0);
$msg = '';
if (isset($_POST['submit'])) {
    if (!empty($_FILES['file']['tmp_name'])) {
        $updir = "../assets/uploads/submissions/";
        if (!is_dir($updir)) mkdir($updir,0775,true);
        $fn = time().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/','_',basename($_FILES['file']['name']));
        $dest = $updir.$fn;
        if (move_uploaded_file($_FILES['file']['tmp_name'],$dest)) {
            mysqli_query($conn, "INSERT INTO submissions(assignment_id, student_id, file_path, submitted_at) VALUES('$assignment_id','$student_id','$dest',NOW())");
            $msg = "Submitted.";
        } else $msg = "Upload failed.";
    } else $msg = "Select file.";
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Submit Assignment</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="home-box">
  <h2>Submit Assignment</h2>
  <?php if($msg) echo "<p class='info'>$msg</p>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required><br>
    <button name="submit" type="submit">Submit</button>
  </form>
  <p><a href="assignments.php">Back</a></p>
</div>
</body></html>
