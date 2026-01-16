<?php
// view/teacher_portal.php
session_start();

// ✅ Teacher login check (matches php/login.php)
if (($_SESSION['user_role'] ?? '') !== 'teacher') {
  header("Location: login.html");
  exit;
}

// Teacher info from session (set by login.php)
$teacherName   = $_SESSION['fullname'] ?? 'Teacher';
$teacherAvatar = $_SESSION['avatar'] ?? 'https://i.pravatar.cc/120?img=12';

// Active nav state
$current = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- External CSS -->
  <link rel="stylesheet" href="../css/teacher_portal.css">
</head>
<body>
  <div class="shell">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <div class="blob">T</div>
        <div class="brand-text">
          <strong>Teacher Portal</strong>
        </div>
      </div>

      <nav class="nav">
        <a href="teacher_portal.php" class="<?php echo ($current==='teacher_portal.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="upload_notes.php"   class="<?php echo ($current==='upload_notes.php') ? 'active' : ''; ?>">Upload Notes</a>
        <a href="upload_video.php"   class="<?php echo ($current==='upload_video.php') ? 'active' : ''; ?>">Upload Video</a>
        <a href="upload_quiz.php"    class="<?php echo ($current==='upload_quiz.php') ? 'active' : ''; ?>">Quizzes</a>
        <a href="teacher_quiz_results.php" class="<?php echo ($current==='teacher_quiz_results.php') ? 'active' : ''; ?>">
  Quiz Results
</a>

        <a href="teacher_create_quiz.php"
   class="<?php echo ($current==='teacher_create_quiz.php') ? 'active' : ''; ?>">
   Create Quiz
</a>

        <a href="teacher_upload_marks.php" class="<?php echo ($current==='teacher_upload_marks.php') ? 'active' : ''; ?>">Upload Marks</a>

        <a href="teacher_my_account.php" class="<?php echo ($current==='teacher_my_account.php') ? 'active' : ''; ?>">My Account</a>

        <!-- ✅ Proper logout -->
        <a href="../php/logout.php">Sign Out</a>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <header class="top">
        <h1>Upcoming Batches</h1>
        <div class="spacer"></div>
        <button class="see-all">See All</button>
      </header>

      <section class="upcoming">
        <div class="badge"><img alt="C#" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg"><span>C#</span></div>
        <div class="badge"><img alt="C++" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/cplusplus/cplusplus-original.svg"><span>C++</span></div>
        <div class="badge"><img alt="Java" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/java/java-original.svg"><span>Java</span></div>
        <div class="badge"><img alt="React" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg"><span>React</span></div>
      </section>

      <div class="section-title">
        <h2>Courses You Teach</h2>
      </div>

      <section class="courses">
        <div class="course"><img alt="HTML" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-plain.svg"><span>HTML</span></div>
        <div class="course"><img alt="CSS" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-plain.svg"><span>CSS</span></div>
        <div class="course"><img alt="JavaScript" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg"><span>JavaScript</span></div>
        <div class="course"><img alt="PHP" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg"><span>PHP</span></div>
        <div class="course"><img alt="Python" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg"><span>Python</span></div>
      </section>
    </main>

    <!-- PROFILE -->
    <aside class="profile">
      <div class="card">
        <div class="avatar"><img src="<?php echo htmlspecialchars($teacherAvatar); ?>" alt="avatar"></div>
        <div class="name"><?php echo htmlspecialchars($teacherName); ?></div>
        <div class="welcome">Welcome to your Teacher Portal!</div>
      </div>
    </aside>

  </div>

  <!-- External JS -->
  <script src="../js/teacher_portal.js"></script>
</body>
</html>
