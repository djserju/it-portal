<?php
# Database connection constants for the portal
define('DB_HOST', 'localhost');
define('DB_NAME', 'itportal');
define('DB_USER', 'root');
define('DB_PASS', '');

# Creates and configures the shared PDO database connection
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS
    );
    
    # Throws exceptions on database errors and returns associative arrays by default
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    # Stops execution with a message if connection fails
    exit('Database connection could not be established.');
}