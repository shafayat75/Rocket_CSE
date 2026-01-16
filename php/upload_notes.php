<?php
// php/upload_notes.php — processes uploads, flashes messages, redirects back to view
session_start();

$messages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save in: project_root/assets/uploads/notes
    $baseDir = realpath(__DIR__ . '/../assets/uploads/notes');
    if ($baseDir === false) { $baseDir = __DIR__ . '/../assets/uploads/notes'; }
    if (!is_dir($baseDir)) { @mkdir($baseDir, 0775, true); }

    $allowed = [
        'zip',
        'png','jpg','jpeg','gif','webp',
        'pdf','doc','docx','ppt','pptx','txt','md','csv','xlsx'
    ];
    $maxBytes = 50 * 1024 * 1024; // 50MB

    if (!isset($_FILES['notes'])) {
        $messages[] = ['type' => 'error', 'text' => 'No files received.'];
    } else {
        // Normalize to array
        $files = [];
        if (is_array($_FILES['notes']['name'])) {
            $count = count($_FILES['notes']['name']);
            for ($i = 0; $i < $count; $i++) {
                $files[] = [
                    'name'     => $_FILES['notes']['name'][$i],
                    'type'     => $_FILES['notes']['type'][$i],
                    'tmp_name' => $_FILES['notes']['tmp_name'][$i],
                    'error'    => $_FILES['notes']['error'][$i],
                    'size'     => $_FILES['notes']['size'][$i],
                ];
            }
        } else {
            $files[] = $_FILES['notes'];
        }

        foreach ($files as $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $messages[] = ['type' => 'error', 'text' => $file['name'] . ' — upload error code ' . $file['error']];
                continue;
            }
            if ($file['size'] > $maxBytes) {
                $messages[] = ['type' => 'error', 'text' => $file['name'] . ' — file too large (limit 50MB).'];
                continue;
            }

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) {
                $messages[] = ['type' => 'error', 'text' => $file['name'] . " — .$ext not allowed."];
                continue;
            }

            // Sanitize + unique target
            $base = preg_replace('/[^A-Za-z0-9._-]+/', '_', basename($file['name']));
            $target = $baseDir . '/' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '_' . $base;

            if (!@move_uploaded_file($file['tmp_name'], $target)) {
                $messages[] = ['type' => 'error', 'text' => $file['name'] . ' — could not move file.'];
                continue;
            }

            // Public URL relative to /view/
            $relPath = '../assets/uploads/notes/' . basename($target);
            $messages[] = ['type' => 'ok', 'text' => $file['name'] . ' — uploaded successfully.', 'link' => $relPath];
        }
    }
}

// flash + redirect
$_SESSION['upload_messages'] = $messages;
header('Location: ../view/upload_notes.php');
exit;
