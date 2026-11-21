<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
# Loads database configuration constants
require_once __DIR__ .  '/config.php';

try {
    # Initializes PDO connection to MySql using UTF-8 encoding
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            # Throws PDOException on databse errors
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            # Returns query results as associative arrays keyed by cloumn name
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    
    # Fetches all courses ordered by course code
    $stmt = $pdo->query('SELECT code, name, credits, prerequisites, description FROM courses ORDER BY code ASC');
    $courses = $stmt->fetchAll();
} catch (PDOException $e) {
    # Stops execution and displays a message if the query or connection fails
    exit('DB Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Courses - Department Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if (file_exists(__DIR__ . '/includes/header.php')) require __DIR__ . '/includes/header.php'; ?>
    
    <main>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['code']) ?></td>
                            <td><?= htmlspecialchars($course['name']) ?></td>
                            <td><?= htmlspecialchars((string) $course['credits']) ?></td>
                            <td><?= htmlspecialchars($course['prerequisites'] ?: 'None') ?></td>
                            <td><?= htmlspecialchars($course['description'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
    <?php endif; ?>
    </main>
    
    <?php if (file_exists(__DIR__ . '/includes/footer.php')) require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>