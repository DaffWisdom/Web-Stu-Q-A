<?php
session_start();
include '../includes/header.php';
include '../dbase/config.php';

// Kiểm tra có ID module không
if (!isset($_GET['id'])) {
  echo "<p class='error-msg'>Module ID is missing.</p>";
  include '../includes/footer.php';
  exit;
}

$id = $_GET['id'];

// Xác nhận xoá
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("DELETE FROM subjects WHERE id = ?");
  $stmt->execute([$id]);

  header("Location: index.php");
  exit;
}
?>


<h2 class="page-title">🗑️ Delete Confirmation</h2>

 <div class="delete-buttons">
    <form method="POST">
        <button type="submit"  value="yes" class="btn danger">Yes, Delete</button>
    </form>
    <a href="index.php" class="btn-outline">Cancel</a>
  </div>

<?php include '../includes/footer.php'; ?>
