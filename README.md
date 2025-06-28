# AetherGrid Systems - ICS/OT Web Dashboard (Vulnerable Web App)

## Description

This project is a fictional yet realistic ICS/OT web application built for a capstone cybersecurity project. Developed under the simulated company *AetherGrid Systems*, it emulates a critical infrastructure operator managing smart grid and power distribution systems across the Middle East and Africa.

This vulnerable PHP-MySQL web dashboard simulates a typical OT corporate interface, featuring login, signup, buy/sell actions, and event logging. It is hosted on a Linux VM (Apache) with the database on a separate Windows VM (MySQL), following secure segmented networking practices aligned with the Purdue Model.

---

## 🏗 Project Structure

```
/var/www/html/
├── index.php           # Login page (also serves as entry point)
├── signup.php          # Registration page
├── login.php           # Handles login requests
├── dashboard.php       # Simulated user dashboard for actions
├── logout.php          # Terminates session
├── config.php          # DB connection config
├── actions.log
├── error.log
├── access.log          # Application log file
└── css/                # Optional styling folder
```

---

## 💾 Database Setup (Windows VM)

**MySQL Config:**

```sql
CREATE DATABASE aethergrid;
USE aethergrid;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    action_type VARCHAR(50),
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add test user
INSERT INTO users (username, password) VALUES ('admin', MD5('admin123'));
```

### 🔥 Security Note:

This app is intentionally vulnerable to SQL Injection for educational red/blue team testing.

---

## 🌐 Apache Config (Ubuntu Linux VM)

Ensure Apache is installed and PHP enabled:

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php
```

Set up logging directory:

```bash
sudo mkdir /var/www/html/logs
sudo touch /var/www/html/logs/access.log
sudo chown www-data:www-data /var/www/html/logs/access.log
sudo chmod 664 /var/www/html/logs/access.log
```

Enable logging in `php.ini` if needed:

```ini
error_log = /var/log/apache2/php_errors.log
```

Restart Apache:

```bash
sudo systemctl restart apache2
```

---

## 🔐 VM, OS, and App Logs

| Source     | Log Type                 | Location                          |
| ---------- | ------------------------ | --------------------------------- |
| App (PHP)  | Access & Action Logs     | `/var/www/html/access.log`        |
| Apache     | Web requests             | `/var/log/apache2/access.log`     |
| MySQL      | DB errors/queries        | `C:\ProgramData\MySQL\...`        |
| Linux OS   | Auth/SSH/system logs     | `/var/log/auth.log`, `journalctl` |
| Windows VM | System & Security Events | Windows Event Viewer              |

---

## ⚡ Project Highlights

- Fully functioning login/signup system with password hashing (MD5 - intentionally weak)
- Connected to MySQL DB hosted on another VM
- Action form (Buy/Sell) that triggers DB and log events
- Simple logging framework for monitoring app-level activities
- Built for ICS/OT infrastructure security simulation

---

## 📷 Screenshot Preview

*(Optional - attach this in GitHub README)*&#x20;

---

## 📁 To-Do / Extensions

-

---

## 👨‍💻 Author

**Mohammed Al-Sadi**\
Cybersecurity Student – Sultan Qaboos University\
Email: [malsaadi2003@icloud.com](mailto\:malsaadi2003@icloud.com)

---

## ⚠️ Disclaimer

This application is for **educational purposes only**. It contains intentional security flaws and is not to be used in production environments.

