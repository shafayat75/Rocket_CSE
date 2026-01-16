<?php
session_start();
include "config.php";

if(($_SESSION['user_role'] ?? '') !== 'teacher'){
  header("Location: ../view/login.html");
  exit;
}

$teacher_name = $_SESSION['fullname'] ?? 'Teacher';

if(isset($_POST['student_id'], $_POST['course_code'], $_POST['semester'], $_POST['mark'])){
  $student_id  = intval($_POST['student_id']);
  $course_code = mysqli_real_escape_string($conn, trim($_POST['course_code']));
  $semester    = mysqli_real_escape_string($conn, trim($_POST['semester']));
  $mark        = floatval($_POST['mark']);
  $tname       = mysqli_real_escape_string($conn, $teacher_name);

  $q = "INSERT INTO marks(student_id, course_code, semester, mark, teacher_name)
        VALUES($student_id, '$course_code', '$semester', $mark, '$tname')
        ON DUPLICATE KEY UPDATE mark=VALUES(mark), teacher_name=VALUES(teacher_name)";

  if(mysqli_query($conn, $q)){
    header("Location: ../view/teacher_upload_marks.php?success=1");
    exit;
  }
}

header("Location: ../view/teacher_upload_marks.php?error=1");
