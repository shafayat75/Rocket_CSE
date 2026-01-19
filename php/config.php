<?php

// DB connection
$conn = new mysqli("localhost", "root", "", "user_db");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>