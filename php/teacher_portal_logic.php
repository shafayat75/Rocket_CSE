<?php
// php/teacher_portal_logic.php
// Handles backend logic (e.g., session defaults)

session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Teacher';
}
if (!isset($_SESSION['avatar'])) {
    $_SESSION['avatar'] = 'https://i.pravatar.cc/120?img=12';
}
