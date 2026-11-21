<?php
// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'itportal');
define('DB_USER', 'root');
define('DB_PASS', '');

// Make a database connection
function db()
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

// Short function for escaping text in HTML
function h($text)
{
    if (is_array($text) || is_object($text)) {
        return '';
    }

    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}