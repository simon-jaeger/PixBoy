<?php
require_once '../../global.php';

// load parsedown lib and render markdown file
require_once ROOT . '/vendor/Parsedown.php';
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);
$aboutText = $Parsedown->text(file_get_contents('./aboutText.md'));
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>About</h1>
    <?= $aboutText ?>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | About',
  'description' => 'About PixBoy and its creator, Simon Jäger',
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>
