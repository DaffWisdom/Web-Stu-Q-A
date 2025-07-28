<?php
session_start();
// Chỉ admin được phép truy cập
if (!isset($_SESSION['user_id'])) {
  $_SESSION['error_message'] = "🔒 Please log in to access this page.";
  header("Location: ../index.php");
  exit;
}

if ($_SESSION['role'] !== 'admin') {
  $_SESSION['error_message'] = "⛔ You do not have permission to access that page.";
  header("Location: ../index.php");
  exit;
}
include '../includes/header.php';
include '../dbase/config.php';

// Lấy danh sách user
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
?>

<h2 class="page-title">👤 Manage Users</h2>

<table class="styled-table">
  <thead>
    <tr>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th style="width: 1%; white-space: nowrap;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $stmt->fetch()): ?>
    <tr>
      <td><?= htmlspecialchars($row['username']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['role']) ?></td>
      <td style="white-space: nowrap;">
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-small">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" class="btn-small danger">Delete</a>
      </td>

    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
