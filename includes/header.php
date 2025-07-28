<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Q&A</title>
  <link rel="stylesheet" href="/Coursework/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="nav-container">
    <div class="logo">
      <a href="/Coursework/index.php">📘 Q&A Portal</a>
    </div>

    <nav class="main-nav">
      <ul>
        <li><a href="/Coursework/index.php">Home</a></li>
        <li><a href="/Coursework/posts/create.php">New Post</a></li>
        <li><a href="/Coursework/users/index.php">Users</a></li>
        <li><a href="/Coursework/subjects/index.php">Modules</a></li>
        <li><a href="/Coursework/contact.php">Contact Us</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li><a href="/Coursework/admin/dashboard.php">Admin Dashboard</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <div class="auth-links">
      <?php if (isset($_SESSION['username'])): ?>
        <a href="/Coursework/logout.php" class="btn-outline">Logout</a>
      <?php else: ?>
        <a href="/Coursework/login.php" class="btn">Login</a>
        <a href="/Coursework/register.php" class="btn-outline">Register</a>
      <?php endif; ?>
    </div>

</header>

<div class="container">

