<?php
session_start();
// Optional login check:
// if (!isset($_SESSION['student_id'])) {
//     header('Location: login.html');
//     exit;
// }

$videoDir = realpath(__DIR__ . '/../assets/uploads/videos');
$videos = [];

if ($videoDir && is_dir($videoDir)) {
    $files = scandir($videoDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $videoDir . '/' . $file;
        if (is_file($path)) {
            $videos[] = [
                'name' => $file,
                'url'  => '../assets/uploads/videos/' . urlencode($file),
                'size' => filesize($path),
                'time' => filemtime($path)
            ];
        }
    }

    // Sort newest first
    usort($videos, fn($a, $b) => $b['time'] <=> $a['time']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Videos</title>
  <link rel="stylesheet" href="../css/student_portal.css">
  <style>
    .video-list { padding: 20px; }
    .video-item {
      padding: 15px;
      border: 1px solid #ddd;
      margin-bottom: 15px;
      border-radius: 6px;
      background: #f9f9f9;
    }
    .video-title {
      font-weight: bold;
      margin-bottom: 8px;
    }
    video {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
      margin-top: 8px;
    }
    .video-meta {
      font-size: 0.9em;
      color: #888;
      margin-top: 6px;
    }
  </style>
</head>
<body>
  <a class="back" href="./student_portal.php">
    <img class="back__icon" src="../images/back.png" alt="Back">
  </a>

  <div class="video-list">
    <h2>Lecture Videos</h2>

    <?php if (empty($videos)): ?>
      <p>No videos have been uploaded yet.</p>
    <?php else: ?>
      <?php foreach ($videos as $video): ?>
        <div class="video-item">
          <div class="video-title"><?php echo htmlspecialchars($video['name']); ?></div>
          <video controls>
            <source src="<?php echo htmlspecialchars($video['url']); ?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <div class="video-meta">
            Uploaded on <?php echo date('Y-m-d H:i', $video['time']); ?> |
            Size: <?php echo round($video['size'] / (1024 * 1024), 1); ?> MB
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
