<?php include './includes/header.php'; ?>

<h2>Login</h2>
<form action="login.php" method="POST" class="form-auth">
  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Password:</label>
  <input type="password" name="password" required>

  <input type="submit" value="Log In">
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>

<?php include './includes/footer.php'; ?>
