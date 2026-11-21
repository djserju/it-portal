<?php
// Start the session for this page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use the page title supplied by the PHP page
$pageTitle = isset($pageTitle) ? $pageTitle : 'UCC IT Department Portal';
$basePath = isset($basePath) ? $basePath : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= h($basePath) ?>css/style.css">
</head>
<body>
    <!-- Top banner -->
    <header class="site-header">
        <div class="container header-inner">
            <div class="brand">
                <a href="<?= h($basePath) ?>index.php" class="brand-link">
                    <span class="brand-badge">UCC</span>
                    <div>
                        <h1>Department of Information Technology</h1>
                        <p class="tagline">University of the Commonwealth Caribbean </p>
                    </div>
                </a>
            </div>
        </div>
    </header>
    
    <!-- Load the shared navigation bar -->
    <?php require __DIR__ . '/nav.php'; ?>
    
    <!-- Main page content wrapper (closed in footer.php) -->
    <main class="container main-content">