<?php
// Main page shown after an administrator logs in
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Course.php';
require_once __DIR__ . '/../classes/Staff.php';
require_once __DIR__ . '/../classes/Message.php';

// Get totals for the summary boxes
$pdo = (new Database())->getConnection();
$courseCount = (new Course($pdo))->count();
$staffCount = (new Staff($pdo))->count();
$messageCount = (new Message($pdo))->count();

$pageTitle = 'Admin Dashboard';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Welcome section -->
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
    <!-- Links to all admin areas -->
    <a class="btn" href="courses.php">Manage Courses</a>
    <a class="btn" href="staff.php">Manage Staff</a>
    <a class="btn" href="messages.php">View Messages</a>
    <a class="btn" href="../logout.php">Logout</a>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>