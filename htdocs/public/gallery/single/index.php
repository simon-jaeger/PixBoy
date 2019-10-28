<?php
require_once '../../../global.php';

// get drawing
// -----------------------------------------------------------------------------
$stmt = $db->prepare('
  SELECT drawing.*, date_format(drawing.lastUpdate, \'%Y/%m/%d\') as lastUpdate,  user.username FROM drawing
  JOIN user on drawing.userId=user.id 
  WHERE drawing.id=?
');
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$drawing = $stmt->get_result()->fetch_assoc();
$stmt->close();

// redirect to gallery if no drawing found
// -----------------------------------------------------------------------------
if (!$drawing) {
  redirect('/gallery/');
}

// get more drawings from user
// -----------------------------------------------------------------------------
$stmt = $db->prepare('
  SELECT * FROM drawing
  WHERE userId=?
  AND id!=?
  ORDER BY lastUpdate DESC
  LIMIT 5
');
$stmt->bind_param('ss', $drawing['userId'], $drawing['id']);
$stmt->execute();
$moreDrawings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<main class="main">
  <div class="main_inner">
    <!-- drawing -->
    <!-- ------------------------------------------------------------------- -->
    <figure class="drawingSingle">
      <img
        src="data:image/png;base64,<?= h($drawing['base64']) ?>"
        alt="<?= h($drawing['title']) ?>"
        class="drawingSingle_img"
      />
      <?php if (
        $drawing['userId'] === $_SESSION['userId'] ||
        $_SESSION['isAdmin']
      ): ?>
        <a
          href="/editor/?id=<?= h($drawing['id']) ?>"
          class="drawingSingle_edit"
        ><i class="fas fa-pen"></i> Edit</a>
      <?php endif; ?>
    </figure>

    <!-- info -->
    <!-- ------------------------------------------------------------------- -->
    <h1><?= h($drawing['title']) ?></h1>
    <small class="subLine">
      By <a href="/gallery/?search=<?= h($drawing['username']) ?>"
      ><?= h($drawing['username']) ?></a>
      • Updated <?= h($drawing['lastUpdate']) ?>
    </small>
    <p><?= h($drawing['description']) ?></p>
    <div class="spacer"></div>

    <!-- more drawings -->
    <!-- ------------------------------------------------------------------- -->
    <?php if (count($moreDrawings)): ?>
      <hr>
      <p>More by <?= h($drawing['username']) ?></p>
      <div class="drawings">
        <?php foreach ($moreDrawings as $moreDrawing): ?>
          <a
            href="/gallery/single/?id=<?= h($moreDrawing['id']) ?>"
            class="drawing"
          >
            <img
              src="data:image/png;base64,<?= h($moreDrawing['base64']) ?>"
              alt="<?= h($drawing['title']) ?>"
              class="drawing_img"
            />
            <h2 class="drawing_info"><?= h($moreDrawing['title']) ?></h2>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | ' . h($drawing['title']),
  'description' => h($drawing['description']),
  'css' => ['../style.css', './style.css'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>


