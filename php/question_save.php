<?php
session_start();
include "config.php";

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: ../view/login.html");
  exit;
}

$quiz_id = intval($_POST['quiz_id']);
$question = mysqli_real_escape_string($conn, $_POST['question']);
$a = mysqli_real_escape_string($conn, $_POST['option_a']);
$b = mysqli_real_escape_string($conn, $_POST['option_b']);
$c = mysqli_real_escape_string($conn, $_POST['option_c']);
$d = mysqli_real_escape_string($conn, $_POST['option_d']);
$correct = $_POST['correct_option'];
$marks = intval($_POST['marks']);

mysqli_query($conn,
  "INSERT INTO quiz_questions
   (quiz_id, question, option_a, option_b, option_c, option_d, correct_option, marks)
   VALUES ($quiz_id, '$question', '$a', '$b', '$c', '$d', '$correct', $marks)"
);

header("Location: ../view/teacher_add_questions.php?quiz_id=$quiz_id");
exit;
