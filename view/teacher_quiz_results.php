<?php
session_start();
include "../php/config.php";

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: login.html");
  exit;
}

// All attempts with quiz + student info
$res = mysqli_query($conn, "
  SELECT 
    qa.quiz_id,
    qa.student_id,
    qa.score,
    qa.submitted_at,
    q.title AS quiz_title,
    q.course_code,
    q.total_marks,
    u.fullname AS student_name,
    u.email AS student_email
  FROM quiz_attempts qa
  JOIN quizzes q ON q.id = qa.quiz_id
  JOIN users u ON u.id = qa.student_id
  ORDER BY qa.submitted_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Quiz Results</title>
</head>
<body style="padding:20px;">
  <h2>Student Quiz Results</h2>

  <?php if(mysqli_num_rows($res) === 0): ?>
    <p>No student has submitted any quiz yet.</p>
  <?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
      <tr>
        <th>Student</th>
        <th>Email</th>
        <th>Quiz</th>
        <th>Course</th>
        <th>Score</th>
        <th>Total</th>
        <th>Submitted At</th>
      </tr>

      <?php while($row = mysqli_fetch_assoc($res)): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['student_name']); ?></td>
          <td><?php echo htmlspecialchars($row['student_email']); ?></td>
          <td><?php echo htmlspecialchars($row['quiz_title']); ?></td>
          <td><?php echo htmlspecialchars($row['course_code']); ?></td>
          <td><b><?php echo htmlspecialchars($row['score']); ?></b></td>
          <td><?php echo htmlspecialchars($row['total_marks']); ?></td>
          <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>

  <br>
  <a href="teacher_portal.php">← Back to Teacher Portal</a>
</body>
</html>
