<?php
session_start();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    // Validate page to prevent open redirect vulnerabilities
    $allowed_pages = ['index.php', 'signup.php', 'login.php', 'profile.php', 'logout.php', 'post_job.php', 'browse_jobs.php', 'messaging.php', 'payment.php'];
    if (in_array($page, $allowed_pages)) {
        header("Location: $page");
        exit;
    } else {
        error_log("Invalid redirect attempt: $page", 3, 'logs/redirect_errors.log');
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
