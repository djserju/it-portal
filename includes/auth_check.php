<?php
# Starts or resumes the PHP session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Redirects unauthorized users to the root login page
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}