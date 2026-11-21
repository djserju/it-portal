<?php
// Public page that lists department staff
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Staff.php';

// Load staff for the public staff page
$pdo = (new Database())->getConnection();
$staff = (new Staff($pdo))->all();

// Set the staff directory title
$pageTitle = 'Department Staff';
require_once __DIR__ . '/includes/header.php';
?>

<h1>Department Staff</h1>

<!-- Show each staff member in a card -->
<?php if (count($staff) === 0): ?>
    <p>No staff available.</p>
<?php else: ?>
    <!-- Each staff member gets a photo and details card -->
    <div class="staff-grid">
        <?php foreach ($staff as $person): ?>
            <!-- Staff directory card -->
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
                <p>Phone: <a href="tel:<?= h(preg_replace('/[^0-9+]/', '', (string) $person['phone'])) ?>"><?= h($person['phone']) ?></a></p>
                <p>Email: <a href="mailto:<?= h($person['email']) ?>"><?= h($person['email']) ?></a></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Shared footer -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>