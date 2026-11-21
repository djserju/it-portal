<?php
require_once __DIR__ . '/config.php';

$pdo = db();
$stmt = $pdo->query('SELECT * FROM courses ORDER BY code ASC');
$courses = $stmt->fetchAll();

$pageTitle = 'IT Courses';
require_once __DIR__ . '/includes/header.php';
?>

<h1>IT Courses</h1>

<?php if (count($courses) === 0): ?>
    <p>No courses available.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Credits</th>
            <th>Prerequisites</th>
            <th>Description</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= h($course['code']) ?></td>
                <td><a href="course.php?id=<?= (int) $course['id'] ?>"><?= h($course['name']) ?></a></td>
                <td><?= h($course['credits']) ?></td>
                <td><?= h($course['prerequisites'] ? $course['prerequisites'] : 'None') ?></td>
                <td><?= h($course['description']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>