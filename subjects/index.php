<?php
session_start();
include '../includes/header.php';
include '../dbase/config.php';

$stmt = $pdo->query("SELECT * FROM subjects ORDER BY name ASC");
?>

<h2 class="page-title">📚 Manage Modules</h2>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
  <a href="create.php" class="btn">➕ Add New Module</a>
<?php endif; ?>

<div class="card-container">
  <?php while ($row = $stmt->fetch()): ?>
    <div class="qa-card">
      <h3><?= htmlspecialchars($row['name']) ?></h3>
      <p><strong>Code:</strong> <?= htmlspecialchars($row['code']) ?></p>

      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-small">Edit</a>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>
