<?php
session_start();
if(($_SESSION['user_role'] ?? '') !== 'student'){
  header("Location: login.html");
  exit;
}

include "../php/config.php";
$student_id = intval($_SESSION['user_id'] ?? 0);

$res = mysqli_query($conn, "
  SELECT course_code, semester, mark, teacher_name, created_at
  FROM marks
  WHERE student_id = $student_id
  ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Marks</title>
  <link rel="stylesheet" href="../css/home.css">
</head>
<body style="padding:20px;">
  <h2>My Marks</h2>

  <?php if(mysqli_num_rows($res) === 0): ?>
    <p>No marks uploaded yet.</p>
  <?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
      <tr>
        <th>Course Code</th>
        <th>Semester</th>
        <th>Mark</th>
        <th>Teacher</th>
        <th>Date</th>
      </tr>
      <?php while($m = mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?php echo htmlspecialchars($m['course_code']); ?></td>
        <td><?php echo htmlspecialchars($m['semester']); ?></td>
        <td><?php echo htmlspecialchars($m['mark']); ?></td>
        <td><?php echo htmlspecialchars($m['teacher_name']); ?></td>
        <td><?php echo htmlspecialchars($m['created_at']); ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>
</body>
</html>
