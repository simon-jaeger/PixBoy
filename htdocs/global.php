<?php
define('ROOT', dirname(__FILE__));

require_once ROOT . '/global/config.php';
require_once ROOT . '/global/error-handling.php';
require_once ROOT . '/global/functions.php';
require_once ROOT . '/global/session.php';
require_once ROOT . '/global/database.php';

if (DEV_MODE) {
  require_once ROOT . '/global/debug.php';
}
