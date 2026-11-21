<?php
# Loads databse configuration constants
require_once __DIR__ . '/config.php';

try {
    # Initializes PDO connection to MySQL using UTF-8 encoding
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            # Throws PDOException on database errors
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            # Returns query results as associative arrays keyed by cloumn name
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    
    # Fetches staff profiles in ascending order
    $stmt = $pdo->query('SELECT name, position, phone, email, photo FROM staff ORDER by id ASC');
    $staffMembers = $stmt->fetchAll();
} catch (PDOException $e) {
    # Stops execution and displays a message if the query or connection fails
    exit('Unable to load staff directory.');
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Staff - IT Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if (file_exists(__DIR__ . '/includes/header.php')) require __DIR__ . '/includes/header.php'; ?>
    
    <main>
        <h1>Department Staff</h1>
        
        <?php if (empty($staffMembers)): ?>
            <p>No staff profiles available.</p>
        <?php else: ?>
            <div class="staff-grid">
                <?php foreach ($staffMembers as $member): ?>
                    <?php
                    $photoFile = $member['photo'] ? basename((string) $member['photo']) : '';
                    $hasPhoto = $photoFile !== '' && is_file(__DIR__ . '/uploads/' . $photoFile);
                    ?>
                    <article class="staff-card">
                        <?php if ($hasPhoto): ?>
                            <img src="uploads/<?= htmlspecialchars($photoFile) ?>" alt="<?= htmlspecialchars($member['name']) ?>">
                        <?php else: ?>
                            <div class="staff-photo-placeholder">No Photo</div>
                        <?php endif; ?>
                        
                        <h2><?= htmlspecialchars($member['name']) ?></h2>
                        <p class="position"><?= htmlspecialchars($member['position']) ?></p>
                        <p class="phone">Phone: <?= htmlspecialchars($member['phone']) ?></p>
                        <p class="email">Email: <a href="mailto:<?= htmlspecialchars($member['email']) ?>"><?= htmlspecialchars($member['email']) ?></a></p>
                </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </main>
                    
    <?php if (file_exists(__DIR__ . '/includes/footer.php')) require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>