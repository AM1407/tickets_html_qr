<?php
session_start();

// 1. Clear and destroy the session
session_unset();
session_destroy();

// 2. Start a temporary session for the "Logged Out" notification
session_start();
$_SESSION['toast_msg'] = "You have been logged out successfully!";
$_SESSION['toast_type'] = "info";


header("Location: index.php");
exit();
?>