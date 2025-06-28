<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AetherGrid Systems | Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #0f0f0f url('https://www.transparenttextures.com/patterns/cubes.png') repeat;
            color: #fff;
        }

        .login-container {
            width: 400px;
            margin: 100px auto;
            background: #1c1c1c;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,255,255,0.1);
            border: 1px solid #00ffe5;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00ffe5;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            background: #292929;
            color: #fff;
            border-left: 4px solid #00ffe5;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            background: #00ffe5;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #aaa;
        }

        .error-message {
            background: rgba(255, 0, 0, 0.1);
            color: #ff6666;
            padding: 10px;
            border-left: 4px solid #ff4444;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>AetherGrid Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">Invalid username or password. Please try again.</div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'signup_success'): ?>
            <div class="error-message" style="border-left-color: #00ff88; color: #00ff88;">
                Account created successfully. Please log in.
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Access Grid">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </form>
        <div class="footer">Authorized Personnel Only – All Activity is Logged</div>
    </div>
</body>
</html>
