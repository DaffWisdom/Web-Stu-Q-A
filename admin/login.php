<?php
session_start();
include '../dbase/config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Chỉ tìm admin
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
  $stmt->execute([$email]);
  $admin = $stmt->fetch();

  if ($admin && password_verify($password, $admin['password'])) {
    // Đăng nhập thành công
    $_SESSION['user_id'] = $admin['id'];
    $_SESSION['username'] = $admin['username'];
    $_SESSION['role'] = $admin['role'];

    header("Location: dashboard.php");
    exit;
  } else {
    $error = "❌ Invalid email or password.";
  }
}
?>

<?php include '../includes/header.php'; ?>

<h2>🔐 Admin Login</h2>

<?php if ($error): ?>
  <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" class="form-auth">
  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Password:</label>
  <input type="password" name="password" required>

  <input type="submit" value="Log In as Admin">
</form>

<?php include '../includes/footer.php'; ?>
