<?php
// Clear the login session
session_start();
$_SESSION = [];

// Remove the PHP session cookie
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

session_destroy();
header('Location: login.php');
exit;

