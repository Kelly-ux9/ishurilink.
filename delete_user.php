<?php
session_start();
include "../config/db.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { header("Location: ../login.php"); exit; }
$school_id = $_SESSION['user']['school_id'];
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM users WHERE id='$id' AND school_id='$school_id'");
}
header("Location: manage_users.php");
