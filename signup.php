<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB Config
$host = "ip";
$user = "username";
$pass = "password";
$db = "aethergrid";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        $hash = md5($password); // Weak on purpose (vuln)
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";
        if (mysqli_query($conn, $sql)) {
	    $ip = $_SERVER['REMOTE_ADDR'];
	    file_put_contents("access.log", "New user was creaeted. [".date("Y-m-d H:i:s")."] IP: $ip | Username: $username | Password: $password\n", FILE_APPEND);
            header("Location: index.php?msg=signup_success");
            exit();
        } else {
            $message = "Signup failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AetherGrid | Create Account</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin: 0;
        }
        .signup-box {
            background-color: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 380px;
        }
        .signup-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 500;
            color: #00d1ff;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.2);
            color: white;
        }
        input::placeholder {
            color: #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #00d1ff;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #00a9cc;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #00d1ff;
            text-decoration: none;
        }
        .error {
            background-color: rgba(255,0,0,0.1);
            padding: 10px;
            color: red;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="signup-box">
    <h2>Create Your AetherGrid Account</h2>
    <?php if (!empty($message)) echo "<div class='error'>$message</div>"; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
        <div class="link">
            Already have an account? <a href="index.php">Login here</a>
        </div>
    </form>
</div>
</body>
</html>
