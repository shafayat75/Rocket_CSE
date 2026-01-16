<?php
// view/teacher_my_account.php
session_start();

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: login.html");
  exit;
}

$teacherName   = $_SESSION['fullname'] ?? 'Teacher';
$teacherEmail  = $_SESSION['email'] ?? 'teacher@gmail.com';
$teacherAvatar = $_SESSION['avatar'] ?? 'https://i.pravatar.cc/120?img=12';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Teacher My Account</title>
  <link rel="stylesheet" href="../css/teacher_portal.css">
</head>
<body style="padding:20px;">
  <h2>My Account (Teacher)</h2>

  <div style="display:flex; align-items:center; gap:16px;">
    <img src="<?php echo htmlspecialchars($teacherAvatar); ?>" style="width:90px;height:90px;border-radius:50%;" alt="avatar">
    <div>
      <p><b>Name:</b> <?php echo htmlspecialchars($teacherName); ?></p>
      <p><b>Email:</b> <?php echo htmlspecialchars($teacherEmail); ?></p>
      <p><b>Role:</b> Teacher</p>
    </div>
  </div>

  <br>
  <a href="teacher_portal.php">← Back to Dashboard</a>
</body>
</html>
