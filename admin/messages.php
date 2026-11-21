<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/message.php';

$pdo = (new Database())->getConnection();
$messages = (new Message($pdo))->all();

$pageTitle = 'Contact Messages - Admin';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="card">
    <h2>Contact Messages</h2>
    <p>Newest submissions appear first.</p>

    <?php if (empty($messages)): ?>
        <p>No messages have been submitted.</p>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <article class="card">
                <h3><?= e($message['subject']) ?></h3>
                <p>
                    From: <strong><?= e($message['name']) ?></strong>
                    (<a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>)
                </p>
                <p><small><?= e(date('F j, Y g:i A', strtotime($message['created_at']))) ?></small></p>
                <p><?= nl2br(e($message['message'])) ?></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
