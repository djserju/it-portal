<?php
# Loads database configuration and message persistence helpers
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/database.php';
require_once __DIR__ . '/classes/message.php';

# Initializes per-field validation feedback and form input values
$errors = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => '',
];
$saveError = '';
$success = '';
$name = '';
$email = '';
$subject = '';
$message = '';

# Handles form submission via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = is_string($_POST['name'] ?? null) ? $_POST['name'] : '';
    $email = is_string($_POST['email'] ?? null) ? $_POST['email'] : '';
    $subject = is_string($_POST['subject'] ?? null) ? $_POST['subject'] : '';
    $message = is_string($_POST['message'] ?? null) ? $_POST['message'] : '';
    
    if (trim($name) === '') {
        $errors['name'] = 'Name is required.';
    }

    if (trim($email) === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if (trim($subject) === '') {
        $errors['subject'] = 'Subject is required.';
    }

    if (trim($message) === '') {
        $errors['message'] = 'Message is required.';
    } else {
        $messageLength = mb_strlen(trim($message), 'UTF-8');
        if ($messageLength < 10 || $messageLength > 1000) {
            $errors['message'] = 'Message must be between 10 and 1,000 characters.';
        }
    }

    if (!array_filter($errors)) {
        try {
            $pdo = (new Database())->getConnection();
            $stored = (new Message($pdo))->create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ]);

            if ($stored) {
                $success = 'Your message has been sent to the Head of Department.';
                $name = $email = $subject = $message = '';
            } else {
                $saveError = 'Your message could not be saved. Please try again.';
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $saveError = 'Your message could not be saved. Please try again later.';
        }
    }
}
?>
<?php
$pageTitle = 'Contact the HOD - IT Portal';
if (file_exists(__DIR__ . '/includes/header.php')) require __DIR__ . '/includes/header.php';
?>
    
<h1>Contact the HOD</h1>
        
<?php if ($success !== ''): ?>
    <p class="alert alert-success"><?= e($success) ?></p>
<?php endif; ?>
    
<?php if ($saveError !== ''): ?>
    <p class="alert alert-error"><?= e($saveError) ?></p>
<?php endif; ?>
    
<form method="post" action="contact.php">
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control<?= $errors['name'] !== '' ? ' is-invalid' : '' ?>" type="text" id="name" name="name" required value="<?= e($name) ?>" aria-invalid="<?= $errors['name'] !== '' ? 'true' : 'false' ?>" aria-describedby="name-error">
        <span class="field-error" id="name-error"><?= e($errors['name']) ?></span>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control<?= $errors['email'] !== '' ? ' is-invalid' : '' ?>" type="email" id="email" name="email" required value="<?= e($email) ?>" aria-invalid="<?= $errors['email'] !== '' ? 'true' : 'false' ?>" aria-describedby="email-error">
        <span class="field-error" id="email-error"><?= e($errors['email']) ?></span>
    </div>
    <div class="form-group">
        <label for="subject">Subject</label>
        <input class="form-control<?= $errors['subject'] !== '' ? ' is-invalid' : '' ?>" type="text" id="subject" name="subject" required value="<?= e($subject) ?>" aria-invalid="<?= $errors['subject'] !== '' ? 'true' : 'false' ?>" aria-describedby="subject-error">
        <span class="field-error" id="subject-error"><?= e($errors['subject']) ?></span>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control<?= $errors['message'] !== '' ? ' is-invalid' : '' ?>" id="message" name="message" rows="5" required aria-invalid="<?= $errors['message'] !== '' ? 'true' : 'false' ?>" aria-describedby="message-error"><?= e($message) ?></textarea>
        <span class="field-error" id="message-error"><?= e($errors['message']) ?></span>
    </div>
    <button type="submit" class="btn">Send Message</button>
</form>
    
<?php if (file_exists(__DIR__ . '/includes/footer.php')) require __DIR__ . '/includes/footer.php'; ?>