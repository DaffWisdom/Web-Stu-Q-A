<?php
session_start();
include './dbase/config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password  = $_POST['password']; 

  // Kiểm tra user theo email
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['role'] = $user['role'];

  header("Location: index.php");
  exit;
} else {
  $error = "Invalid email or password.";
}

}
?>

<?php include './includes/header.php'; ?>



<?php if (!empty($error)): ?>
  <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="login.php" method="POST" class="form-auth">
  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Password:</label>
  <input type="password" name="password" required>

  <input type="submit" value="Log In">
  <p>Don't have an account? <a href="register.php">Register here</a></p>
  <p style="text-align:center; font-size: 14px; margin-top: 10px;">
  Are you an admin? <a href="admin/login.php">Login here</a></p>

</form>

<?php include './includes/footer.php'; ?>
