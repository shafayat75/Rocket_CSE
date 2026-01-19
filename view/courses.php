<?php
include('../php/courses.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Course Manager</title>
<link rel="stylesheet" href="../css/courses.css"/>
</head>
<body>
<div class="container">
  <header>
    <div class="title">Courses</div>
    <button id="addCourseBtn">Add Course</button>
  </header>

  <table id="coursesTable">
    <thead>
      <tr>
        <th>Serial no</th>
        <th>Course Name</th>
        <th>Course Code</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data will be inserted here -->
    </tbody>
  </table>
</div>

<!-- Modal form -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span id="closeModal" class="close">&times;</span>
    <h2 id="formTitle">Add Course</h2>
    <form id="courseForm">
      <input type="hidden" id="courseId" />
      <label>Course Name</label>
      <input type="text" id="courseName" required />
      <label>Course Code</label>
      <input type="text" id="courseCode" required />
      <button type="submit" id="submitBtn">Add Course</button>
    </form>
  </div>
</div>

<script src="../js/courses.js"></script>
</body>
</html>
