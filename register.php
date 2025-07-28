<?php
session_start();
include './dbase/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if ($password !== $confirm) {
    $error = "Passwords do not match!";
  } else {
    // Kiểm tra xem email đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
      $error = "Email already registered.";
    } else {
      // ✅ Mã hóa mật khẩu
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Thêm người dùng
      $insert = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'student')");
      $insert->execute([$username, $email, $hashedPassword]);

      header("Location: login.php");
      exit;
    }
  }
}
?>

<?php include './includes/header.php'; ?>

<?php if ($error): ?>
  <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="register.php" method="POST" class="form-auth">
  <label>Username:</label>
  <input type="text" name="username" required>

  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Password:</label>
  <input type="password" name="password" required>

  <label>Confirm Password:</label>
  <input type="password" name="confirm_password" required>

  <input type="submit" value="Register">
  <p>Already have an account? <a href="login.php">Login here</a></p>
</form>

<?php include './includes/footer.php'; ?>
