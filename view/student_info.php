<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Manager</title>
  <link rel="stylesheet" href="../css/student_info.css">
</head>
<body>
  <div class="container">
    <header>
      <div class="title">Student Details</div>
      <button id="addstudentBtn">Add User</button>
    </header>

    <table id="coursesTable">
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Password</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <!-- Modal -->
  <div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h2 id="formTitle">Add User</h2>
      <form id="courseForm">
        <input type="hidden" id="courseId">
        <label>Full Name</label>
        <input type="text" id="fullname" required>
        <label>Email</label>
        <input type="email" id="email" required>
        <label>Password</label>
        <input type="password" id="password" required>
        <label>Phone</label>
        <input type="tel" id="phone" required>
        <button type="submit" id="submitBtn">Save</button>
      </form>
    </div>
  </div>

  <script src="../js/student_info.js"></script>
</body>
</html>
