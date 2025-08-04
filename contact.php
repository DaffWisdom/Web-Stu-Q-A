<?php include 'includes/header.php'; ?>

<?php
$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("sendmail_from", "duy123@gmail.com");

    $to = "duy310705@gmail.com";
    $subject = "📩 New Contact Message from Q&A Portal";
    $fullMessage = "From: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $name <$email>";

    $sent = mail($to, $subject, $fullMessage, $headers);

    if ($sent) {
      $successMessage = "✅ Thank you $name! Your message has been sent.";
    } else {
      $errorMessage = "❌ Failed to send message. Please try again later.";
    }
  }
}
?>

<h2 class="page-title">📩 Contact Admin</h2>

<?php if ($successMessage): ?>
  <div class="form-auth" style="color:green; text-align:center;"><?= $successMessage ?></div>
<?php elseif ($errorMessage): ?>
  <div class="form-auth" style="color:red; text-align:center;"><?= $errorMessage ?></div>
<?php endif; ?>
<p class="form-auth" style="text-align:center;">
  📧 Contact Email: <strong>duy310705@gmail.com</strong>
</p>

<form class="form-auth" method="POST">
  <label>Your Username:</label>
  <input type="text" name="name" required>

  <label>Your Email:</label>
  <input type="email" name="email" required>

  <label>Your Message:</label>
  <textarea name="message" rows="5" style="width: 411px; height: 83px;" required></textarea>

  <input type="submit" value="Send Message" class="btn">
</form>

<?php include 'includes/footer.php'; ?>
