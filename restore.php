<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Ensure session is active and role is set
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    session_destroy();
    header("Location: relogin.php");
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$database = "register"; // Change to your actual database name

$message = ""; // Variable to hold the message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["backup_file"]) && $_FILES["backup_file"]["error"] == 0) {
        $fileTmpPath = $_FILES["backup_file"]["tmp_name"];
        $fileName = $_FILES["backup_file"]["name"];

        if (pathinfo($fileName, PATHINFO_EXTENSION) !== "sql") {
            $message = "<p style='color: red;'>Invalid file type. Please upload a .sql file.</p>";
        } else {
            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sqlContent = file_get_contents($fileTmpPath);
            $queries = explode(";", $sqlContent);

            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    if (!$conn->query($query)) {
                        $message = "<p style='color: red;'>Error restoring database: " . $conn->error . "</p>";
                        $conn->close();
                        break;
                    }
                }
            }

            $message = "<p style='color: green;'>Database restored successfully!</p>";
            $conn->close();
        }
    } else {
        $message = "<p style='color: red;'>Please select a valid backup file.</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restore Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900');
        :root {
  --primary-clr: #7522e6;
  --bg-clr: #f2f4f5;
  --white-bg: #fff;
  --dark-text-clr: #363b46;
  --light-text-clr: #fff;
  --hover-clr: #f1e8fd;
  --transition-speed: 0.3s;
  --sidebar-width-collapsed: 80px;
  --sidebar-width-expanded: 250px;
}

body.Dark-Mode {
  --bg-clr: #1e1e1e;
  --white-bg: #23262b;
  --dark-text-clr: #fff;
  --hover-clr: #31313f;
}

body {
  display: flex;
  height: 100vh;
  background: var(--bg-clr);
  overflow: hidden;
}

/* Sidebar */
.sidebar {
  width: var(--sidebar-width-collapsed);
  height: 100vh;
  background: var(--white-bg);
  transition: width var(--transition-speed);
  display: flex;
  flex-direction: column;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  padding-top: 20px;
  overflow: hidden;
}

/* Expand on hover */
.sidebar:hover {
  width: var(--sidebar-width-expanded);
}

/* Sidebar Menu */
.sidebar ul {
  list-style: none;
  padding: 0;
}

/* Sidebar Links */
.sidebar .link-item {
  width: 100%;
  position: relative;
}

.sidebar .link-item a {
  display: flex;
  align-items: center;
  padding: 12px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 16px;
  color: var(--dark-text-clr);
  transition: background var(--transition-speed), padding-left var(--transition-speed);
  justify-content: flex-start;
  gap: 12px;
}

/* Always visible icons */
.sidebar .link-item ion-icon {
  font-size: 24px;
  color: var(--dark-text-clr);
  transition: transform 0.3s ease-in-out;
  min-width: 32px;
  text-align: center;
}

/* Icon smooth effect on hover */
.sidebar .link-item a:hover ion-icon {
  transform: scale(1.2);
}

/* Initially hide text */
.sidebar .link-item span {
  opacity: 0;
  visibility: hidden;
  transition: opacity var(--transition-speed), transform var(--transition-speed);
  transform: translateX(-10px);
  white-space: nowrap;
}

/* Show text only when sidebar expands */
.sidebar:hover .link-item span {
  opacity: 1;
  visibility: visible;
  transform: translateX(0);
}

/* Adjust padding when sidebar expands */
.sidebar:hover .link-item a {
  padding-left: 20px;
}

/* Hover effect */
.sidebar .link-item a:hover {
  background-color: var(--hover-clr);
}

/* Main Content */
.content-wrapper {
  width: calc(100% - var(--sidebar-width-collapsed));
  margin-left: var(--sidebar-width-collapsed);
  padding: 20px;
  justify-content: center;
  transition: margin-left var(--transition-speed);
}

.sidebar:hover ~ .content-wrapper {
  margin-left: var(--sidebar-width-expanded);
  width: calc(100% - var(--sidebar-width-expanded));
}

/* Dark Mode Toggle */
.sidebar .dark-mode-toggle {
  cursor: pointer;
}

h2 {
            color: #333;
            text-align: center;
        }
        form {
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    width: 50%;
    background: #f9f9f9;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

input[type="file"] {
    margin-bottom: 15px;
}

input[type="submit"] {
    background: var(--primary-clr);
    color: var(--light-text-clr);
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background var(--transition-speed);
}

input[type="submit"]:hover {
    background: #5a1bb1; /* Darker shade of primary color */
}

.message-container {
            text-align: center;
            margin-top: 20px;
        }

        .message-container p {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <ul class="link-items">
        <li class="link-item">
            <a href="settings.php">
                <ion-icon name="person-outline"></ion-icon>
                <span>Admin Account</span>
            </a>
        </li>
        <li class="link-item">
            <a href="backup.php">
                <ion-icon name="cloud-download-outline"></ion-icon> <!-- Correct Database Backup Icon -->
                <span>Database Backup</span>
            </a>
        </li>
        <li class="link-item">
            <a href="restore.php">
                <ion-icon name="cloud-upload-outline"></ion-icon> <!-- Correct Restore Database Icon -->
                <span>Restore Database</span>
            </a>
        </li>
        <li class="link-item">
            <a href="admin.php">
                <ion-icon name="log-out-outline"></ion-icon>
                <span>Return</span>
            </a>
        </li>
    </ul>
</div>
<div class="content-wrapper">
    <h2 style="text-align: center;">Restore Database</h2>
    
    <!-- Message Container -->
    <div class="message-container">
        <?php echo $message; ?>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" style="text-align: center;">
        <input type="file" name="backup_file" required>
        <br><br>
        <input type="submit" value="Restore Database">
    </form>
</div>
</body>
</html>
