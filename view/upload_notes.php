<?php
// view/upload_notes.php — UI for uploading notes (no DB).
session_start();
$teacherName   = $_SESSION['username'] ?? 'Teacher';
$teacherAvatar = $_SESSION['avatar']   ?? 'https://i.pravatar.cc/120?img=12';

// flash messages from handler
$messages = $_SESSION['upload_messages'] ?? [];
unset($_SESSION['upload_messages']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upload Notes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Common portal CSS (if you have it) + this page's CSS -->
  <link rel="stylesheet" href="../css/teacher_portal.css" />
  <link rel="stylesheet" href="../css/upload_notes.css" />
</head>
<body>
  <div class="shell">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand">
        <div class="blob">T</div>
        <div class="brand-text"><strong>Teacher Portal</strong></div>
      </div>
      <nav class="nav">
        <a href="teacher_portal.php">Dashboard</a>
        <a class="active" href="upload_notes.php">Upload Notes</a>
        <a href="upload_video.php">Upload Video</a>
        <a href="upload_quiz.php">Quizzes</a>
       
        <a href="my_account.php">My Account</a>
        <a href="../php/logout.php">Sign Out</a>
      </nav>
    </aside>

    <!-- Main -->
    <main class="main">
      <header class="top">
        <h1>Upload Notes</h1>
        <div class="spacer"></div>
      </header>

      <?php if (!empty($messages)): ?>
        <section>
          <?php foreach ($messages as $m): ?>
            <div class="msg <?php echo $m['type'] === 'ok' ? 'ok' : 'error'; ?>">
              <?php echo htmlspecialchars($m['text']); ?>
              <?php if (!empty($m['link'])): ?>
                — <a href="<?php echo htmlspecialchars($m['link']); ?>" target="_blank" rel="noreferrer">view</a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>

      <section class="uploader" id="dropzone">
        <form method="post" enctype="multipart/form-data" action="../php/upload_notes.php">
          <p><strong>Select notes to upload</strong></p>
          <p>Allowed: ZIP, images (png/jpg/jpeg/gif/webp), pdf/doc/docx/ppt/pptx/txt/md/csv/xlsx (max 50MB each)</p>

          <!-- Hidden file input -->
          <input type="file" id="notes" name="notes[]" multiple
                 accept=".zip,image/*,.pdf,.doc,.docx,.ppt,.pptx,.txt,.md,.csv,.xlsx"
                 style="display:none" />

          <button type="button" class="btn" id="chooseBtn">Choose Files</button>
          <button type="submit" class="btn">Upload</button>

          <div class="file-list" id="fileList"></div>
        </form>
      </section>

      <div class="section-title">
        <h2>Tips</h2>
      </div>
      <ul class="bullets">
        <li>Bundle multiple notes as a <code>.zip</code> for faster upload.</li>
        <li>Max size per file: 50 MB.</li>
      </ul>
    </main>

    <!-- Profile -->
    <aside class="profile">
      <div class="card">
        <div class="avatar"><img src="<?php echo htmlspecialchars($teacherAvatar); ?>" alt="avatar" /></div>
        <div class="name"><?php echo htmlspecialchars($teacherName); ?></div>
        <div class="welcome">Upload your course materials here.</div>
      </div>
    </aside>
  </div>

  <script src="../js/upload_notes.js"></script>
</body>
</html>
