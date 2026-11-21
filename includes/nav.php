<?php
// This navigation is included on public and admin pages
$currentPage = basename($_SERVER['PHP_SELF']);
$basePath = isset($basePath) ? $basePath : '';
?>
<!-- Shared primary navigation bar -->
<nav class="site-nav" aria-label="Main Navigation">
    <div class="container nav-inner">
        <ul class="nav-list">
            <!-- Public portal links -->
            <li>
                <a href="<?= h($basePath) ?>index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                    Home
                </a>
            </li>
            <li>
                <a href="<?= h($basePath) ?>courses.php" class="<?= in_array($currentPage, ['courses.php', 'course.php'], true) ? 'active' : '' ?>">
                    Courses
                </a>
            </li>
            <li>
                <a href="<?= h($basePath) ?>staff.php" class="<?= $currentPage === 'staff.php' ? 'active' : '' ?>">
                    Staff Directory
                </a>
            </li>
            <li>
                <a href="<?= h($basePath) ?>admissions.php" class="<?= $currentPage === 'admissions.php' ? 'active' : '' ?>">
                    Admissions
                </a>
            </li>
            <li>
                <a href="<?= h($basePath) ?>contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">
                    Contact HOD
                </a>
            </li>
        
        <!-- Shows dashboard & logout if logged in --> 
        <?php if (!empty($_SESSION['user_id'])): ?>
            <li class ="nav-right">
                <a href="<?= h($basePath) ?>admin/dashboard.php" class="<?= $basePath === '../' ? 'active' : '' ?>">
                    Admin Dashboard
                </a>
            </li>
            <li>
                <a href="<?= h($basePath) ?>logout.php" class="nav-logout">
                    Logout (<?= h($_SESSION['user_name'] ?? 'Admin') ?>)
                </a>
                </li>
            <?php else: ?>
                <li class="nav-right">
                    <a href="<?= h($basePath) ?>login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">
                        Staff Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>    
    </div>
</nav>