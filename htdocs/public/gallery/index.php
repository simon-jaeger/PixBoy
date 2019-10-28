<?php
require_once '../../global.php';

// get drawings, optionally filtered by search param
// -----------------------------------------------------------------------------
$search = $_GET['search'] ?? '';
$searchWithWildcards = '%' . $search . '%';
$stmt = $db->prepare('
  SELECT drawing.*, user.username FROM drawing
  JOIN user on drawing.userId=user.id
  WHERE drawing.title LIKE ? OR user.username=?
  ORDER BY drawing.lastUpdate DESC
  LIMIT 250
');
$stmt->bind_param('ss', $searchWithWildcards, $search);
$stmt->execute();
$drawings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <h1>Gallery</h1>

    <!-- actionsBar -->
    <!-- ------------------------------------------------------------------- -->
    <form method="get" class="actionsBar">
      <div class="inputAndButton">
        <div class="input">
          <input
            type="text"
            id="search"
            name="search"
            class="input_field is-labelHidden"
            maxlength="255"
            placeholder="Search by title or user..."
            value="<?= h($_GET['search'] ?? '') ?>"
          />
          <label for="search" class="srOnly">Search by title or user</label>
        </div>
        <button class="button is-icon" type="submit" title="search" aria-label="search">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

    <!-- drawings -->
    <!-- ------------------------------------------------------------------- -->
    <?php if (count($drawings)): ?>
      <div class="drawings">
        <?php foreach ($drawings as $drawing): ?>
          <a
            href="/gallery/single/?id=<?= h($drawing['id']) ?>"
            class="drawing"
          >
            <img
              src="data:image/png;base64,<?= h($drawing['base64']) ?>"
              alt="<?= h($drawing['title']) ?>"
              class="drawing_img"
            />
            <h2 class="drawing_info"><?= h($drawing['title']) ?></h2>
          </a>
        <?php endforeach; ?>
      </div>

    <!-- notice -->
    <!-- ------------------------------------------------------------------- -->
    <?php else: ?>
      <div class="notice">
        <p class="notice_text">No drawings found</p>
        <a href="/gallery/" class="button">Reset search</a>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Gallery',
  'description' => 'Explore a public gallery of Game Boy pixel art',
  'css' => ['./style.css'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

