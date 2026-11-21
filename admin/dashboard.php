<?php
# Enforces staff authentication before loading content
require_once __DIR__ . '/../includes/auth_check.php';

# Includes database configuration and PDO connection
require_once __DIR__ . '/../config.php';

# Loads summary counts for departmental records
$counts = [
    'courses' => 0,
    'staff' => 0,
    'inquiries' => 0,
    'users' => 0,
];

try {
    # Queries total records across core tables
    $counts['courses'] = (int) $pdo->query("SELECT COUNT(*) FROM courses")-> fetchColumn();
    $counts['staff'] = (int) $pdo->query("SELECT COUNT(*) FROM staff")-> fetchColumn();
    $counts['inquiries'] = (int) $pdo->query("SELECT COUNT(*) FROM inquiries")-> fetchColumn();
    $counts['users'] = (int) $pdo->query("SELECT COUNT(*) FROM users")-> fetchColumn();
} catch (PDOException $e) {
    # Keeps default zero counts if a table is not yet initialized
}

# Retrieves logged in staff details from session
$staffName = $_SESSION['user_name'] ?? 'Staff Member';
$staffEmail = $_SESSION['user_email'] ?? '';

# Sets page title and renders shared layout header
$pageTitle = 'Admin Dashboard - IT Department Portal';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Dashboard welcome card -->
<div class="card">
    <p class="tagline">DEPARTMENT OF INFORMATION TECHNOLOGY</p>
    <h2>Admin Dashboard</h2>
    <p>
        Welcome back, <strong><?= e($staffName) ?></strong>
        <?php if ($staffEmail !== ''): ?>
            (<?= e($staffEmail) ?>)
        <?php endif; ?>.
    </p>
</div>

<!-- Summary metrics grid -->
<div class="card">
    <h3>Portal Overview</h3>
    <ul>
        <li>Courses Listed: <strong><?= e((string) $counts['courses']) ?></strong></li>
        <li>Staff Profiles: <strong><?= e((string) $counts['staff']) ?></strong></li>
        <li>Contact Inquiries: <strong><?= e((string) $counts['inquiries']) ?></strong></li>
        <li>Staff Accounts: <strong><?= e((string) $counts['users']) ?></strong></li>
    </ul>
</div>

<!-- Quick navigation actions -->
<div class="card">
    <h3>Quick Actions</h3>
    <p>
        <a href="../index.php" class="btn">View Public Portal</a>
        <a href="../logout.php" class="btn">Sign Out</a>
    </p>
</div>

<?php
# Renders shared layout footer
require_once __DIR__ . '/../includes/footer.php';
?>