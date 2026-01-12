<?php
session_start();
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter both email and password.']);
        exit;
    }

    // 🔐 Admin login (static credentials)
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['user_role'] = 'admin';
        $_SESSION['fullname'] = 'Administrator';
        echo json_encode([
            'status' => 'success',
            'message' => 'Admin login successful',
            'redirect' => '../view/admin_panel.php'
        ]);
        exit;
    }

    // 👨‍🏫 Teacher login (static credentials)
    if ($email === 'teacher@gmail.com' && $password === 'teacher123') {
        $_SESSION['user_role'] = 'teacher';
        $_SESSION['fullname'] = 'Teacher';
        echo json_encode([
            'status' => 'success',
            'message' => 'Teacher login successful',
            'redirect' => '../view/teacher_portal.php'
        ]);
        exit;
    }

    // 👨‍🎓 Student login (via database)
    $conn = new mysqli("localhost", "root", "", "user_db");
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'DB connection failed']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_role'] = 'student';

            echo json_encode([
                'status' => 'success',
                'message' => 'Student login successful',
                'redirect' => '../view/student_portal.php'
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Wrong password!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found!']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode($response);
