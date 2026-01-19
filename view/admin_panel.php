<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../css/admin_panel.css" />
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <ul class="menu">
        <li><a href="../view/dashboard.php" target="content-frame">Dashboard</a></li>
        <li><a href="../view/courses.php" target="content-frame">Courses</a></li>
        <li><a href="../view/student_info.php" target="content-frame">Student Info</a></li>
        <li><a href="../view/teacher.php" target="content-frame">Teacher Info</a></li>
        <li><a href="../view/notice_admin.php" target="content-frame">Notices</a></li>

        <li><a href="../view/login.html">Sign Out</a></li>
      </ul>
    </div>

    <!-- Content Area -->
    <div class="content">
      <iframe name="content-frame" src=""></iframe>
    </div>
  </div>

</body>
</html>
