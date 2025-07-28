<?php
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'admin'])) {
  header("Location: ../login.php");
  exit;
}

include '../includes/header.php';
include '../dbase/config.php';

if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->execute([$id]);
$subject = $stmt->fetch();

if (!$subject) {
  echo "<p>Module not found.</p>";
  include '../includes/footer.php';
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $code = $_POST['code'];

  $update = $pdo->prepare("UPDATE subjects SET name = ?, code = ? WHERE id = ?");
  $update->execute([$name, $code, $id]);

  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">✏️ Edit Module</h2>
<form class="form-auth" method="POST">
  <label>Module Name:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($subject['name']) ?>" required>

  <label>Module Code:</label>
  <input type="text" name="code" value="<?= htmlspecialchars($subject['code']) ?>" required>

  <input type="submit" value="Update Module">
</form>

<?php include '../includes/footer.php'; ?>
