<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//DB CON
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- All field must fill check ---
    if (empty($fullname) || empty($phone) || empty($email) || empty($password)) {
        die("All fields must be filled!");
    }

    if (!preg_match("/^[A-Za-z\s]+$/", $fullname)) {
        die("Name must contain only alphabetic characters!");
    }

    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        die("Phone number must be exactly 11 digits!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/", $password)) {
        die("Password must have min 8 chars, one uppercase, one lowercase, one digit, and one special character!");
    }

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("Email already exists!");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (fullname, phone, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $phone, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration Successful! Please login.";
    } else {
        echo "Registration Failed!";
    }

    $stmt->close();
    $conn->close();
}
?>
