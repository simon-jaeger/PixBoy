<?php
require_once '../../../global.php';

// access restriction
// -----------------------------------------------------------------------------
if (!isset($_SESSION['isAdmin'])) {
  redirect('/log-in/');
}

// delete user handler
// -----------------------------------------------------------------------------
if (isset($_GET['doDeleteItem'])) {
  // delete drawings of user
  $stmt = $db->prepare(' DELETE FROM drawing WHERE userId=? ');
  $stmt->bind_param('i', $_GET['doDeleteItem']);
  $stmt->execute();
  $stmt->close();

  // delete password reset tokens of user
  $stmt = $db->prepare(' DELETE FROM password_reset_token WHERE userId=? ');
  $stmt->bind_param('i', $_GET['doDeleteItem']);
  $stmt->execute();
  $stmt->close();

  // delete user
  $stmt = $db->prepare('DELETE FROM user WHERE id=? LIMIT 1');
  $stmt->bind_param('i', $_GET['doDeleteItem']);
  $stmt->execute();
  $stmt->close();

  redirect('/dashboard/users/');
}

// get users, optionally filtered by search param
// -----------------------------------------------------------------------------
$search = $_GET['search'] ?? '';
$searchWithWildcards = '%' . $search . '%';
$stmt = $db->prepare('
  SELECT *, date_format(lastLogin, \'%Y/%m/%d\') as lastLoginFormated FROM user 
  WHERE username LIKE ?
  ORDER BY lastLogin DESC
  LIMIT 250
');
$stmt->bind_param('s', $searchWithWildcards);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
    <div class="tabs">
      <a href="/dashboard/drawings/" class="tabs_item">Drawings</a>
      <a href="/dashboard/users/" class="tabs_item is-current">Users</a>
      <a href="/dashboard/pages/" class="tabs_item">Pages</a>
    </div>

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
            placeholder="Search by name..."
            value="<?= h($search) ?>"
          />
          <label for="search" class="srOnly">Search by name</label>
        </div>
        <button class="button is-icon" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>

    <!-- users -->
    <!-- ------------------------------------------------------------------- -->
    <?php if (count($users)): ?>
      <ul class="items">
        <?php foreach ($users as $user): ?>
          <li class="item">
            <div class="item_infos">
              <div class="item_text">
                <h2 class="item_title"><?= h($user['username']) ?></h2>
                <small class="item_sub">
                  Last login <?= h($user['lastLoginFormated']) ?>
                </small>
              </div>
            </div>
            <button class="item_toggle" title="toggle actions">
              <i class="fas fa-caret-down"></i>
            </button>
            <div class="item_actions">
              <button
                class="item_action"
                data-delete-id="<?= h($user['id']) ?>"
                data-delete-name="<?= h($user['username']) ?>"
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
        <p class="notice_text">No users found</p>
        <a href="/dashboard/users/" class="button">Reset search</a>
      </div>
    <?php endif; ?>

    <!-- modal (delete) -->
    <!-- ------------------------------------------------------------------- -->
    <dialog class="modal">
      <div class="modal_inner">
        <h3 class="modal_title">Warning</h3>
        <p>
          Really delete user <strong data-target-name></strong>?
          This will also delete all drawings of this user!
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
  'title' => 'PixBoy | Dashboard: Users',
  'css' => ['../style.css'],
  'js' => ['../script.js'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>

