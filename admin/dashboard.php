<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

include '../includes/header.php';
?>

<h2 class="page-title">🛠 Admin Dashboard</h2>

<div style="text-align:center;">
  <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (Admin)</p>
  <a href="../users/index.php" class="btn">👥 Manage Users</a>
  <a href="../index.php" class="btn">📝 Manage Posts</a>
</div>

<?php include '../includes/footer.php'; ?>
