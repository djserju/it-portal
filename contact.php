<?php
// Contact form page for sending a message to the HOD
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Message.php';

$name = '';
$email = '';
$subject = '';
$messageText = '';
$errors = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => ''
];
$success = '';

// Check the form after the user submits it
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) && is_string($_POST['subject']) ? trim($_POST['subject']) : '';
    $messageText = isset($_POST['message']) && is_string($_POST['message']) ? trim($_POST['message']) : '';

    // Check each field separately so the user knows what to fix
    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }
    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }
    if ($subject === '') {
        $errors['subject'] = 'Subject is required.';
    }
    if ($messageText === '') {
        $errors['message'] = 'Message is required.';
    } else {
        // Messages must be 10 to 1,000 characters long
        $length = mb_strlen($messageText, 'UTF-8');
        if ($length < 10 || $length > 1000) {
            $errors['message'] = 'Message must be between 10 and 1,000 characters.';
        }
    }

    if (!array_filter($errors)) {
        // Save the message if every check passed
        $pdo = (new Database())->getConnection();
        (new Message($pdo))->create([
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

<?php if ($success !== ''): ?>
    <p class="alert alert-success"><?= h($success) ?></p>
<?php endif; ?>

<form method="post" action="contact.php">
    <!-- Keep valid and invalid values in the fields after submitting -->
    <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" name="name" value="<?= h($name) ?>" required>
        <?php if ($errors['name'] !== ''): ?><span class="field-error"><?= h($errors['name']) ?></span><?php endif; ?>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="email" name="email" value="<?= h($email) ?>" required>
        <?php if ($errors['email'] !== ''): ?><span class="field-error"><?= h($errors['email']) ?></span><?php endif; ?>
    </div>
    <div class="form-group">
        <label>Subject</label>
        <input class="form-control" type="text" name="subject" value="<?= h($subject) ?>" required>
        <?php if ($errors['subject'] !== ''): ?><span class="field-error"><?= h($errors['subject']) ?></span><?php endif; ?>
    </div>
    <div class="form-group">
        <label>Message</label>
        <textarea class="form-control" name="message" required><?= h($messageText) ?></textarea>
        <?php if ($errors['message'] !== ''): ?><span class="field-error"><?= h($errors['message']) ?></span><?php endif; ?>
    </div>
    <button class="btn" type="submit">Send Message</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>