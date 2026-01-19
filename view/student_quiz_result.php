<?php
session_start();
include "../php/config.php";

if (($_SESSION['user_role'] ?? '') !== 'student') {
  header("Location: login.html");
  exit;
}

$student_id = intval($_SESSION['user_id'] ?? 0);
$quiz_id = intval($_GET['quiz_id'] ?? 0);

$res = mysqli_query($conn, "
  SELECT q.title, q.course_code, q.total_marks, qa.score, qa.submitted_at
  FROM quiz_attempts qa
  JOIN quizzes q ON q.id = qa.quiz_id
  WHERE qa.student_id = $student_id AND qa.quiz_id = $quiz_id
  LIMIT 1
");

$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Quiz Result</title></head>
<body style="padding:20px;">
  <h2>Quiz Result</h2>

  <?php if(!$row): ?>
    <p>No result found.</p>
  <?php else: ?>
    <p><b>Quiz:</b> <?php echo htmlspecialchars($row['title']); ?></p>
    <p><b>Course:</b> <?php echo htmlspecialchars($row['course_code']); ?></p>
    <p><b>Score:</b> <?php echo htmlspecialchars($row['score']); ?> / <?php echo htmlspecialchars($row['total_marks']); ?></p>
    <p><b>Submitted:</b> <?php echo htmlspecialchars($row['submitted_at']); ?></p>
  <?php endif; ?>

  <br>
  <a href="quiz_attend.php">Back to Quiz List</a>
</body>
</html>
