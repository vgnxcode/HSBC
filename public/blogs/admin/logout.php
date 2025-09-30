<?php 
session_start();
require_once '../config.php';

if (isset($_SESSION['id'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
}

// Redirect to login page
header("Location: " . base_url . 'login');
exit();
?>
