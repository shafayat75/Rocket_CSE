<?php require_once("../php/my_account.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Account — Teacher</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../css/teacher_portal.css">
  <link rel="stylesheet" href="../css/my_account.css">
</head>
<body>
  <div class="shell">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand"><div class="blob">T</div><div class="brand-text"><strong>Teacher Portal</strong></div></div>
      <nav class="nav">
        <a href="teacher_portal.php" class="<?= $current==='teacher_portal.php'?'active':'' ?>">Dashboard</a>
        <a href="upload_notes.php"   class="<?= $current==='upload_notes.php'?'active':'' ?>">Upload Notes</a>
        <a href="upload_video.php"   class="<?= $current==='upload_video.php'?'active':'' ?>">Upload Video</a>
        <a href="upload_quiz.php"    class="<?= $current==='upload_quiz.php'?'active':'' ?>">Quizzes</a>
        <a href="my_account.php"     class="active">My Account</a>
        <a href="../php/logout.php"  class="<?= $current==='logout.php'?'active':'' ?>">Sign Out</a>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <header class="top">
        <h1>My Account</h1>
        <div class="spacer"></div>
        <a class="see-all" href="teacher_portal.php">Back to Dashboard</a>
      </header>

      <section class="container">
        <div class="card">
          <!-- Profile header -->
          <div class="row" style="align-items:center; margin-bottom:1rem;">
            <img class="avatar-xl"
                 src="<?= htmlspecialchars($fixed['avatar']); ?>"
                 alt="<?= htmlspecialchars($fixed['name']); ?>"
                 onerror="this.src='https://i.pravatar.cc/240?img=12'">
            <div>
              <h2><?= htmlspecialchars($fixed['name']); ?></h2>
              <div class="muted"><?= htmlspecialchars($fixed['email']); ?></div>
              <div class="muted"><?= htmlspecialchars($fixed['institution']); ?> · <?= htmlspecialchars($fixed['qualification']); ?></div>
            </div>
          </div>

          <!-- Read-only fields -->
          <div class="grid grid-2 readonly">
            <div class="field">
              <label>Name</label>
              <input class="input" type="text" value="<?= htmlspecialchars($fixed['name']); ?>" readonly>
            </div>
            <div class="field">
              <label>Email</label>
              <input class="input" type="text" value="<?= htmlspecialchars($fixed['email']); ?>" readonly>
            </div>
            <div class="field">
              <label>Institution</label>
              <input class="input" type="text" value="<?= htmlspecialchars($fixed['institution']); ?>" readonly>
            </div>
            <div class="field">
              <label>Qualification</label>
              <input class="input" type="text" value="<?= htmlspecialchars($fixed['qualification']); ?>" readonly>
            </div>
            <div class="field" style="grid-column:1/-1;">
              <label>Interests</label>
              <div>
                <?php foreach (array_map('trim', explode(',', $fixed['interests'])) as $tag): ?>
                  <?php if ($tag !== ''): ?><span class="pill"><?= htmlspecialchars($tag); ?></span><?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- PROFILE -->
    <aside class="profile">
      <div class="card">
        <div class="name"><?= htmlspecialchars($displayName); ?></div>
        <div class="welcome">Core details are fixed by admin. Replace photo at <code><?= htmlspecialchars($fixed['avatar']); ?></code>.</div>
      </div>
    </aside>
  </div>

  <script src="../js/my_account.js"></script>
</body>
</html>
