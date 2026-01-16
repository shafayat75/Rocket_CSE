<?php
session_start();
$teacherName   = $_SESSION['username'] ?? 'Teacher';
$teacherAvatar = $_SESSION['avatar']   ?? 'https://i.pravatar.cc/120?img=12';

// flash messages from handler
$messages = $_SESSION['video_messages'] ?? [];
unset($_SESSION['video_messages']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upload Video</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../css/teacher_portal.css" />
  <link rel="stylesheet" href="../css/upload_video.css" />
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
        <a href="upload_notes.php">Upload Notes</a>
        <a class="active" href="upload_video.php">Upload Video</a>
        <a href="upload_quiz.php">Quizzes</a>
        
        <a href="my_account.php">My Account</a>
        <a href="../php/logout.php">Sign Out</a>
      </nav>
    </aside>

    <!-- Main -->
    <main class="main">
      <header class="top">
        <h1>Upload Video</h1>
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

      <section class="uploader">
        <form method="post" enctype="multipart/form-data" action="../php/upload_video.php">
          <p><strong>Select a video to upload</strong></p>
          <p>Allowed: mp4, mov, mkv, avi, webm, mpeg/mpg, m4v, 3gp, wmv (max 200MB)</p>

          <input type="file" id="video" name="video" accept="video/*" style="display:none" />
          <button type="button" class="btn" id="chooseBtn">Choose Video</button>
          <button type="submit" class="btn">Upload</button>

          <div class="file-chosen" id="fileChosen">No file selected</div>
        </form>
      </section>
    </main>

    <!-- Profile -->
    <aside class="profile">
      <div class="card">
        <div class="avatar"><img src="<?php echo htmlspecialchars($teacherAvatar); ?>" alt="avatar" /></div>
        <div class="name"><?php echo htmlspecialchars($teacherName); ?></div>
        <div class="welcome">Upload your lecture videos here.</div>
      </div>
    </aside>
  </div>

  <script src="../js/upload_video.js"></script>
</body>
</html>
