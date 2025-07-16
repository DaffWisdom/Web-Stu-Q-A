<?php include './includes/header.php'; ?>

<h2>Register</h2>
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
