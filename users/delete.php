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

// Không cho phép xoá chính mình
if ($id == $_SESSION['user_id']) {
  echo "<p style='color:red; text-align:center;'>⚠️ You cannot delete your own account.</p>";
  echo "<p style='text-align:center;'><a href='index.php' class='btn-outline'>Back</a></p>";
  include '../includes/footer.php';
  exit;
}

// Lấy thông tin user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
  echo "<p>User not found.</p>";
  include '../includes/footer.php';
  exit;
}

// Xác nhận xoá
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
  $delete->execute([$id]);
  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">🗑️ Delete User</h2>

<div class="form-auth">
  <p>Are you sure you want to delete <strong><?= htmlspecialchars($user['username']) ?></strong>?</p>
   <div class="delete-buttons">
    <form method="POST">
      <button type="submit" class="btn danger">Yes, Delete</button>
    </form>
    <a href="/Coursework/index.php" class="btn-outline">Cancel</a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
