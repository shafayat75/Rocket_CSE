<?php
session_start();
include "../php/config.php";

$res = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Notices</title>
  <link rel="stylesheet" href="../css/home.css">
</head>
<body style="padding:20px;">
  <h2>Notices</h2>

  <?php if(mysqli_num_rows($res) === 0): ?>
    <p>No notices yet.</p>
  <?php else: ?>
    <?php while($n = mysqli_fetch_assoc($res)): ?>
      <div style="border:1px solid #ddd; padding:15px; margin:10px 0; border-radius:8px;">
        <h3 style="margin:0;"><?php echo htmlspecialchars($n['title']); ?></h3>
        <p style="white-space:pre-line;"><?php echo htmlspecialchars($n['body']); ?></p>
        <small>Posted: <?php echo $n['created_at']; ?></small>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

</body>
</html>
