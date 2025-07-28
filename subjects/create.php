<?php
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'admin'])) {
  header("Location: ../login.php");
  exit;
}

include '../includes/header.php';
include '../dbase/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $code = $_POST['code'];

  $stmt = $pdo->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
  $stmt->execute([$name, $code]);

  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">➕ Add New Module</h2>
<form class="form-auth" method="POST">
  <label>Module Name:</label>
  <input type="text" name="name" required>

  <label>Module Code:</label>
  <input type="text" name="code" required>

  <input type="submit" value="Create Module">
</form>

<?php include '../includes/footer.php'; ?>
