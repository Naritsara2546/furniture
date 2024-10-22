<?php
session_start();

// Unset all session variables
unset($_SESSION['id']);
unset($_SESSION['name']);

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
echo "<script>";
echo " window.location = 'index.php'; ";
echo "</script>";
?>
