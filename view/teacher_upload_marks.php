<?php
session_start();
if(($_SESSION['user_role'] ?? '') !== 'teacher'){
  header("Location: login.html");
  exit;
}

include "../php/config.php";

$students = mysqli_query($conn, "SELECT id, fullname, email FROM users ORDER BY fullname ASC");
$courses  = mysqli_query($conn, "SELECT course_code, course_name FROM courses ORDER BY course_code ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Upload Marks</title>
  <link rel="stylesheet" href="../css/upload_notes.css">
</head>
<body style="padding:20px;">
  <h2>Upload Marks</h2>

  <?php if(isset($_GET['success'])): ?>
    <p style="color:green;">Marks saved!</p>
  <?php elseif(isset($_GET['error'])): ?>
    <p style="color:red;">Failed!</p>
  <?php endif; ?>

  <form method="POST" action="../php/marks_save.php">
    <label>Student</label><br>
    <select name="student_id" required style="padding:8px; width:320px;">
      <option value="">-- Select Student --</option>
      <?php while($s = mysqli_fetch_assoc($students)): ?>
        <option value="<?php echo $s['id']; ?>">
          <?php echo htmlspecialchars($s['fullname']." (".$s['email'].")"); ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <label>Course</label><br>
    <select name="course_code" required style="padding:8px; width:320px;">
      <option value="">-- Select Course --</option>
      <?php while($c = mysqli_fetch_assoc($courses)): ?>
        <option value="<?php echo htmlspecialchars($c['course_code']); ?>">
          <?php echo htmlspecialchars($c['course_code']." - ".$c['course_name']); ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <label>Semester</label><br>
    <input type="text" name="semester" required placeholder="e.g. Fall 2025" style="padding:8px; width:320px;"><br><br>

    <label>Mark</label><br>
    <input type="number" step="0.01" name="mark" required style="padding:8px; width:320px;"><br><br>

    <button type="submit" style="padding:10px 20px;">Save</button>
  </form>
</body>
</html>
