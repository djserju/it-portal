<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Course.php';

$id = isset($_GET['id']) && is_string($_GET['id']) && is_numeric($_GET['id'])
    ? (int) $_GET['id']
    : 0;
$pdo = (new Database())->getConnection();
$course = $id > 0 ? (new Course($pdo))->find($id) : null;

$pageTitle = 'Course Details';
require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <?php if (!isset($_GET['id']) || $_GET['id'] === ''): ?>
        <h2>Please choose a course</h2>
        <p>A course id is missing. Please select a course from the course list.</p>
    <?php elseif (!$course): ?>
        <h2>Course not found</h2>
        <p>That course does not exist. Please select another course from the list.</p>
    <?php else: ?>
        <h2><?= h($course['code']) ?> - <?= h($course['name']) ?></h2>
        <p><strong>Credits:</strong> <?= h($course['credits']) ?></p>
        <p><strong>Prerequisites:</strong> <?= h($course['prerequisites'] ? $course['prerequisites'] : 'None') ?></p>
        <p><strong>Description:</strong> <?= h($course['description']) ?></p>
    <?php endif; ?>
    <p><a class="btn" href="courses.php">Back</a></p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
