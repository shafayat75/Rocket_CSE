<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'fetch') {
    $result = $conn->query("SELECT id, fullname, phone, email, password FROM users ORDER BY id ASC");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $users]);
    exit;
}

if ($action === 'add') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!$fullname || !$email || !$password || !$phone) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (fullname, phone, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $phone, $email, $password);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
    exit;
}

if ($action === 'edit') {
    $id = intval($_POST['id'] ?? 0);
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!$id || !$fullname || !$email || !$password || !$phone) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET fullname=?, phone=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("ssssi", $fullname, $phone, $email, $password, $id);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
    exit;
}

if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
