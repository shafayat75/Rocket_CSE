<?php
session_start();
include "config.php";

if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: ../view/login.html");
  exit;
}

$title = mysqli_real_escape_string($conn, $_POST['title']);
$course = mysqli_real_escape_string($conn, $_POST['course_code']);
$total = intval($_POST['total_marks']);

mysqli_query($conn,
  "INSERT INTO quizzes (title, course_code, total_marks)
   VALUES ('$title', '$course', $total)"
);

$quiz_id = mysqli_insert_id($conn);

// Redirect to add questions
header("Location: ../view/teacher_add_questions.php?quiz_id=$quiz_id");
exit;
