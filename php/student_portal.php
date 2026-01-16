<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.html");
    exit();
}

include("config.php");

$user_id = (int)$_SESSION['user_id'];

// Fetch user data
$sql = "SELECT fullname, photo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $photoFile);
$stmt->fetch();
$stmt->close();

// Handle photo filename
if (!empty($photoFile)) {
    $photoSrc = "../uploads/" . $photoFile;
} else {
    $photoSrc = "../images/default.png";
}
?>
