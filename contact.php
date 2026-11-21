<?php
require_once __DIR__ . '/config.php';

$name = '';
$email = '';
$subject = '';
$messageText = '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) && is_string($_POST['subject']) ? trim($_POST['subject']) : '';
    $messageText = isset($_POST['message']) && is_string($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '' || $email === '' || $subject === '' || $messageText === '') {
        $error = 'Please fill in every field.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $pdo = db();
        $sql = 'INSERT INTO messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $messageText
        ]);

        $success = 'Your message was sent.';
        $name = '';
        $email = '';
        $subject = '';
        $messageText = '';
    }
}

$pageTitle = 'Contact the HOD';
require_once __DIR__ . '/includes/header.php';
?>

<h1>Contact the HOD</h1>

<?php if ($error !== ''): ?>
    <p class="alert alert-error"><?= h($error) ?></p>
<?php endif; ?>
<?php if ($success !== ''): ?>
    <p class="alert alert-success"><?= h($success) ?></p>
<?php endif; ?>

<form method="post" action="contact.php">
    <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" name="name" value="<?= h($name) ?>" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="email" name="email" value="<?= h($email) ?>" required>
    </div>
    <div class="form-group">
        <label>Subject</label>
        <input class="form-control" type="text" name="subject" value="<?= h($subject) ?>" required>
    </div>
    <div class="form-group">
        <label>Message</label>
        <textarea class="form-control" name="message" required><?= h($messageText) ?></textarea>
    </div>
    <button class="btn" type="submit">Send Message</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>