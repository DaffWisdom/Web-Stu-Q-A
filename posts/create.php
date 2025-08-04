<?php include '../includes/header.php'; include '../dbase/config.php';

//Kiem tra dang nhap
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'admin'])) {
  header("Location: ../login.php");
  exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $user_id = $_POST['user_id'];
  $subject_id = $_POST['subject_id'];
  $screenshot = null;

  if (!empty($_FILES['screenshot']['name'])) {
    $upload_dir = '../uploads/';
    $filename = time() . '_' . basename($_FILES['screenshot']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
      $screenshot = $filename;
    }
  }

  $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id, subject_id, screenshot) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$title, $content, $user_id, $subject_id, $screenshot]);

  header("Location: /Coursework/index.php");
  exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
$subjects = $pdo->query("SELECT * FROM subjects")->fetchAll();
?>

<h2 class="page-title">📝 Create New Post</h2>
<form class="form-auth" method="POST" enctype="multipart/form-data">
  <label>Title:</label>
  <input type="text" name="title" required>

  <label>Content:</label>
  <textarea name="content" rows="5" style="width: 411px; height: 83px;" required></textarea>

  
  <div style="display: flex; align-items: center; gap: 10px;">
    <label style="margin: 0;">User:</label>
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <span><strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
  </div>

  <label>Modules:</label>
  <select name="subject_id">
    <?php foreach ($subjects as $s): ?>
      <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <label>Screenshot (optional):</label>
  <input type="file" name="screenshot">
  <input type="submit" value="Submit Post">
</form>

<?php include '../includes/footer.php'; ?>

