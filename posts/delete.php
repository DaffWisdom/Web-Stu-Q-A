<?php include '../includes/header.php'; include '../dbase/config.php';

if (!isset($_GET['id'])) {
  echo "<p>Post ID missing.</p>"; include '../includes/footer.php'; exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
  echo "<p>Post not found.</p>"; include '../includes/footer.php'; exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if ($post['screenshot'] && file_exists("../uploads/" . $post['screenshot'])) {
    unlink("../uploads/" . $post['screenshot']);
  }

  $del = $pdo->prepare("DELETE FROM posts WHERE id = ?");
  $del->execute([$id]);

  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">🗑️ Delete Confirmation</h2>
<div class="form-auth">
  <p>Are you sure you want to delete this post?</p>
  <p><strong>Title:</strong> <?= htmlspecialchars($post['title']) ?></p>
  <form method="POST">
    <input type="submit" value="Yes, Delete" class="btn danger">
    <a href="index.php" class="btn-outline">Cancel</a>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
