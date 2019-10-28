<?php
require_once '../../global.php';

// load parsedown lib and render markdown file
require_once ROOT . '/vendor/Parsedown.php';
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);
$helpText = $Parsedown->text(file_get_contents('./helpText.md'));
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Help</h1>
    <img src="./helpImg.png?<?= time() ?>" alt="Pixel editor with legend">
    <?= $helpText ?>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Help',
  'description' => 'Learn how PixBoy works',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

