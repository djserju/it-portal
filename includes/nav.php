<?php
# Determines the filename of the crrently active page
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- Shared primary navigation bar -->
<nav class="site-nav" aria-label="Main Navigation">
    <div class="container nav-inner">
        <ul class="nav-list">
            <!-- Public portal links -->
            <li>
                <a href="<?= e($basePath) ?>index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                    Home
                </a>
            </li>
            <li>
                <a href="<?= e($basePath) ?>courses.php" class="<?= $currentPage === 'courses.php' ? 'active' : '' ?>">
                    Courses
                </a>
            </li>
            <li>
                <a href="<?= e($basePath) ?>staff.php" class="<?= $currentPage === 'staff.php' ? 'active' : '' ?>">
                    Staff Directory
                </a>
            </li>
            <li>
                <a href="<?= e($basePath) ?>contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">
                    Contact HOD
                </a>
            </li>
        
        <!-- Shows dashboard & logout if logged in --> 
        <?php if (!empty($_SESSION['user_id'])): ?>
            <li class ="nav-right">
                <a href="<?= e($basePath) ?>admin/dashboard.php" class="<?= str_starts_with($_SERVER['PHP_SELF'], '/it-portal/admin/') || $basePath === '../' ? 'active' : '' ?>">
                    Admin Dashboard
                </a>
            </li>
            <li>
                <a href="<?= e($basePath) ?>logout.php" class="nav-logout">
                    Logout (<?= e($_SESSION['user_name'] ?? 'Admin') ?>)
                </a>
                </li>
            <?php else: ?>
                <li class="nav-right">
                    <a href="<?= e($basePath) ?>login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">
                        Staff Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>    
    </div>
</nav>