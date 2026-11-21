<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
# Loads database configuration constants
require_once __DIR__ .  '/config.php';
require_once __DIR__ . '/classes/database.php';

try {
    $pdo = (new Database())->getConnection();
    
    # Fetches all courses ordered by course code
    $stmt = $pdo->query('SELECT id, code, name, credits, prerequisites, description FROM courses ORDER BY code ASC');
    $courses = $stmt->fetchAll();
} catch (PDOException $e) {
    # Stops execution and displays a message if the query or connection fails
    exit('DB Error: ' . $e->getMessage());
}
?>
<?php
$pageTitle = 'IT Courses - Department Portal';
if (file_exists(__DIR__ . '/includes/header.php')) require __DIR__ . '/includes/header.php';
?>
    
<h1>IT Courses</h1>
        
<?php if (empty($courses)): ?>
    <p>No courses available.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Prerequisites</th>
                <th>Description</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['code']) ?></td>
                    <td><a href="course.php?id=<?= (int) $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></a></td>
                    <td><?= htmlspecialchars((string) $course['credits']) ?></td>
                    <td><?= htmlspecialchars($course['prerequisites'] ?: 'None') ?></td>
                    <td><?= htmlspecialchars($course['description'] ?? '') ?></td>
                    <td><a href="course.php?id=<?= (int) $course['id'] ?>">View details</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
    
<?php if (file_exists(__DIR__ . '/includes/footer.php')) require __DIR__ . '/includes/footer.php'; ?>