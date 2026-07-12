<?php
// logout.php - Ends the user's session
require_once 'includes/functions.php';

// Remove all session variables and destroy the session
session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
