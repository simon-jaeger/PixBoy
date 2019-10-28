<?php
// get first directory of url for nav highlight
$page['base'] = explode('/', $_SERVER['SCRIPT_NAME'])[2];
?>

<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- meta -->
    <!-- ------------------------------------------------------------------- -->
    <title><?= h($page['title'] ?? 'PixBoy') ?></title>
    <meta
      name="description"
      content="<?= h(
        $page['description'] ??
          'PixBoy, the platform and editor for Game Boy pixel art'
      ) ?>"
    />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />

    <!-- stylesheets -->
    <!-- ------------------------------------------------------------------- -->
    <link rel="stylesheet" href="/_assets/style/vendor_fontawesome.min.css" />
    <link rel="stylesheet" href="/_assets/style/reset.css" />
    <link rel="stylesheet" href="/_assets/style/base.css" />
    <link rel="stylesheet" href="/_assets/style/components.css" />
    <?php foreach ($page['css'] ?? [] as $css): ?>
      <link rel="stylesheet" href="<?= h($css) ?>" />
    <?php endforeach; ?>

    <!-- scripts -->
    <!-- ------------------------------------------------------------------- -->
    <script src="/_assets/script/vendor_jquery-3.4.1.slim.min.js" defer></script>
    <script src="/_assets/script/main.js" defer></script>
    <?php foreach ($page['js'] ?? [] as $js): ?>
      <script src="<?= h($js) ?>" defer></script>
    <?php endforeach; ?>
  </head>

  <!-- body -->
  <!-- --------------------------------------------------------------------- -->
  <body class="blockTransitions">
    <div class="site">
      <!-- header -->
      <!-- ----------------------------------------------------------------- -->
      <header class="header">
        <div class="header_inner">
          <a href="/home/">
            <img
              src="/_assets/images/logo-pixboy.svg"
              alt="PixBoy"
              class="header_logo"
          /></a>
          <button
            class="header_burger"
            title="Toggle nav"
            aria-label="Toggle nav">
          </button>
          <nav class="nav">
            <div class="nav_links">
              <a
                href="/gallery/"
                class="nav_link <?= h(
                  $page['base'] === 'gallery' ? 'is-current' : ''
                ) ?>"
              >Gallery</a>
              <a
                href="/help/"
                class="nav_link <?= h(
                  $page['base'] === 'help' ? 'is-current' : ''
                ) ?>"
              >Help</a>
              <a
                href="/about/"
                class="nav_link <?= h(
                  $page['base'] === 'about' ? 'is-current' : ''
                ) ?>"
              >About</a>
            </div>
            <div class="nav_account">
              <?php if (isset($_SESSION['isUser'])): ?>
                <a href="/dashboard/"
                   class="nav_accountDash <?= h(
                     $page['base'] === 'dashboard' ? 'is-current' : ''
                   ) ?>">
                  <i class="fas fa-user-circle"></i>
                  Dashboard
                </a>
                <a href="/log-out/" class="button is-ghost">Log Out</a>
              <?php else: ?>
                <a href="/sign-up/" class="button">Sign Up</a>
                <a href="/log-in/" class="button is-ghost">Log In</a>
              <?php endif; ?>
            </div>
          </nav>
        </div>
      </header>

      <!-- main -->
      <!-- ----------------------------------------------------------------- -->
      <?= $page['content'] ?? '' ?>

      <!-- footer -->
      <!-- ----------------------------------------------------------------- -->
      <footer class="footer">
        <div class="footer_inner">
          <div>© 2019 Simon Jäger</div>
          <div>
            <a
              href="https://github.com/simon-jaeger/PixBoy"
              target="_blank"
              rel="noreferrer"
              title="GitHub"
              class="footer_link"
            >
              Source availabe on <i class="fab fa-github" aria-label="GitHub"></i>
            </a>
            <a href="/legal-notice/" class="footer_link">Legal notice</a>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>
