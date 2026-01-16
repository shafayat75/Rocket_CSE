<?php
// Enable debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB connection
$conn = new mysqli("localhost", "root", "", "user_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// POST action handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action === 'fetch') {
        $result = $conn->query("SELECT * FROM teacher ORDER BY id ASC");
        $teachers = [];
        while ($row = $result->fetch_assoc()) $teachers[] = $row;
        echo json_encode(['status' => 'success', 'data' => $teachers]);
        exit;
    }

    if ($action === 'add') {
        $name = $conn->real_escape_string($_POST['teacher_name'] ?? '');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $password = $conn->real_escape_string($_POST['password'] ?? '');

        if (!$name || !$email || !$password) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            exit;
        }

        $sql = "INSERT INTO teacher (teacher_name, email, password) VALUES ('$name', '$email', '$password')";
        echo $conn->query($sql) 
            ? json_encode(['status' => 'success', 'message' => 'Teacher added']) 
            : json_encode(['status' => 'error', 'message' => 'Database error']);
        exit;
    }

    if ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $name = $conn->real_escape_string($_POST['teacher_name'] ?? '');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $password = $conn->real_escape_string($_POST['password'] ?? '');

        if (!$id || !$name || !$email || !$password) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $sql = "UPDATE teacher SET teacher_name='$name', email='$email', password='$password' WHERE id=$id";
        echo $conn->query($sql) 
            ? json_encode(['status' => 'success', 'message' => 'Teacher updated']) 
            : json_encode(['status' => 'error', 'message' => 'Database error']);
        exit;
    }

    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            exit;
        }

        $sql = "DELETE FROM teacher WHERE id=$id";
        echo $conn->query($sql) 
            ? json_encode(['status' => 'success', 'message' => 'Teacher deleted']) 
            : json_encode(['status' => 'error', 'message' => 'Database error']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}
?>
