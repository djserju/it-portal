<?php
# Start or resume the PHP session on every page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Helper function to safely escape output using htmlspecialchars()
if (!function_exists('e')) {
    function e(?string $value): string {
        return htmlspecialchars($value ?? '', ENT_QUOTES);
    }
}

# Set a default page title
$pageTitle = $pageTitle ?? 'UCC IT Department Portal';
$basePath = $basePath ?? ''; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Escape the dynamic page title for safe HTML output -->
    <title><?= e($pageTitle) ?></title>
    <!-- Link the main stylesheet using $basePath -->
    <link rel="stylesheet" href="<?= e($basePath) ?>css/style.css">
</head>
<body>
    <!-- Top Departmental Banner -->
    <header class="site-header">
        <div class="container header-inner">
            <div class="brand">
                <a href="<?= e($basePath) ?>index.php" class="brand-link">
                    <span class="brand-badge">UCC</span>
                    <div>
                        <h1>Department of Information Technology</h1>
                        <p class="tagline">University of the Commonwealth Caribbean </p>
                    </div>
                </a>
            </div>
        </div>
    </header>
    
    <!-- Include the shared navigation bar -->
    <?php require __DIR__ . '/nav.php'; ?>
    
    <!-- Main page content wrapper (closed in footer.php) -->
    <main class="container main-content">