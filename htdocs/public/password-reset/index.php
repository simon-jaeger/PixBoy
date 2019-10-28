<?php
require_once '../../global.php';

$errors = [];
$success = false;

// reset mail handler
// -----------------------------------------------------------------------------
if (isset($_POST['doSendResetMail'])) {
  // search email
  // ---------------------------------------------------------------------------
  $stmt = $db->prepare('SELECT * FROM user WHERE email=?');
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if (!$user) {
    $errors[] = 'Unknown email';
  }

  // proceed if no errors
  if (empty($errors)) {
    // generate random token and link for authentification
    // -------------------------------------------------------------------------
    $token = bin2hex(random_bytes(32));
    $link =
      (isset($_SERVER['HTTPS']) ? 'https' : 'http') .
      '://' .
      $_SERVER['HTTP_HOST'] .
      '/password-change/?token=' .
      $token;

    // store token in database
    // -------------------------------------------------------------------------
    $stmt = $db->prepare(
      'INSERT INTO password_reset_token (token, userId) VALUES (?, ?)'
    );
    $stmt->bind_param('si', $token, $user['id']);
    $stmt->execute();
    $stmt->close();

    // send mail
    // -------------------------------------------------------------------------
    $to = $user['email'];
    $subject = 'PixBoy - Password reset request';
    $message =
      'Hello ' .
      $user['username'] .
      "\r\n \r\n" .
      'To reset your password, visit the following link: ' .
      "\r\n" .
      $link .
      "\r\n \r\n" .
      'If you have not requested this email, you can just ignore it.' .
      "\r\n \r\n" .
      '--' .
      "\r\n" .
      'PixBoy';
    $headers = [
      'From' => 'noreply@pixboy',
      'Reply-To' => 'noreply@pixboy',
    ];
    mail($to, $subject, $message, $headers);

    $success = true;
  }
}
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Reset password</h1>
    <p>Please enter the email address you used to sign up. You'll receive an email with a special link to reset your password.</p>

    <form method="post" class="form" novalidate>
      <?php if (count($errors)): ?>
      <div class="alert is-error">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= h($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert is-success">
          Email sent successfully!
        </div>
      <?php endif; ?>

      <div class="input">
        <input
          type="email"
          id="email"
          name="email"
          class="input_field"
          maxlength="255"
          placeholder="_"
          value="<?= h($_POST['email'] ?? '') ?>"
        />
        <label for="email" class="input_label">Email</label>
      </div>

      <button class="button" type="submit" name="doSendResetMail">Send Reset Email</button>
    </form>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Reset password',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

