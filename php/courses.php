<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";   
$username = "root";          
$password = "";              
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    if ($action == 'fetch') {
        $result = $conn->query("SELECT * FROM courses ORDER BY id ASC");
        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $courses]);
        exit;
    }

    if ($action == 'add') {
        $name = $conn->real_escape_string($_POST['course_name'] ?? '');
        $code = $conn->real_escape_string($_POST['course_code'] ?? '');

        if (!$name || !$code) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            exit;
        }

        $sql = "INSERT INTO courses (course_name, course_code) VALUES ('$name', '$code')";
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Course added']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        exit;
    }

    if ($action == 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $name = $conn->real_escape_string($_POST['course_name'] ?? '');
        $code = $conn->real_escape_string($_POST['course_code'] ?? '');

        if (!$id || !$name || !$code) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $sql = "UPDATE courses SET course_name='$name', course_code='$code' WHERE id=$id";
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Course updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        exit;
    }

    if ($action == 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            exit;
        }

        $sql = "DELETE FROM courses WHERE id=$id";
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Course deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}
?>