<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

setcookie(session_name(), '', time() - 3600, '/');

header("Location: index.php");
exit();
