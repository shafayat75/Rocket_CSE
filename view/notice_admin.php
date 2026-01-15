<?php
session_start();
if(($_SESSION['user_role'] ?? '') !== 'admin'){
  header("Location: login.html");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Post Notice</title>
  <link rel="stylesheet" href="../css/admin_panel.css">
</head>
<body style="padding:20px;">
  <h2>Post a Notice</h2>

  <?php if(isset($_GET['success'])): ?>
    <p style="color:green;">Notice posted successfully!</p>
  <?php elseif(isset($_GET['error'])): ?>
    <p style="color:red;">Something went wrong!</p>
  <?php endif; ?>

  <form method="POST" action="../php/notice_save.php">
    <label>Title</label><br>
    <input type="text" name="title" required style="width:60%;padding:8px;"><br><br>

    <label>Notice Details</label><br>
    <textarea name="body" rows="6" required style="width:60%;padding:8px;"></textarea><br><br>

    <button type="submit" style="padding:10px 20px;">Post</button>
  </form>
</body>
</html>
