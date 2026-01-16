<?php
// php/upload_video.php — handles video upload
session_start();

$messages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = realpath(__DIR__ . '/../assets/uploads/videos');
    if ($uploadDir === false) { $uploadDir = __DIR__ . '/../assets/uploads/videos'; }
    if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

    $allowed = ['mp4','mov','mkv','avi','webm','mpeg','mpg','m4v','3gp','wmv'];
    $maxBytes = 200 * 1024 * 1024; // 200 MB

    if (!isset($_FILES['video'])) {
        $messages[] = ['type' => 'error', 'text' => 'No video file received.'];
    } else {
        $file = $_FILES['video'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $messages[] = ['type' => 'error', 'text' => 'Upload error code: ' . $file['error']];
        } elseif ($file['size'] > $maxBytes) {
            $messages[] = ['type' => 'error', 'text' => 'File too large (limit 200MB).'];
        } else {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) {
                $messages[] = ['type' => 'error', 'text' => "File type .$ext is not allowed."];
            } else {
                $base = preg_replace('/[^A-Za-z0-9._-]+/', '_', basename($file['name']));
                $target = $uploadDir . '/' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '_' . $base;

                if (@move_uploaded_file($file['tmp_name'], $target)) {
                    $relPath = '../assets/uploads/videos/' . basename($target);
                    $messages[] = ['type' => 'ok', 'text' => 'Video uploaded successfully.', 'link' => $relPath];
                } else {
                    $messages[] = ['type' => 'error', 'text' => 'Could not move uploaded file.'];
                }
            }
        }
    }
}

// flash + redirect back
$_SESSION['video_messages'] = $messages;
header('Location: ../view/upload_video.php');
exit;
