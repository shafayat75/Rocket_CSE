<?php
session_start();
$teacherName   = $_SESSION['username'] ?? 'Teacher';
$teacherAvatar = $_SESSION['avatar']   ?? 'https://i.pravatar.cc/120?img=12';

$messages = $_SESSION['quiz_messages'] ?? [];
unset($_SESSION['quiz_messages']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/teacher_portal.css">
  <link rel="stylesheet" href="../css/upload_quiz.css">
</head>
<body>
  <div class="shell">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand"><div class="blob">T</div><div class="brand-text"><strong>Teacher Portal</strong></div></div>
      <nav class="nav">
        <a href="teacher_portal.php">Dashboard</a>
        <a href="upload_notes.php">Upload Notes</a>
        <a href="upload_video.php">Upload Video</a>
        <a class="active" href="upload_quiz.php">Quizzes</a>
        
        <a href="my_account.php">My Account</a>
        <a href="../view/login.html">Sign Out</a>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <header class="top"><h1>Upload Quiz</h1><div class="spacer"></div></header>

      <?php foreach ($messages as $m): ?>
        <div class="msg <?= $m['type'] ?>"><?= htmlspecialchars($m['text']) ?></div>
      <?php endforeach; ?>

      <section class="panel">
        <form method="post" enctype="multipart/form-data" action="../php/upload_quiz.php">
          <!-- Subject -->
          <div class="row">
            <label for="subject_select">Subject</label>
            <select id="subject_select" name="subject_select" required>
              <option value="">Select subject</option>
              <option>HTML</option><option>CSS</option><option>JavaScript</option>
              <option>PHP</option><option>Python</option><option value="Other">Other</option>
            </select>
            <input type="text" id="subject_other" name="subject_other" placeholder="Enter subject" style="display:none;">
          </div>

          <!-- Duration -->
          <div class="row">
            <label for="duration_select">Duration</label>
            <select id="duration_select" name="duration_select" required>
              <option value="">Select time</option>
              <option value="20">20 minutes</option>
              <option value="30">30 minutes</option>
              <option value="40">40 minutes</option>
              <option value="custom">Custom</option>
            </select>
            <input type="number" min="1" id="duration_other" name="duration_other" placeholder="Minutes" style="display:none; width:120px;">
          </div>

          <!-- Upload OR Paste -->
          <div class="uploader">
            <p><strong>Upload quiz file</strong></p>
            <p>Allowed: csv, txt, pdf, doc, docx, json, zip (max 10MB)</p>
            <input type="file" id="quiz_file" name="quiz_file"
                   accept=".csv,.txt,.pdf,.doc,.docx,.json,.zip" style="display:none;">
            <button type="button" class="btn" id="chooseBtn">Choose File</button>
            <span id="chosenName" class="hint">No file selected</span>
          </div>

          <div class="row" style="flex-direction:column; align-items:stretch;">
            <label for="questions_text">Or paste questions (optional)</label>
            <textarea id="questions_text" name="questions_text" placeholder="Q1) ...&#10;Q2) ..."></textarea>
          </div>

          <div class="row" style="justify-content:flex-end;">
            <button type="submit" class="btn">Upload</button>
          </div>
        </form>
      </section>
    </main>

    <!-- PROFILE -->
    <aside class="profile">
      <div class="card">
        <div class="avatar"><img src="<?= htmlspecialchars($teacherAvatar) ?>" alt="avatar"></div>
        <div class="name"><?= htmlspecialchars($teacherName) ?></div>
        <div class="welcome">Upload your quiz details here.</div>
      </div>
    </aside>
  </div>

  <script src="../js/upload_quiz.js"></script>
</body>
</html>
