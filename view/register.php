<?php
session_start();
include('../php/register.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="../css/register.css">
</head>
<body>
  <!-- Back Button -->
<a class="back" href="./home.html">
  <img class="back__icon" src="../images/back.png" alt="Back">
</a>

<div class="register-container">
  <h2>REGISTER</h2>
  <form id="registerForm">
    <div class="form-group">
      <label>FULL NAME</label>
      <input type="text" name="fullname" placeholder="Enter your full name">
    </div>
    <div class="form-group">
      <label>PHONE NUMBER</label>
      <input type="tel" name="phone" placeholder="Enter your phone number">
    </div>
    <div class="form-group">
      <label>EMAIL ADDRESS</label>
      <input type="email" name="email" placeholder="Enter your email">
    </div>
    <div class="form-group">
      <label>PASSWORD</label>
      <input type="password" name="password" placeholder="Enter your password">
    </div>
    <button type="submit" class="btn-submit">REGISTER NOW</button>
  </form>
  <div class="login-link">
    Already have an account? <a href="login.html">Log in Here</a>
  </div>
</div>
<script src="../js/register.js"></script>
</body>
</html>
