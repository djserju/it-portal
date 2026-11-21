<?php
// Database settings for XAMPP
// The h() function below is used to escape output in HTML
define('DB_HOST', 'localhost');
define('DB_NAME', 'itportal');
define('DB_USER', 'root');
define('DB_PASS', '');

// Escape text before showing it on a web page
function h($text)
{
    // Arrays and objects are not shown directly
    if (is_array($text) || is_object($text)) {
        return '';
    }

    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}