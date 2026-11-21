<?php
# Resumes or initializes the current session to clear it
session_start();

# Wipes all session variables stored in memory
session_unset();
$_SESSION = [];

# Checks if the application uses cookies 
if (ini_get('session.use_cookies')) {
    # Retrieves the active session cookie parameters
    $cookieParameters = session_get_cookie_params();
    
    # Overwrites the session cookie with an empty value and a past expiration timestamp
    setcookie(
        session_name(),
        '',
        time() - 3600,
        $cookieParameters['path'],
        $cookieParameters['domain'],
        $cookieParameters['secure'],
        $cookieParameters['httponly']
    );
}

# Destroys the server side session data
session_destroy();

# Redirects the user to the login page and stops script execution
header('Location: login.php');
exit;

?>

