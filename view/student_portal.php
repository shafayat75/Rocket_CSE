<?php
include('../php/student_portal.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Portal </title>
  <link rel="stylesheet" href="../css/student_portal.css">
</head>
<body>

<!-- Back Button -->
<a class="back" href="./home.html">
  <img class="back__icon" src="../images/back.png" alt="Back">
</a>

<main class="portal">
  <div class="portal__container">

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar__brand">
        <div class="brand__logo"></div>
      </div>
      <nav class="sidebar__nav">
        <a class="nav__item is-active"><span class="nav__label">Dashboard</span></a>
        <a class="nav__item" href="../view/recorded_videos.html"><span class="nav__label">Recorded Videos</span></a>
        <a class="nav__item" href="../view/quizzes.html"><span class="nav__label">Quizzes</span></a>
        <a class="nav__item" href="quiz_attend.php"><span class="nav__label">Attend Quiz</span></a>

        <a class="nav__item" href="../view/notices.php"><span class="nav__label">Notices</span></a>
<a class="nav__item" href="../view/student_marks.php"><span class="nav__label">My Marks</span></a>

      </nav>
      <nav class="sidebar__nav sidebar__nav--secondary">
        <a class="nav__item" href="../view/myaccount.php"><span class="nav__label">My Account</span></a>
        <a class="nav__item" href="../view/login.html"><span class="nav__label">Sign Out</span></a>
      </nav>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Hero Card (Upcoming Courses) -->
      <div class="hero-card">
        <h3 class="upcoming-title">Upcoming Courses</h3>
        <div class="upcoming-list">
          <div class="upcoming-course">
            <img src="../images/Csharp.png" alt="C#">
            <span>C#</span>
          </div>
          <div class="upcoming-course">
            <img src="../images/c++.png" alt="C++">
            <span>C++</span>
          </div>
          <div class="upcoming-course">
            <img src="../images/java.png" alt="Java">
            <span>Java</span>
          </div>
          <div class="upcoming-course">
            <img src="../images/react.png" alt="React">
            <span>React</span>
          </div>
        </div>
      </div>

      <!-- Courses Section -->
      <div class="courses__header">
        <h2 class="section__title">Courses</h2>
        <a class="btn btn--chip" href="#">See All</a>
      </div>

      <!-- Courses List -->
      <div class="courses__list">
        <a class="course" href="https://www.w3schools.com/html/">
          <div class="course__icon"><img src="../images/html.png" alt="HTML"></div>
          <label class="course__label">HTML</label>
        </a>
        <a class="course" href="https://www.w3schools.com/css/">
          <div class="course__icon"><img src="../images/css.png" alt="CSS"></div>
          <label class="course__label">CSS</label>
        </a>
        <a class="course" href="https://www.w3schools.com/js/">
          <div class="course__icon"><img src="../images/js.png" alt="JavaScript"></div>
          <label class="course__label">JavaScript</label>
        </a>
        <a class="course" href="https://www.w3schools.com/php/">
          <div class="course__icon"><img src="../images/php.png" alt="PHP"></div>
          <label class="course__label">PHP</label>
        </a>
        <a class="course" href="https://www.w3schools.com/python/">
          <div class="course__icon"><img src="../images/python.svg" alt="Python"></div>
          <label class="course__label">Python</label>
        </a>
      </div>
    </div>

  
    <div class="user-box">
      <div class="user-photo">
        <img src="<?php echo $photoSrc; ?>" alt="User Photo">
      </div>
      <h3 class="user-name"><?php echo htmlspecialchars($fullname); ?></h3>
      <div class="notice-box">
        <p>Welcome to your Student Portal!</p>
      </div>

      <!-- New Section: Red Boxes -->
      <div class="user-links">
        <a href="view_notes.php" class="user-link">View Notes</a>
        <a href="view_videos.php" class="user-link">View Videos</a>
        <a href="take_quiz.php" class="user-link">Take Quiz</a>
      </div>
    </div>
  </div>
</main>

</body>
</html>
