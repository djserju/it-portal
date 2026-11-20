<?php

require_once 'includes/auth_check.php';

$adminName = htmlspecialchars(
    $_SESSION['user_name'],
    ENT_QUOTES,
    'UTF-8'
);

$adminEmail = htmlspecialchars(
    $_SESSION['user_email'],
    ENT_QUOTES,
    'UTF-8'
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | IT Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="dashboard-wrapper">

        <header class="dashboard-header">
            <div>
                <p class="brand-label">INFORMATION TECHNOLOGY DEPARTMENT</p>
                <h1>Administration Portal</h1>
            </div>

            <a href="logout.php" class="logout-button">Sign Out</a>
        </header>

        <section class="welcome-panel">

            <p class="welcome-label">ADMINISTRATOR ACCESS</p>

            <h2>Welcome, <?= $adminName ?>.</h2>

            <p>
                Your sign-in was successful. You now have access
                to the departmental administration area.
            </p>

        </section>

        <section class="account-panel">

            <h3>Account Information</h3>

            <div class="account-detail">
                <span>Administrator</span>
                <strong><?= $adminName ?></strong>
            </div>

            <div class="account-detail">
                <span>Email Address</span>
                <strong><?= $adminEmail ?></strong>
            </div>

            <div class="account-detail">
                <span>Access Status</span>
                <strong class="status-active">Authenticated</strong>
            </div>

        </section>

        <footer class="dashboard-footer">
            IT Portal | Secure Administrative Access
        </footer>

    </main>

</body>
</html>

