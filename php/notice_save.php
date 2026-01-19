<?php
session_start();
include "config.php";

if(($_SESSION['user_role'] ?? '') !== 'admin'){
  header("Location: ../view/login.html");
  exit;
}

if(isset($_POST['title'], $_POST['body'])){
  $title = mysqli_real_escape_string($conn, trim($_POST['title']));
  $body  = mysqli_real_escape_string($conn, trim($_POST['body']));

  $q = "INSERT INTO notices(title, body, posted_by) VALUES('$title', '$body', 'admin')";
  if(mysqli_query($conn, $q)){
    header("Location: ../view/notice_admin.php?success=1");
    exit;
  }
}

header("Location: ../view/notice_admin.php?error=1");
