<?php
require_once __DIR__ . '/config.php';

$pdo = db();
$stmt = $pdo->query('SELECT * FROM staff ORDER BY id ASC');
$staff = $stmt->fetchAll();

$pageTitle = 'Department Staff';
require_once __DIR__ . '/includes/header.php';
?>

<h1>Department Staff</h1>

<?php if (count($staff) === 0): ?>
    <p>No staff available.</p>
<?php else: ?>
    <div class="staff-grid">
        <?php foreach ($staff as $person): ?>
            <?php
            $photo = $person['photo'] ? basename($person['photo']) : '';
            $photoExists = $photo !== '' && file_exists(__DIR__ . '/uploads/' . $photo);
            ?>
            <div class="staff-card">
                <?php if ($photoExists): ?>
                    <img class="staff-photo" src="uploads/<?= h($photo) ?>" alt="<?= h($person['name']) ?>">
                <?php else: ?>
                    <div class="staff-photo-placeholder">No Photo</div>
                <?php endif; ?>
                <h2><?= h($person['name']) ?></h2>
                <p><?= h($person['position']) ?></p>
                <p>Phone: <?= h($person['phone']) ?></p>
                <p>Email: <?= h($person['email']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>