<?php
require_once '../../../global.php';

// access restriction
// -----------------------------------------------------------------------------
if (!isset($_SESSION['isUser'])) {
  redirect('/log-in/');
}

// new drawing handler
// -----------------------------------------------------------------------------
if (isset($_GET['doNewDrawing'])) {
  $stmt = $db->prepare('INSERT INTO drawing (userId) VALUES (?)');
  $stmt->bind_param('i', $_SESSION['userId']);
  $stmt->execute();
  $stmt->close();
  redirect('/editor?id=' . $db->insert_id);
}

// delete drawing handler
// -----------------------------------------------------------------------------
if (isset($_GET['doDeleteItem'])) {
  $stmt = $db->prepare('
    DELETE FROM drawing
    WHERE id=?
    AND (userId=? OR ?)
    LIMIT 1
  ');
  $stmt->bind_param(
    'iis',
    $_GET['doDeleteItem'],
    $_SESSION['userId'],
    $_SESSION['isAdmin']
  );
  $stmt->execute();
  $stmt->close();
  redirect('/dashboard/drawings/');
}

// get drawings of user, all if admin, optionally filtered by search param
// -----------------------------------------------------------------------------
$search = $_GET['search'] ?? '';
$searchWithWildcards = '%' . $search . '%';
$stmt = $db->prepare('
  SELECT *, date_format(lastUpdate, \'%Y/%m/%d\') as lastUpdateFormated FROM drawing 
  WHERE (userId=? OR ?)
  AND title LIKE ?
  ORDER BY lastUpdate DESC
  LIMIT 250
');
$stmt->bind_param(
  'iss',
  $_SESSION['userId'],
  $_SESSION['isAdmin'],
  $searchWithWildcards
);
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
    <h1>Dashboard</h1>

    <!-- tabs -->
    <!-- ------------------------------------------------------------------- -->
    <?php if (isset($_SESSION['isAdmin'])): ?>
      <div class="tabs">
        <a href="/dashboard/drawings/" class="tabs_item is-current">Drawings</a>
        <a href="/dashboard/users/" class="tabs_item">Users</a>
        <a href="/dashboard/pages/" class="tabs_item">Pages</a>
      </div>
    <?php endif; ?>

    <!-- actionsBar -->
    <!-- ------------------------------------------------------------------- -->
    <div class="actionsBar">
      <form method="get" class="inputAndButton" novalidate>
        <div class="input">
          <input
            type="text"
            id="search"
            name="search"
            class="input_field is-labelHidden"
            maxlength="255"
            placeholder="Search by title..."
            value="<?= h($_GET['search'] ?? '') ?>"
          />
          <label for="search" class="srOnly">Search by title</label>
        </div>
        <button class="button is-icon" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
      <a href="?doNewDrawing" class="button">New Drawing</a>
    </div>

    <!-- drawings -->
    <!-- ------------------------------------------------------------------- -->
    <?php if (count($drawings)): ?>
      <ul class="items">
        <?php foreach ($drawings as $drawing): ?>
          <li class="item">
            <a href="/editor/?id=<?= h($drawing['id']) ?>" class="item_infos">
              <img
                src="data:image/png;base64,<?= h($drawing['base64']) ?>"
                alt="<?= h($drawing['title']) ?>"
                class="item_thumb"
              />
              <div class="item_text">
                <h2 class="item_title"><?= h($drawing['title']) ?></h2>
                <small class="item_sub">
                  Updated <?= h($drawing['lastUpdateFormated']) ?>
                </small>
              </div>
            </a>
            <button class="item_toggle" title="toggle actions">
              <i class="fas fa-caret-down"></i>
            </button>
            <div class="item_actions">
              <a
                href="/editor/?id=<?= h($drawing['id']) ?>"
                class="item_action"
              >
                <i class="item_actionicon fas fa-pen"></i>
                <span class="item_actionlabel">Edit</span>
              </a>
              <a
                href="/gallery/single/?id=<?= h($drawing['id']) ?>"
                class="item_action"
              >
                <i class="item_actionicon fas fa-eye"></i>
                <span class="item_actionlabel">View</span>
              </a>
              <button
                class="item_action"
                data-delete-id="<?= h($drawing['id']) ?>"
                data-delete-name="<?= h($drawing['title']) ?>"
              >
                <i class="item_actionicon fas fa-trash-alt"></i>
                <span class="item_actionlabel">Delete</span>
              </button>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

    <!-- notice -->
    <!-- ------------------------------------------------------------------- -->
    <?php else: ?>
      <div class="notice">
        <?php if (isset($_GET['search'])): ?>
          <p class="notice_text">No drawings found</p>
          <a href="/dashboard/drawings/" class="button">Reset search</a>
        <?php else: ?>
          <p class="notice_text">
            Welcome to PixBoy, <?= h($_SESSION['username']) ?>!<br>
            It’s time to create your first drawing.
          </p>
          <a href="?doNewDrawing" class="button">New Drawing</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- modal (delete) -->
    <!-- ------------------------------------------------------------------- -->
    <dialog class="modal">
      <div class="modal_inner">
        <h3 class="modal_title">Warning</h3>
        <p>
          Really delete drawing <strong data-target-name></strong>?
          This action cannot be undone!
        </p>
        <div class="modal_actions">
          <button class="button is-text modal_cancel">Cancel</button>
          <a data-target-id href="#" class="button is-danger">Delete</a>
        </div>
        <button class="modal_close" title="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </dialog>

  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Dashboard: Drawings',
  'css' => ['../style.css'],
  'js' => ['../script.js'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

