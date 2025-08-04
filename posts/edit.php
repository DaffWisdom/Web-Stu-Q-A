<?php
session_start();
include '../includes/header.php';
include '../dbase/config.php';

if (!isset($_GET['id'])) {
  echo "<p>Post ID is missing.</p>";
  include '../includes/footer.php';
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
  echo "<p>Post not found.</p>";
  include '../includes/footer.php';
  exit;
}

// ❌ Không cho admin hoặc người lạ sửa bài
if ($_SESSION['role'] !== 'student' || $_SESSION['user_id'] != $post['user_id']) {
  echo "<p style='color:red; text-align:center;'>⛔ You are not allowed to edit this post.</p>";
  include '../includes/footer.php';
  exit;
}

$subjects = $pdo->query("SELECT * FROM subjects")->fetchAll();

// Xử lý cập nhật
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $user_id = $_SESSION['user_id']; // cố định là người đang đăng nhập
  $subject_id = $_POST['subject_id'];
  $screenshot = $post['screenshot'];
  

  if (!empty($_FILES['screenshot']['name'])) {
    $upload_dir = '../uploads/';
    $filename = time() . '_' . basename($_FILES['screenshot']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
      $screenshot = $filename;
    }
  }

  $update = $pdo->prepare("UPDATE posts SET title = ?, content = ?, user_id = ?, subject_id = ?, screenshot = ? WHERE id = ?");
  $update->execute([$title, $content, $user_id, $subject_id, $screenshot, $id]);

  header("Location: /Coursework/index.php");
  exit;
}
?>

<h2 class="page-title">📝 Edit Post</h2>

<form class="form-auth" method="POST" enctype="multipart/form-data">
  <label>Title:</label>
  <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

  <label>Content:</label>
  <textarea name="content" rows="5" style="width: 411px; height: 83px;" required><?= htmlspecialchars($post['content']) ?></textarea>

  <div style="display: flex; align-items: center; gap: 10px;">
    <label style="margin: 0;">User:</label>
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <span><strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
  </div>


  <label>Modules:</label>
  <select name="subject_id">
    <?php foreach ($subjects as $s): ?>
      <option value="<?= $s['id'] ?>" <?= $s['id'] == $post['subject_id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($s['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Current Image:</label>
  <?php if ($post['screenshot']): ?>
    <img src="../uploads/<?= htmlspecialchars($post['screenshot']) ?>" width="120"><br>
  <?php else: ?>
    <p>No image.</p>
  <?php endif; ?>

  <label>Replace Image (optional):</label>
  <input type="file" name="screenshot">

  <input type="submit" value="Update Post">
</form>

<?php include '../includes/footer.php'; ?>
