<?php
# Starts or resumes the PHP session
session_start();

# Includes database configuration and PDO connection
require_once __DIR__ . '/config.php';

# Redirects authenticated users directly to the admin dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: admin/dashboard.php');
    exit;
}

# Initializes form state variables
$errorMessage = '';
$email = '';
$rememberEmail = false;

# Processes form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberEmail = isset($_POST['remember_email']);
    
    # Saves or clears the remembered email cookie for 30 days
    if ($rememberEmail && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('remember_email', $email, [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => '/it-portal/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        // Remove the saved email.
        setcookie('remember_email', '', [
            'expires' => time() - 3600,
            'path' => '/it-portal/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
    # Validates inputs and verifies user credentials against the database
    if ($email === '' || $password === '') {
        $errorMessage = 'Please enter your email and password.';
    } else {
        $sql = "SELECT id, name, email, password_hash
                FROM users
                WHERE email = :email
                LIMIT 1";

        $statement = $pdo->prepare($sql);
        $statement->execute([':email' => $email]);
        $user = $statement->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            # Regenerates session id to prevent session fixation
            session_regenerate_id(true);
            
            # Stores authenticated user details in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            header('Location: admin/dashboard.php');
            exit;
        } else {
            $errorMessage = 'The email or password entered is incorrect.';
        }
    }
} else {
    // Load previously saved email if available
    $email = $_COOKIE['remember_email'] ?? '';
    $rememberEmail = ($email !== '');
}

# Sets the page title and loads the shared header template
$pageTitle = 'Staff Login - IT Department Portal';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Staff login card container -->
<div class="card" style="max-width: 460px; margin: 0 auto;">
    <p class="tagline">DEPARTMENT OF INFORMATION TECHNOLOGY</p>
    <h2>Staff Access</h2>
    <p>Sign in to access departmental administration.</p>

    <!-- Error alert -->
    <?php if ($errorMessage !== ''): ?>
        <div class="alert alert-error"><?= e($errorMessage) ?></div>
    <?php endif; ?>
    
    <!-- Login Form -->
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your staff email" autocomplete="username" value="<?= e($email) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password" required>
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember_email" value="1" <?= $rememberEmail ? 'checked' : '' ?>>
                Remember my email
            </label>
        </div>
        
        <button type="submit" class="btn">Sign In</button>
    </form>
    
    <p class="tagline">Authorized departmental personnel only.</p>
</div>

<?php
# Includes the shared footer template
require_once __DIR__ . '/includes/footer.php';
?>