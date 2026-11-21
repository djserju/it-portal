<?php
// Public page that lists all courses
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Course.php';

// Get courses from the database
$pdo = (new Database())->getConnection();
$courses = (new Course($pdo))->all();

// Set the title and load the shared page layout
$pageTitle = 'IT Courses';
require_once __DIR__ . '/includes/header.php';
?>

<h1>IT Courses</h1>

<!-- Show the course table -->
<?php if (count($courses) === 0): ?>
    <p>No courses available.</p>
<?php else: ?>
    <!-- Display all courses in a table -->
    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Credits</th>
            <th>Prerequisites</th>
            <th>Description</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <!-- One course row -->
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

<!-- Shared footer -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>