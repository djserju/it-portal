<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';

$pdo = db();
$courseCount = $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
$staffCount = $pdo->query('SELECT COUNT(*) FROM staff')->fetchColumn();
$messageCount = $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();

$pageTitle = 'Admin Dashboard';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <strong><?= h($_SESSION['user_name']) ?></strong>.</p>
</div>

<div class="card">
    <h3>Portal Summary</h3>
    <ul>
        <li>Courses: <?= h($courseCount) ?></li>
        <li>Staff: <?= h($staffCount) ?></li>
        <li>Messages: <?= h($messageCount) ?></li>
    </ul>
</div>

<div class="card">
    <a class="btn" href="courses.php">Manage Courses</a>
    <a class="btn" href="staff.php">Manage Staff</a>
    <a class="btn" href="messages.php">View Messages</a>
    <a class="btn" href="../logout.php">Logout</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>