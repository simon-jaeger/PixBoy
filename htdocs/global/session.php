<?php
session_start();

// initialize session
////////////////////////////////////////////////////////////////////////////////
$_SESSION['isUser'] = $_SESSION['isUser'] ?? null;
$_SESSION['isAdmin'] = $_SESSION['isAdmin'] ?? null;
$_SESSION['userId'] = $_SESSION['userId'] ?? null;
$_SESSION['username'] = $_SESSION['username'] ?? null;
$_SESSION['ip'] = $_SESSION['ip'] ?? $_SERVER['REMOTE_ADDR'];
$_SESSION['timestamp'] = $_SESSION['timestamp'] ?? time();

// security measures for authenticated sessions
////////////////////////////////////////////////////////////////////////////////
if (isset($_SESSION['isUser']) || isset($_SESSION['isAdmin'])) {
  // lock session to initial ip, log out if no match
  if ($_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
    redirect('/log-out/');
  }

  // limit session lifetime to 20 minutes of inactivity (no requests or pings)
  if (time() > $_SESSION['timestamp'] + 1200) {
    redirect('/log-out/');
  }
}

// refresh session
////////////////////////////////////////////////////////////////////////////////
$_SESSION['timestamp'] = time();
