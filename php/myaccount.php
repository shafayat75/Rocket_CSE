<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.html");
    exit();
}

include('config.php');

$user_id = (int)$_SESSION['user_id'];

$password_error = "";
$password_success = "";

/* ---------------- PHOTO UPLOAD ---------------- */
if (isset($_POST['upload_photo']) && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];

    if ($file['error'] === 0) {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $_SESSION['photo_msg'] = "Only JPG, JPEG, PNG, WEBP allowed!";
            header("Location: ../view/myaccount.php");
            exit();
        }

        // Ensure uploads folder exists
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Unique filename
        $newName = "user_" . $user_id . "_" . time() . "." . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Save filename in DB (photo column is VARCHAR)
            $stmt = $conn->prepare("UPDATE users SET photo = ? WHERE id = ?");
            $stmt->bind_param("si", $newName, $user_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['photo_msg'] = "Photo uploaded successfully!";
        } else {
            $_SESSION['photo_msg'] = "Upload failed! (move_uploaded_file error)";
        }
    } else {
        $_SESSION['photo_msg'] = "Upload error!";
    }

    header("Location: ../view/myaccount.php");
    exit();
}

/* ---------------- PASSWORD CHANGE ---------------- */
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        $password_error = "New password and confirm password do not match!";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed);
        $stmt->fetch();
        $stmt->close();

        // if old system used plain text, keep fallback check
        $ok = password_verify($current_password, $hashed) || ($current_password === $hashed);

        if (!$ok) {
            $password_error = "Current password is incorrect!";
        } else {
            $newHashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $newHashed, $user_id);
            $stmt->execute();
            $stmt->close();
            $password_success = "Password changed successfully!";
        }
    }
}

/* ---------------- FETCH USER DATA ---------------- */
$stmt = $conn->prepare("SELECT fullname, email, photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $email, $photoFile);
$stmt->fetch();
$stmt->close();

// Decide which image to display
if (!empty($photoFile)) {
    $photoSrc = "../uploads/" . $photoFile;
} else {
    $photoSrc = "../images/upload.png";
}
?>
