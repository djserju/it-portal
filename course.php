<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/database.php';
require_once __DIR__ . '/classes/course.php';

$course = null;
$courseError = '';
$rawId = $_GET['id'] ?? null;
$courseId = is_string($rawId)
    ? filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])
    : false;

if ($courseId === false) {
    $courseError = 'Please choose a course from the course list.';
} else {
    $course = (new Course((new Database())->getConnection()))->find((int) $courseId);
    if ($course === null) {
        $courseError = 'That course could not be found. Please choose another course.';
    }
}

$pageTitle = $course !== null
    ? $course['code'] . ' - ' . $course['name']
    : 'Course Details - IT Department Portal';
require_once __DIR__ . '/includes/header.php';
?>

<section class="card">
    <?php if ($courseError !== ''): ?>
        <h2>Course unavailable</h2>
        <p class="alert alert-error"><?= e($courseError) ?></p>
    <?php else: ?>
        <h2><?= e($course['code']) ?> - <?= e($course['name']) ?></h2>
        <dl>
            <dt>Course code</dt>
            <dd><?= e($course['code']) ?></dd>
            <dt>Credits</dt>
            <dd><?= e((string) $course['credits']) ?></dd>
            <dt>Prerequisites</dt>
            <dd><?= e($course['prerequisites'] ?: 'None') ?></dd>
            <dt>Description</dt>
            <dd><?= e($course['description'] ?? '') ?></dd>
        </dl>
    <?php endif; ?>
    <p><a class="btn" href="courses.php">Back to Courses</a></p>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
