<?php
require_once __DIR__ . '/config.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;
$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = :id');
$stmt->execute(['id' => $id]);
$course = $stmt->fetch();

$pageTitle = 'Course Details';
require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <?php if (!$course): ?>
        <h2>Course not found</h2>
    <?php else: ?>
        <h2><?= h($course['code']) ?> - <?= h($course['name']) ?></h2>
        <p><strong>Credits:</strong> <?= h($course['credits']) ?></p>
        <p><strong>Prerequisites:</strong> <?= h($course['prerequisites'] ? $course['prerequisites'] : 'None') ?></p>
        <p><strong>Description:</strong> <?= h($course['description']) ?></p>
    <?php endif; ?>
    <p><a class="btn" href="courses.php">Back</a></p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
