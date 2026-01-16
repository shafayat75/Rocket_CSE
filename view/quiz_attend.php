<?php
session_start();
include "../php/config.php";

// Student login check
if (($_SESSION['user_role'] ?? '') !== 'student') {
  header("Location: login.html");
  exit;
}

$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quizzes list
$quizzes = mysqli_query($conn, "SELECT id, title, course_code, total_marks, created_at FROM quizzes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Attend Quiz</title>
  <link rel="stylesheet" href="../css/home.css">
</head>
<body style="padding:20px;">

<h2>Attend Quiz</h2>

<?php if ($quiz_id <= 0): ?>
  <!-- QUIZ LIST -->
  <p>Select a quiz to start:</p>

  <?php if (mysqli_num_rows($quizzes) === 0): ?>
    <p style="color:red;">No quizzes available.</p>
  <?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
      <tr>
        <th>Title</th>
        <th>Course</th>
        <th>Total Marks</th>
        <th>Action</th>
      </tr>
      <?php while($q = mysqli_fetch_assoc($quizzes)): ?>
        <tr>
          <td><?php echo htmlspecialchars($q['title']); ?></td>
          <td><?php echo htmlspecialchars($q['course_code']); ?></td>
          <td><?php echo htmlspecialchars($q['total_marks']); ?></td>
          <td>
            <a href="quiz_attend.php?quiz_id=<?php echo (int)$q['id']; ?>" style="padding:6px 10px; border:1px solid #333; border-radius:6px; text-decoration:none;">
              Start
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>

<?php else: ?>

  <?php
  // Fetch quiz + questions
  $quizRes = mysqli_query($conn, "SELECT * FROM quizzes WHERE id=$quiz_id LIMIT 1");
  $quiz = mysqli_fetch_assoc($quizRes);

  if (!$quiz) {
    echo "<p style='color:red;'>Invalid quiz.</p>";
    echo "<a href='quiz_attend.php'>Back</a>";
    exit;
  }

  $questions = mysqli_query($conn, "SELECT * FROM quiz_questions WHERE quiz_id=$quiz_id ORDER BY id ASC");
  if (mysqli_num_rows($questions) === 0) {
    echo "<p style='color:red;'>No questions found for this quiz.</p>";
    echo "<a href='quiz_attend.php'>Back</a>";
    exit;
  }
  ?>

  <!-- QUIZ QUESTIONS -->
  <h3><?php echo htmlspecialchars($quiz['title']); ?> (<?php echo htmlspecialchars($quiz['course_code']); ?>)</h3>
  <p>Total Marks: <?php echo (int)$quiz['total_marks']; ?></p>

  <form method="POST" action="../php/quiz_submit.php">
    <input type="hidden" name="quiz_id" value="<?php echo (int)$quiz_id; ?>">

    <?php
    $i = 1;
    while($qs = mysqli_fetch_assoc($questions)):
      $qid = (int)$qs['id'];
    ?>
      <div style="border:1px solid #ddd; padding:12px; margin:12px 0; border-radius:10px;">
        <p style="margin:0 0 10px 0;">
          <b>Q<?php echo $i; ?>.</b> <?php echo htmlspecialchars($qs['question']); ?>
          <span style="color:#666;">(<?php echo (int)$qs['marks']; ?> mark)</span>
        </p>

        <label>
          <input type="radio" name="answers[<?php echo $qid; ?>]" value="A" required>
          A) <?php echo htmlspecialchars($qs['option_a']); ?>
        </label><br>

        <label>
          <input type="radio" name="answers[<?php echo $qid; ?>]" value="B" required>
          B) <?php echo htmlspecialchars($qs['option_b']); ?>
        </label><br>

        <label>
          <input type="radio" name="answers[<?php echo $qid; ?>]" value="C" required>
          C) <?php echo htmlspecialchars($qs['option_c']); ?>
        </label><br>

        <label>
          <input type="radio" name="answers[<?php echo $qid; ?>]" value="D" required>
          D) <?php echo htmlspecialchars($qs['option_d']); ?>
        </label>
      </div>
    <?php
      $i++;
    endwhile;
    ?>

    <button type="submit" style="padding:12px 18px;">Submit Quiz</button>
    <a href="quiz_attend.php" style="margin-left:10px;">Cancel</a>
  </form>

<?php endif; ?>

</body>
</html>
