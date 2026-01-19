<?php
// view/view_notes.php
session_start();
// Optional login check
// if (!isset($_SESSION['student_id'])) {
//     header('Location: login.html');
//     exit;
// }

$notesDir = realpath(__DIR__ . '/../assets/uploads/notes');

$notes = [];
if ($notesDir && is_dir($notesDir)) {
    $files = scandir($notesDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $notesDir . '/' . $file;
        if (is_file($path)) {
            $notes[] = [
                'name' => $file,
                'url'  => '../assets/uploads/notes/' . urlencode($file),
                'size' => filesize($path),
                'time' => filemtime($path)
            ];
        }
    }

    usort($notes, fn($a, $b) => $b['time'] <=> $a['time']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Notes</title>
  <link rel="stylesheet" href="../css/student_portal.css">
  <style>
    .notes-list { padding: 20px; }
    .note-item {
      padding: 10px;
      border: 1px solid #ddd;
      margin-bottom: 8px;
      border-radius: 4px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .note-info { max-width: 80%; }
    .note-info strong { display: block; }
    .note-info small { color: #888; }
    .note-actions a {
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <a class="back" href="./student_portal.php">
    <img class="back__icon" src="../images/back.png" alt="Back">
  </a>

  <div class="notes-list">
    <h2>Available Notes</h2>

    <?php if (empty($notes)): ?>
      <p>No notes have been uploaded yet.</p>
    <?php else: ?>
      <?php foreach ($notes as $note): ?>
        <div class="note-item">
          <div class="note-info">
            <strong><?php echo htmlspecialchars($note['name']); ?></strong>
            <small>
              Uploaded on <?php echo date('Y-m-d H:i', $note['time']); ?> |
              <?php echo round($note['size'] / 1024, 1); ?> KB
            </small>
          </div>
          <div class="note-actions">
            <a href="<?php echo htmlspecialchars($note['url']); ?>" target="_blank">View</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
