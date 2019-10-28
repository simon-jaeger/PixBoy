<?php
require_once '../../global.php';

$errors = [];
$success = false;

// access restriction
// -----------------------------------------------------------------------------
if (!isset($_SESSION['isUser'])) {
  redirect('/log-in/');
}

// save handler
// -----------------------------------------------------------------------------
if (isset($_POST['doSave'])) {
  do {
    // get submitted drawing data
    // -------------------------------------------------------------------------
    $drawing['id'] = $_GET['id'] ?? null;
    $drawing['title'] = trim($_POST['title']);
    if ($drawing['title'] === '') {
      $drawing['title'] = 'Untitled';
    }
    $drawing['description'] = trim($_POST['description']);
    $drawing['shadesArray'] = $_POST['shadesArray'];
    $drawing['shadeActive'] = (int) $_POST['shadeActive'];

    // check title
    // -------------------------------------------------------------------------
    if (!preg_match('/^.{1,32}$/u', $drawing['title'])) {
      $errors[] = 'Title invalid';
      break;
    }

    // check description
    // -------------------------------------------------------------------------
    if (mb_strlen($drawing['description']) > 255) {
      $errors[] = 'Description invalid';
      break;
    }

    // check shadesArray
    // -------------------------------------------------------------------------
    if (!preg_match('/^[0-3]{256}$/', $drawing['shadesArray'])) {
      $errors[] = 'Drawing invalid';
      break;
    }

    // generate base64
    // -------------------------------------------------------------------------
    require_once './_shadesArrayToBase64.php';
    $drawing['base64'] = shadesArrayToBase64($drawing['shadesArray']);

    // save drawing
    // -------------------------------------------------------------------------
    $stmt = $db->prepare('
      UPDATE drawing 
      SET
        title=?,
        description=?,
        lastUpdate=current_timestamp(),
        shadesArray=?,
        base64=?
      WHERE id=?
      AND (userId=? OR ?)
    ');
    $stmt->bind_param(
      'ssssiis',
      $drawing['title'],
      $drawing['description'],
      $drawing['shadesArray'],
      $drawing['base64'],
      $drawing['id'],
      $_SESSION['userId'],
      $_SESSION['isAdmin']
    );
    $stmt->execute();
    $stmt->close();

    $success = true;
  } while (0);
}

// load drawing from database if not a POST save request
// -----------------------------------------------------------------------------
else {
  $stmt = $db->prepare('
    SELECT * FROM drawing
    WHERE id=?
    AND (userId=? OR ?)
    LIMIT 1
  ');
  $stmt->bind_param(
    'iis',
    $_GET['id'],
    $_SESSION['userId'],
    $_SESSION['isAdmin']
  );
  $stmt->execute();
  $drawing = $stmt->get_result()->fetch_assoc();
  $drawing['shadeActive'] = 3;
  $stmt->close();
}

// redirect to dashboard if no drawing found
// -----------------------------------------------------------------------------
if (!isset($drawing['id'])) {
  redirect('/dashboard/');
}

// form open if errors or success
// -----------------------------------------------------------------------------
if (count($errors) || $success) {
  $drawing['formOpen'] = true;
}
?>

<?php
// markup
////////////////////////////////////////////////////////////////////////////////
ob_start();
?>
<!-- pass data from php to js -->
<!-- ----------------------------------------------------------------------- -->
<script> let PHP = <?= json_encode($drawing) ?> </script>

<!-- editor: view -->
<!-- ----------------------------------------------------------------------- -->
<main class="main" id="editor">
  <div class="main_inner" v-cloak>
    <div class="editor">
      <!-- editor_ui -->
      <!-- ----------------------------------------------------------------- -->
      <div class="editor_ui">
        <div
          class="editor_pixels"
          @touchstart.prevent="historyPush"
          @touchend.prevent="paintTouch"
          @touchmove.prevent="paintTouch"
        >
          <div
            v-for="(shade, i) in shadesArray"
            class="editor_pixel"
            :data-color="shade"
            :data-i="i"
            @mousedown="historyPush"
            @mouseup="paint(i, shadeActive)"
            @mousemove="paint(i, shadeActive)"
          ></div>
        </div>
        <div class="editor_colors">
          <button
            v-for="i in [0, 1, 2, 3]"
            class="editor_color"
            :class="{'is-current': shadeActive === i}"
            :data-color="i"
            :title="'Shade ' + i"
            @click="shadeActive = i"
          ></button>
        </div>
        <div class="editor_actions">
          <button
            class="editor_action"
            title="Back"
            @click="historyPop"
            :disabled="!history.length"
          >
            <i class="fas fa-undo-alt"></i>
          </button>
          <button
            class="editor_action"
            title="Forward"
            @click="reverseHistoryPop"
            :disabled="!reverseHistory.length"
          >
            <i class="fas fa-redo-alt"></i>
          </button>
          <div></div>
          <button
            class="editor_action is-save"
            title="Save"
            @click="formOpen = true"
          >
            <i class="fas fa-save"></i>
          </button>
        </div>
      </div>

      <!-- editor_form -->
      <!-- ----------------------------------------------------------------- -->
      <div class="editor_form" :class="{'is-open': formOpen}">
        <button class="editor_formClose" @click="formOpen = false">
          <i class="fas fa-arrow-left"></i>
        </button>

        <form method="post" class="form" novalidate @submit="isSubmitting=true">
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
              id="title"
              name="title"
              class="input_field"
              maxlength="32"
              placeholder="_"
              v-model="title"
            />
            <label for="title" class="input_label">Title</label>
          </div>

          <div class="input">
            <textarea
              id="description"
              name="description"
              class="input_field is-area"
              placeholder="_"
              maxlength="255"
              v-model="description"
            ></textarea>
            <label for="description" class="input_label">Description</label>
          </div>

          <input
            type="hidden"
            name="shadeActive"
            v-model="shadeActive"
          />

          <input
            type="hidden"
            name="shadesArray"
            v-model="shadesArray.join('')"
          />

          <button class="button" type="submit" name="doSave">Save</button>

          <?php if ($success): ?>
            <div class="alert is-success is-fadesOut">
              Saved successfully!
            </div>
          <?php endif; ?>

        </form>
      </div>
    </div>
  </div>
</main>

<?php
// settings
////////////////////////////////////////////////////////////////////////////////
$page = [
  'title' => 'PixBoy | Editor: ' . h($drawing['title']),
  'css' => ['./style.css'],
  'js' => ['./vendor_vue.min.js', './script.js'],
  'content' => ob_get_clean(),
];
require_once ROOT . '/layouts/default.php';
?>
