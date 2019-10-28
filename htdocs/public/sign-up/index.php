<?php
require_once '../../global.php';

$errors = [];

if (isset($_POST['doSignUp'])) {
  // check email format
  // ---------------------------------------------------------------------------
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email';
  } else {
    // ... and availability
    $stmt = $db->prepare('SELECT email FROM user WHERE email=?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows) {
      $errors[] = 'Email already taken';
    }
    $stmt->close();
  }

  // check username format
  // ---------------------------------------------------------------------------
  if (!preg_match('/^[[:alnum:]-]{1,32}$/u', $_POST['username'])) {
    $errors[] = 'Username may only contain letters, numbers and hyphens';
  } else {
    // ... and availability
    $stmt = $db->prepare('SELECT username FROM user WHERE username=?');
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows) {
      $errors[] = 'Username already taken';
    }
    $stmt->close();
  }

  // check password match
  // ---------------------------------------------------------------------------
  if ($_POST['password'] !== $_POST['confirmPassword']) {
    $errors[] = 'Passwords don\'t match';
  }
  // ... and strength
  elseif (
    preg_match(
      '/^(.{0,7}|[^[:upper:]]*|[^[:lower:]]*|[^[:digit:]]*|[[:alnum:]|[:space:]]*)$/u',
      $_POST['password']
    )
  ) {
    $errors[] =
      'Password must contain at least 8 characters and include both upper and lowercase letters, numbers and symbols';
  }

  // check legal notice accepted
  // ---------------------------------------------------------------------------
  if (!isset($_POST['legalNotice'])) {
    $errors[] = 'Please accept the legal notice';
  }

  // proceed if no errors
  if (empty($errors)) {
    // create account
    // -------------------------------------------------------------------------
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare(
      'INSERT INTO user (email, username, passwordHash) VALUES (?, ?, ?)'
    );
    $stmt->bind_param(
      'sss',
      $_POST['email'],
      $_POST['username'],
      $passwordHash
    );
    $stmt->execute();
    $stmt->close();

    // log in
    // -------------------------------------------------------------------------
    session_regenerate_id(true); // regenerate session id for security
    $_SESSION['isUser'] = true;
    $_SESSION['userId'] = $db->insert_id;
    $_SESSION['username'] = $_POST['username'];
    redirect('/dashboard/');
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
    <h1>Sign up</h1>

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

      <div class="check">
        <input
          type="checkbox"
          id="legalNotice"
          name="legalNotice"
          <?= h($_POST['legalNotice'] ?? false ? 'checked' : '') ?>
        />
        <label for="legalNotice" class="check_label">
          I have read and accept PixBoy's <a href="/legal-notice/">legal notice</a>
        </label>
      </div>

      <button class="button" type="submit" name="doSignUp">Sign Up</button>

      <p>
        Already signed up?<br>
        <a href="/log-in/">Log in</a>
      </p>
    </form>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Sign up',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>
