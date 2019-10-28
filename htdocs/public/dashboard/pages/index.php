<?php
require_once '../../../global.php';

$errors = [];
$success = false;

// access restriction
// -----------------------------------------------------------------------------
if (!isset($_SESSION['isAdmin'])) {
  redirect('/log-in/');
}

// paths
// -----------------------------------------------------------------------------
$aboutTextPath = ROOT . '/public/about/aboutText.md';
$helpTextPath = ROOT . '/public/help/helpText.md';
$helpImgPath = ROOT . '/public/help/helpImg.png';

// save handler
// -----------------------------------------------------------------------------
if (isset($_POST['doSave'])) {
  // get help image
  // ---------------------------------------------------------------------------
  $helpImgTmp = $_FILES["helpImg"]["tmp_name"];
  $helpImgSize = $_FILES["helpImg"]["size"];

  // check image
  // ---------------------------------------------------------------------------
  if (
    $helpImgTmp &&
    (!exif_imagetype($helpImgTmp) || $helpImgSize > 50000000)
  ) {
    $errors[] = 'Help image is not a valid image file';
  }

  // update files if no errors
  // ---------------------------------------------------------------------------
  if (empty($errors)) {
    move_uploaded_file($helpImgTmp, $helpImgPath);

    $helpFile = fopen($helpTextPath, 'w');
    fwrite($helpFile, $_POST['helpText']);
    fclose($helpFile);

    $aboutFile = fopen($aboutTextPath, 'w');
    fwrite($aboutFile, $_POST['aboutText']);
    fclose($aboutFile);

    $success = true;
  }
}

// get texts from post or markdown files
// -----------------------------------------------------------------------------
$aboutText = $_POST['aboutText'] ?? file_get_contents($aboutTextPath);
$helpText = $_POST['helpText'] ?? file_get_contents($helpTextPath);
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Dashboard</h1>

    <!-- tabs -->
    <!-- ------------------------------------------------------------------- -->
    <div class="tabs">
      <a href="/dashboard/drawings/" class="tabs_item">Drawings</a>
      <a href="/dashboard/users/" class="tabs_item">Users</a>
      <a href="/dashboard/pages/" class="tabs_item is-current">Pages</a>
    </div>

    <!-- form -->
    <!-- ------------------------------------------------------------------- -->
    <form method="post" class="form" novalidate enctype="multipart/form-data">
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
          Saved successfully!
        </div>
      <?php endif; ?>

      <figure class="fileInput">
        <img
          src="/help/helpImg.png?<?= time() ?>"
          alt="Help image" class="fileInput_preview"
        >
        <figcaption class="fileInput_label">Help image</figcaption>
        <input
          type="file"
          accept="image/*"
          id="helpImage"
          name="helpImg"
          class="fileInput_button"
        >
      </figure>

      <div class="input">
        <textarea
          id="helpText"
          name="helpText"
          class="input_field is-areaBig"
          placeholder="_"
        ><?= h($helpText) ?></textarea>
        <label for="helpText" class="input_label">Help text</label>
      </div>

      <div class="input">
        <textarea
          id="aboutText"
          name="aboutText"
          class="input_field is-areaBig"
          placeholder="_"
        ><?= h($aboutText) ?></textarea>
        <label for="aboutText" class="input_label">About text</label>
      </div>

      <button class="button" type="submit" name="doSave">Save</button>
    </form>

  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Dashboard: Pages',
  'css' => ['../style.css'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

