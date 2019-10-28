<?php
require_once '../../global.php';

$errors = [];
$success = false;
$token = $_GET['token'] ?? null;

do {
  // delete tokens older than 10 minutes
  // ---------------------------------------------------------------------------
  $db->query('
    DELETE FROM password_reset_token
    WHERE UNIX_TIMESTAMP(timestamp) + 600 < UNIX_TIMESTAMP()
  ');

  // check token
  // ---------------------------------------------------------------------------
  $stmt = $db->prepare('SELECT * FROM password_reset_token WHERE token=?');
  $stmt->bind_param('s', $token);
  $stmt->execute();
  $token = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  if (!$token) {
    $errors[] = 'Reset link has expired';
    break;
  }

  if (isset($_POST['doChangePassword'])) {
    // check password match
    // -------------------------------------------------------------------------
    if ($_POST['password'] !== $_POST['confirmPassword']) {
      $errors[] = 'Passwords don\'t match';
      break;
    }
    // check password strength
    // -------------------------------------------------------------------------
    if (
      preg_match(
        '/(*UTF8)^(.{0,7}|[^[:upper:]]*|[^[:lower:]]*|[^[:digit:]]*|[[:alnum:]|[:space:]]*)$/',
        $_POST['password']
      )
    ) {
      $errors[] =
        'Password must contain at least 8 characters and include both upper and lowercase letters, numbers and symbols';
      break;
    }

    // update password
    // -------------------------------------------------------------------------
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare('UPDATE user SET passwordHash=? WHERE id=?');
    $stmt->bind_param('si', $passwordHash, $token['userId']);
    $stmt->execute();
    $stmt->close();

    // delete token
    // -------------------------------------------------------------------------
    $stmt = $db->prepare('DELETE FROM password_reset_token WHERE token=?');
    $stmt->bind_param('s', $token['token']);
    $stmt->execute();
    $stmt->close();

    // show success msg
    // -------------------------------------------------------------------------
    $success = true;
  }
} while (0);
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Change password</h1>
    <p>Please choose a new password.</p>

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
          Password changed successfully! <a href="/log-in/">Log in</a>
        </div>
      <?php endif; ?>

      <div class="input">
        <input
          type="password"
          id="password"
          name="password"
          class="input_field"
          maxlength="255"
          placeholder="_"
        />
        <label for="password" class="input_label">Password</label>
      </div>

      <div class="input">
        <input
          type="password"
          id="confirmPassword"
          name="confirmPassword"
          class="input_field"
          maxlength="255"
          placeholder="_"
        />
        <label for="confirmPassword" class="input_label">Confirm password</label>
      </div>

      <button class="button" type="submit" name="doChangePassword">Change Password</button>
    </form>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Change password',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

