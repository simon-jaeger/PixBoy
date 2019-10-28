<?php
// turn all errors into exceptions for uniform and simple error handling
////////////////////////////////////////////////////////////////////////////////
set_error_handler(function ($level, $message, $file = '', $line = 0) {
  throw new ErrorException($message, 0, $level, $file, $line);
});

// handle all exceptions globally
// show error in development and a simple notice in production
////////////////////////////////////////////////////////////////////////////////
set_exception_handler(function ($e) {
  error_log($e);
  http_response_code(500);
  if (DEV_MODE) {
    echo $e;
  } else {
    echo "<h1>500 Internal Server Error</h1>";
  }
});
