<?php
session_start();
include "config.php";

// Student login check
if (($_SESSION['user_role'] ?? '') !== 'student') {
  header("Location: ../view/login.html");
  exit;
}

$student_id = intval($_SESSION['user_id'] ?? 0);
$quiz_id = intval($_POST['quiz_id'] ?? 0);
$answers = $_POST['answers'] ?? [];

if ($student_id <= 0 || $quiz_id <= 0) {
  header("Location: ../view/quiz_attend.php?error=1");
  exit;
}

// Fetch questions with correct answers + marks
$qRes = mysqli_query($conn, "SELECT id, correct_option, marks FROM quiz_questions WHERE quiz_id=$quiz_id");
if (!$qRes || mysqli_num_rows($qRes) === 0) {
  header("Location: ../view/quiz_attend.php?quiz_id=$quiz_id&error=2");
  exit;
}

$score = 0;
$total = 0;

// Calculate score
while ($q = mysqli_fetch_assoc($qRes)) {
  $qid = (int)$q['id'];
  $correct = strtoupper(trim($q['correct_option']));
  $marks = (int)$q['marks'];
  $total += $marks;

  $given = isset($answers[$qid]) ? strtoupper(trim($answers[$qid])) : '';

  if ($given === $correct) {
    $score += $marks;
  }
}

// Save attempt (if already attempted, update score)
$scoreSafe = floatval($score);

$sql = "INSERT INTO quiz_attempts (quiz_id, student_id, score)
        VALUES ($quiz_id, $student_id, $scoreSafe)
        ON DUPLICATE KEY UPDATE score = VALUES(score), submitted_at = CURRENT_TIMESTAMP";

mysqli_query($conn, $sql);

// Redirect student to result page (we'll create it next)
header("Location: ../view/student_quiz_result.php?quiz_id=$quiz_id");
exit;
