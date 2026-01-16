<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Teacher Manager</title>
  <link rel="stylesheet" href="../css/teacher.css" />
</head>
<body>
  <div class="container">
    <header>
      <div class="title">Teacher Details</div>
      <button id="addTeacherBtn">Add Teacher</button>
    </header>

    <table id="teacherTable">
      <thead>
        <tr>
          <th>Serial no</th>
          <th>Teacher Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h2 id="formTitle">Add Teacher</h2>
      <form id="teacherForm">
        <input type="hidden" id="teacherId" />
        <label>Teacher Name</label>
        <input type="text" id="teacherName" required />
        <label>Email</label>
        <input type="text" id="teacherEmail" required />
        <label>Password</label>
        <input type="text" id="teacherPassword" required />
        <button type="submit" id="submitBtn">Add Teacher</button>
      </form>
    </div>
  </div>

  <script src="../js/teacher.js"></script>
</body>
</html>
