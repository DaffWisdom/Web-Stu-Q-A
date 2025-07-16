<?php include '../includes/header.php'; include '../dbase/config.php';

if (!isset($_GET['id'])) {
  echo "<p>Post ID is missing.</p>"; include '../includes/footer.php'; exit;
}

$id = $_GET['id'];
$post = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$post->execute([$id]);
$post = $post->fetch();

if (!$post) {
  echo "<p>Post not found.</p>"; include '../includes/footer.php'; exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
$subjects = $pdo->query("SELECT * FROM subjects")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $user_id = $_POST['user_id'];
  $subject_id = $_POST['subject_id'];
  $current_image = $_POST['current_image'];
  $screenshot = $current_image;

  if (!empty($_FILES['screenshot']['name'])) {
    $upload_dir = '../uploads/';
    $filename = time() . '_' . basename($_FILES['screenshot']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
      if ($current_image && file_exists($upload_dir . $current_image)) {
        unlink($upload_dir . $current_image);
      }
      $screenshot = $filename;
    }
  }

  $update = $pdo->prepare("UPDATE posts SET title=?, content=?, user_id=?, subject_id=?, screenshot=? WHERE id=?");
  $update->execute([$title, $content, $user_id, $subject_id, $screenshot, $id]);

  header("Location: index.php");
  exit;
}
?>

<h2 class="page-title">✏️ Edit Post</h2>
<form class="form-auth" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="current_image" value="<?= htmlspecialchars($post['screenshot']) ?>">

  <label>Title:</label>
  <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

  <label>Content:</label>
  <textarea name="content" rows="5" style="width: 411px; height: 83px;" required><?= htmlspecialchars($post['content']) ?></textarea>

  <label>User:</label>
  <select name="user_id">
    <?php foreach ($users as $u): ?>
      <option value="<?= $u['id'] ?>" <?= $u['id'] == $post['user_id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($u['username']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Subject:</label>
  <select name="subject_id">
    <?php foreach ($subjects as $s): ?>
      <option value="<?= $s['id'] ?>" <?= $s['id'] == $post['subject_id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($s['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>
  
  <div style="text-align: center; margin-top: 20px;">
  <p><strong>Current Image:</strong></p>
  <?php if ($post['screenshot']): ?>
    <img src="../uploads/<?= htmlspecialchars($post['screenshot']) ?>" width="150" style="border-radius: 6px;"><br>
  <?php else: ?>
    <em>No image.</em>
  <?php endif; ?>
  </div>

  <label>Replace Image (optional):</label>
  <input type="file" name="screenshot">

  <input type="submit" value="Update Post">
</form>

<?php include '../includes/footer.php'; ?>
