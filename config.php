<?php
// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'itportal');
define('DB_USER', 'root');
define('DB_PASS', '');

// Short function for escaping text in HTML
function h($text)
{
    if (is_array($text) || is_object($text)) {
        return '';
    }

    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}