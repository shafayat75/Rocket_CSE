<?php
session_start();
include "../php/config.php";

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: login.html");
  exit;
}

$quiz_id = intval($_GET['quiz_id'] ?? 0);
if ($quiz_id <= 0) {
  echo "Invalid quiz";
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Questions</title>
</head>
<body style="padding:20px;">

<h2>Add Question</h2>

<form method="POST" action="../php/question_save.php">
  <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

  <label>Question</label><br>
  <textarea name="question" required></textarea><br><br>

  <label>Option A</label><br>
  <input type="text" name="option_a" required><br>

  <label>Option B</label><br>
  <input type="text" name="option_b" required><br>

  <label>Option C</label><br>
  <input type="text" name="option_c" required><br>

  <label>Option D</label><br>
  <input type="text" name="option_d" required><br><br>

  <label>Correct Option</label><br>
  <select name="correct_option">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
  </select><br><br>

  <label>Marks</label><br>
  <input type="number" name="marks" value="1"><br><br>

  <button type="submit">Save Question</button>
</form>

<br>
<a href="teacher_add_questions.php?quiz_id=<?php echo $quiz_id; ?>">➕ Add Another Question</a><br>
<a href="teacher_portal.php">Finish</a>

</body>
</html>

