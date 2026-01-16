<?php
session_start();
include('../php/myaccount.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Account</title>
  <link rel="stylesheet" href="../css/myaccount.css">
</head>
<body>
  <!-- Back Button -->
  <a class="back" href="../view/student_portal.php">
    <img class="back__icon" src="../images/back.png" alt="Back">
  </a>

  <div class="account-container">
    <h1>My Account</h1>

    <!-- Profile Photo Upload Form -->
    <form action="" method="post" enctype="multipart/form-data" class="photo-form">
      <h2>Profile Photo</h2>
      <div class="photo-box">
        <img id="preview" src="<?php echo $photoSrc; ?>" alt="Preview">
      </div>
      <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
      <button type="submit" name="upload_photo" class="update-btn">Upload Photo</button>
    </form>

    <!-- Password Change Form -->
    <form action="" method="post" class="password-form">
      <h2>Change Password</h2>
      <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
      </div>

      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>
      </div>

      <button type="submit" name="change_password" class="update-btn">Update Password</button>

      <!-- ✅ Show Messages -->
      <?php if (!empty($password_error)): ?>
        <p class="error"><?php echo $password_error; ?></p>
      <?php elseif (!empty($password_success)): ?>
        <p class="success"><?php echo $password_success; ?></p>
      <?php endif; ?>
    </form>
  </div>

  <script src="../js/myaccount.js"></script>
</body>
</html>
