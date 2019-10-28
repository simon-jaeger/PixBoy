<?php
if (DEV_MODE) {
  // output various data to console for debugging purposes
  console_log('$_SESSION');
  console_log($_SESSION);

  console_log('$_GET');
  console_log($_GET);

  console_log('$_POST');
  console_log($_POST);

  console_log('$_FILES');
  console_log($_FILES);
}
