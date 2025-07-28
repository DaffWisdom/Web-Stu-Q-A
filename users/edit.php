<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
  echo "<p>User not found.</p>";
  include '../includes/footer.php';
  exit;
}

// Xử lý cập nhật
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  $update = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
  $update->execute([$username, $email, $role, $id]);

  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">✏️ Edit User</h2>

<form method="POST" class="form-auth">
  <label>Username:</label>
  <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

  <label>Email:</label>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

  <label>Role:</label>
  <select name="role" required>
    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
  </select>

  <input type="submit" value="Update User">
</form>

<?php include '../includes/footer.php'; ?>
