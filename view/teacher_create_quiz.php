<?php
session_start();
include "../php/config.php";

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: login.html");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Create Quiz</title>
</head>
<body style="padding:20px;">

<h2>Create Quiz</h2>

<form method="POST" action="../php/quiz_create.php">
  <label>Quiz Title</label><br>
  <input type="text" name="title" required><br><br>

  <label>Course Code</label><br>
  <input type="text" name="course_code" required><br><br>

  <label>Total Marks</label><br>
  <input type="number" name="total_marks" required><br><br>

  <button type="submit">Create Quiz</button>
</form>

</body>
</html>
