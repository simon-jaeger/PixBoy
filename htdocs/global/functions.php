<?php
/**
 * shortcut to escape html and prevent xss
 * to be used for all echo statements unless raw html is absolutely necessary
 * @param $input - input
 * @return string - escaped output
 */
function h($input) {
  return htmlspecialchars($input, ENT_QUOTES);
}

/**
 * redirect and immediately terminate script
 * @param string $url - url to redirect to
 */
function redirect($url) {
  header('Location: ' . $url);
  die();
}

/**
 * log to browser console from php
 * used for debugging
 * @param $data - string or object to log to console
 */
function console_log($data) {
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}
