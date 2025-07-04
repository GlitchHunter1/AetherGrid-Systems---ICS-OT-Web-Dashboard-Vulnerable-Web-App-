<?php
session_start();

$host = 'ip';
$user = 'username';
$pass = 'password';
$db = 'aethergrid';

$conn = new mysqli($host, $user, $pass, $db);

// Log connection issues
if ($conn->connect_error) {
    $ip = $_SERVER['REMOTE_ADDR'];
    file_put_contents("access.log", "Login Failed [".date("Y-m-d H:i:s")."] IP: $ip | Username: $user | Password: $pass\n", FILE_APPEND);
    die("Connection failed.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Vulnerable to SQL Injection
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = MD5('$pass')";
    $res = $conn->query($sql);

    // Log login attempt
    $ip = $_SERVER['REMOTE_ADDR'];
    file_put_contents("access.log", "Login attemp [".date("Y-m-d H:i:s")."] IP: $ip | Username: $user | Password: $pass\n", FILE_APPEND);

    if ($res->num_rows > 0) {
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit();
    } else {
        // if login fails
	header("Location: index.php?error=1");
	exit();
    }
}
?>
