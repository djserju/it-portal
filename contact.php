<?php
# Loads databse configuration constants
require_once __DIR__ . '/config.php';

# Initializes feedback messages and form input variables
$error = '';
$success = '';
$name = '';
$email = '';
$subject = '';
$message = '';

# Handles form submission via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Trims leading/trailing whitespace
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    # Validates required fields and email format
    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email,  FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            # Connects to database and inserts inquiry using a prepared statement
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    # Throws PDOException on database errors 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    # Returns query results as associative arrays 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            
            # Inserts inquiry using bound parameters to prevent SQL injection
            $stmt = $pdo->prepare(
                'INSERT INTO inquiries (name, email, subject, message) VALUES (:name, :email, :subject, :message)'
            );
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message,
            ]);
            
            # Resets form fields on success
            $success = 'Inquiry sent.';
            $name = $email = $subject = $message = '';
        } catch (PDOException $e) {
            # Displays a error message if database insert fails
            $error = 'Could not send inquiry.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact the HOD - IT Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if (file_exists(__DIR__ . '/includes/header.php')) require __DIR__ . '/includes/header.php'; ?>
    
    <main>
        <h1>Contact the HOD</h1>
        
        <?php if ($success !== ''): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
    
        <?php if ($error !== ''): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    
        <form method="post" action="contact.php">
            <label>Name <input type="text" name="name" required value="<?= htmlspecialchars($name) ?>"></label>
            <label>Email <input type="email" name="email" required value="<?= htmlspecialchars($email) ?>"></label>
            <label>Subject <input type="text" name="subject" required value="<?= htmlspecialchars($subject) ?>"></label>
            <label>Message <textarea name="message" rows="5" required><?= htmlspecialchars($message) ?></textarea></label>
            <button type="submit">Send</button>
        </form>
    </main>
    
    <?php if (file_exists(__DIR__ . '/includes/footer.php')) require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>