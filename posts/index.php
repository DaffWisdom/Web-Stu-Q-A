<?php
include __DIR__ . '/../dbase/config.php';
include __DIR__ . '/../includes/header.php';

// Lấy tất cả bài đăng kèm user & subject
$stmt = $pdo->query("
  SELECT posts.*, users.username, subjects.name AS subject_name
  FROM posts
  JOIN users ON posts.user_id = users.id
  JOIN subjects ON posts.subject_id = subjects.id
  ORDER BY posts.created_at DESC
");
?>

<h2 class="page-title">📋 All Posts</h2>
<a href="create.php" class="btn">➕ Create New Post</a>

<table class="styled-table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Author</th>
      <th>Subject</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $stmt->fetch()): ?>
    <tr>
      <td><?= $row['title'] ?></td>
      <td><?= $row['user_id'] ?></td>
      <td><?= $row['subject_id'] ?></td>
      <td><img>
        <?php if ($row['screenshot']): ?>
          <img src="../uploads/<?=($row['screenshot']) ?>" width="230">
        <?php else: ?>
          No image
        <?php endif; ?>
      </td>
      <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-small">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" class="btn-small danger">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
