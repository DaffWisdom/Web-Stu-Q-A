<?php
session_start();
include './dbase/config.php';
include './includes/header.php';

if (isset($_SESSION['error_message'])) {
  echo '<p style="color:red; text-align:center;">' . $_SESSION['error_message'] . '</p>';
  unset($_SESSION['error_message']);
  echo "<script>history.replaceState({}, '', 'index.php');</script>";
}

$stmt = $pdo->query("
  SELECT posts.*, users.username, subjects.name AS subject_name
  FROM posts
  LEFT JOIN users ON posts.user_id = users.id
  LEFT JOIN subjects ON posts.subject_id = subjects.id
  ORDER BY posts.created_at DESC
");
?>

<h2 class="page-title">🎓 Student Q&A – Recent Posts</h2>

<?php if (isset($_SESSION['unauthorized'])): ?>
  <p style="color:red; text-align:center;">⛔ You do not have permission to access that page.</p>
  <?php unset($_SESSION['unauthorized']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['username'])): ?>
  <p style="text-align:center;">Hi <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
  <div style="margin-bottom: 20px;">
    <a href="posts/create.php" class="btn">➕ Ask a Question</a>
  </div>
<?php else: ?>
  <p style="text-align:center;">Welcome! Please <a href="login.php">log in</a> to create or manage posts.</p>
<?php endif; ?>

<!-- CARD CONTAINER -->
<div class="card-container">
  <?php while ($row = $stmt->fetch()): ?>
    <div class="qa-card">
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><strong>Author:</strong> <?= htmlspecialchars($row['username']) ?></p>
      <p><strong>Subject:</strong> <?= htmlspecialchars($row['subject_name']) ?></p>
      <p><strong>Content:</strong><br> <?= nl2br(htmlspecialchars($row['content'])) ?></p>

      <?php if (!empty($row['screenshot'])): ?>
        <div class="card-img">
          <img src="uploads/<?= htmlspecialchars($row['screenshot']) ?>" alt="Screenshot">
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="card-actions">
          <?php if ($_SESSION['role'] === 'student' && $_SESSION['user_id'] == $row['user_id']): ?>
            <a href="posts/edit.php?id=<?= $row['id'] ?>" class="btn-small">Edit</a>
          <?php endif; ?>
          <?php if ($_SESSION['role'] === 'admin' || $_SESSION['user_id'] == $row['user_id']): ?>
            <a href="posts/delete.php?id=<?= $row['id'] ?>" class="btn-small danger">Delete</a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>

<?php include './includes/footer.php'; ?>
