<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Message.php';

$pdo = (new Database())->getConnection();
$messages = (new Message($pdo))->all();

$pageTitle = 'Contact Messages';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card">
    <h2>Contact Messages</h2>

    <?php if (count($messages) === 0): ?>
        <p>No messages.</p>
    <?php else: ?>
        <?php foreach ($messages as $message): ?>
            <div class="card">
                <h3><?= h($message['subject']) ?></h3>
                <p>From: <?= h($message['name']) ?> (<?= h($message['email']) ?>)</p>
                <p><?= h($message['created_at']) ?></p>
                <p><?= nl2br(h($message['message'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
