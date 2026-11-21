<?php
// Staff login page
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/User.php';

if (session_status() === PHP_SESSION_NONE) {
    // Start the session if it is not already active
    session_start();
}

if (isset($_SESSION['user_id'])) {
    // Already logged-in users go straight to the dashboard
    header('Location: admin/dashboard.php');
    exit;
}

$error = '';
$email = '';
$remember = false;

// Check the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember_email']);

    // Save or remove the email cookie
    if ($remember && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('remember_email', $email, [
            'expires' => time() + 30 * 24 * 60 * 60,
            'path' => '/it-portal/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        setcookie('remember_email', '', [
            'expires' => time() - 3600,
            'path' => '/it-portal/'
        ]);
    }

    // Do not say whether the email or password was wrong
    if ($email === '' || $password === '') {
        $error = 'The email or password entered is incorrect.';
    } else {
        $pdo = (new Database())->getConnection();
        // Find the user with the submitted email
        $user = (new User($pdo))->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            header('Location: admin/dashboard.php');
            exit;
        } else {
            $error = 'The email or password entered is incorrect.';
        }
    }
} else {
    if (isset($_COOKIE['remember_email']) && is_string($_COOKIE['remember_email'])) {
        $email = $_COOKIE['remember_email'];
        $remember = true;
    }
}

$pageTitle = 'Staff Login';
require_once __DIR__ . '/includes/header.php';
?>

<div class="card" style="max-width:460px;margin:0 auto;">
    <h2>Staff Login</h2>

    <?php if ($error !== ''): ?>
        <p class="alert alert-error"><?= h($error) ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <!-- Login fields -->
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email" value="<?= h($email) ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember_email" value="1" <?= $remember ? 'checked' : '' ?>>
                Remember my email
            </label>
        </div>
        <button class="btn" type="submit">Login</button>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>