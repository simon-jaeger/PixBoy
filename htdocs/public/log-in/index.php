<?php
require_once '../../global.php';

$errors = [];

// login handler
// -------------------------------------------------------------------------
if (isset($_POST['doLogin'])) {
  do {
    // delete failure entries older than 10 minutes
    // -------------------------------------------------------------------------
    $db->query('
      DELETE FROM failed_login_attempt
      WHERE UNIX_TIMESTAMP(timestamp) + 600 < UNIX_TIMESTAMP()
    ');

    // check for too many failed login attempts
    // -------------------------------------------------------------------------
    $stmt = $db->prepare('SELECT * FROM failed_login_attempt WHERE ip=?');
    $stmt->bind_param('s', $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    $failedAttempts = $stmt->get_result()->num_rows;
    $stmt->close();
    if ($failedAttempts >= 5) {
      $errors[] = 'Too many failed login attempts, try again later';
      break;
    }

    // check user
    // -------------------------------------------------------------------------
    $stmt = $db->prepare('SELECT * FROM user WHERE username=?');
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$user) {
      $errors[] = 'Unknown user';
      break;
    }

    // check password
    // -------------------------------------------------------------------------
    if (!password_verify($_POST['password'], $user['passwordHash'])) {
      $errors[] = 'Wrong password';
      break;
    }

    // update lastLogin
    // -------------------------------------------------------------------------
    $stmt = $db->prepare(
      'UPDATE user SET lastLogin=current_timestamp() WHERE id=?'
    );
    $stmt->bind_param('i', $user['id']);
    $stmt->execute();
    $stmt->close();

    // delete failure entries of ip
    // -------------------------------------------------------------------------
    $stmt = $db->prepare('
      DELETE FROM failed_login_attempt
      WHERE ip=?
    ');
    $stmt->bind_param('s', $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    $stmt->close();

    // log in
    // -------------------------------------------------------------------------
    session_regenerate_id(true); // regenerate session id for security
    $_SESSION['isUser'] = true;
    $_SESSION['isAdmin'] = $user['isAdmin'] ? true : null;
    $_SESSION['userId'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    redirect('/dashboard/');
  } while (0);
}

// log failed login attempt
// -----------------------------------------------------------------------------
if (count($errors)) {
  $stmt = $db->prepare('INSERT INTO failed_login_attempt (ip) VALUES (?)');
  $stmt->bind_param('s', $_SERVER['REMOTE_ADDR']);
  $stmt->execute();
  $stmt->close();
}
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Log in</h1>

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

      <div class="input">
        <input
          type="text"
          id="username"
          name="username"
          class="input_field"
          maxlength="32"
          placeholder="_"
          value="<?= h($_POST['username'] ?? '') ?>"
        />
        <label for="username" class="input_label">Username</label>
      </div>

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

      <button class="button" type="submit" name="doLogin">Log In</button>

      <p>
        Forgot password?<br>
        <a href="/password-reset/">Reset password</a>
      </p>
    </form>

  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Log in',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

