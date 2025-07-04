<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$host = '20.192.30.92';
$user = 'admin';
$pass = 'admin';
$db = 'aethergrid';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    file_put_contents("error.log", "[" . date("Y-m-d H:i:s") . "] DB connection failed\n", FILE_APPEND);
    die("Connection failed.");
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['user'];
    $action_type = $_POST['action'];
    $region = $_POST['region'];
    $voltage = $_POST['voltage'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $timestamp = date("Y-m-d H:i:s");

    // Vulnerable SQL (intentionally)
    $sql = "INSERT INTO actions (username, action_type, region, voltage_level, grid_status, notes, timestamp, ip_address)
            VALUES ('$username', '$action_type', '$region', '$voltage', '$status', '$notes', '$timestamp', '$ip')";
    $conn->query($sql);

    // Log the action
    $log = "[$timestamp] $ip | $username | $action_type | Region: $region | Voltage: $voltage | Status: $status\n";
    file_put_contents("actions.log", $log, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AetherGrid Systems | Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f url('https://www.transparenttextures.com/patterns/cubes.png') repeat;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 600px;
            margin: 50px auto;
            background: #1c1c1c;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,255,255,0.15);
            border: 1px solid #00ffe5;
        }
        h2 {
            text-align: center;
            color: #00ffe5;
        }
        form input, form select, form textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #292929;
            color: #fff;
            border: none;
            border-left: 4px solid #00ffe5;
        }
        .actions {
            display: flex;
            justify-content: space-between;
        }
        .actions input[type="submit"] {
            background: #00ffe5;
            color: #000;
            font-weight: bold;
            border: none;
            width: 48%;
            padding: 12px;
            cursor: pointer;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['user']); ?>!</h2>
        <form method="POST">
            <select name="region" required>
                <option value="">Select Region</option>
                <option value="Muscat">Muscat</option>
                <option value="Buraimi">Buraimi</option>
                <option value="Salalah">Salalah</option>
                <option value="Nizwa">Nizwa</option>
            </select>

            <select name="voltage" required>
                <option value="">Voltage Level</option>
                <option value="33kV">33kV</option>
                <option value="11kV">11kV</option>
                <option value="400V">400V</option>
            </select>

            <select name="status" required>
                <option value="">Grid Status</option>
                <option value="Stable">Stable</option>
                <option value="Overload">Overload</option>
                <option value="Maintenance">Maintenance</option>
            </select>

            <textarea name="notes" placeholder="Operation Notes... (optional)"></textarea>

            <div class="actions">
                <input type="submit" name="action" value="Buy">
                <input type="submit" name="action" value="Sell">
            </div>
        </form>

        <div class="footer">All commands are logged | AetherGrid ICS/OT Dashboard</div>
	<form action="logout.php" method="POST" style="text-align: right;">
        <button type="submit" style="background-color:#ff0040; color:white; border:none; padding:10px 15px; cursor:pointer;">
        Logout
        </button>
</form>
    </div>
</body>
</html>
