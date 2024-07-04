<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page after logout
header("Location: http://localhost/CCC%20Navigation/login.php");
exit;
?>
