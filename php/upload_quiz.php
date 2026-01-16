<?php
session_start();

$messages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = __DIR__ . '/../assets/uploads/quiz';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0775, true);
    }

    $subjectSel   = trim($_POST['subject_select'] ?? '');
    $subjectOther = trim($_POST['subject_other'] ?? '');
    $subject      = ($subjectSel === 'Other') ? $subjectOther : $subjectSel;

    $durSel   = trim($_POST['duration_select'] ?? '');
    $durOther = trim($_POST['duration_other'] ?? '');
    $duration = ($durSel === 'custom' && ctype_digit($durOther)) ? (int)$durOther
               : (ctype_digit($durSel) ? (int)$durSel : 0);

    $questionsText = trim($_POST['questions_text'] ?? '');

    if ($subject === '') $messages[] = ['type'=>'err','text'=>'Please select or enter a subject'];
    if ($duration <= 0)  $messages[] = ['type'=>'err','text'=>'Please choose a valid duration'];

    $saved = false;
    $okExt = ['csv','txt','pdf','doc','docx','json','zip'];
    $max   = 10 * 1024 * 1024;

    // File upload
    if (!empty($_FILES['quiz_file']) && $_FILES['quiz_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $f = $_FILES['quiz_file'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            $messages[] = ['type'=>'err','text'=>'Upload error'];
        } elseif ($f['size'] > $max) {
            $messages[] = ['type'=>'err','text'=>'File too large (10MB max)'];
        } else {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext,$okExt,true)) {
                $messages[] = ['type'=>'err','text'=>"File type .$ext not allowed"];
            } else {
                $safe = preg_replace('/[^A-Za-z0-9._-]+/', '_', basename($f['name']));
                $to   = $uploadDir.'/'.date('Ymd_His').'_'.bin2hex(random_bytes(3)).'_'.$safe;
                if (@move_uploaded_file($f['tmp_name'],$to)) {
                    $saved = true;
                    $messages[] = ['type'=>'ok','text'=>'File uploaded successfully'];
                } else {
                    $messages[] = ['type'=>'err','text'=>'Could not save file'];
                }
            }
        }
    }

    // Save pasted questions
    if ($questionsText !== '') {
        $to = $uploadDir.'/'.date('Ymd_His').'_'.bin2hex(random_bytes(3)).'_questions.txt';
        if (@file_put_contents($to, $questionsText) !== false) {
            $saved = true;
            $messages[] = ['type'=>'ok','text'=>'Pasted questions saved'];
        } else {
            $messages[] = ['type'=>'err','text'=>'Could not save pasted questions'];
        }
    }

    if (!$saved && empty($messages)) {
        $messages[] = ['type'=>'err','text'=>'Please upload a file or paste questions'];
    }
}

$_SESSION['quiz_messages'] = $messages;
header('Location: ../view/upload_quiz.php');
exit;
