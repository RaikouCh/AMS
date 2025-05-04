<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "register");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define Admin Security Code
define("ADMIN_SECURITY_CODE", "123456");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST['password'] ?? "");
    $login = trim($_POST['login'] ?? "");

    if ($password === ADMIN_SECURITY_CODE && empty($login)) {
        // Admin Login: Security code only
        $_SESSION["user_role"] = "admin";
        header("Location: admin1.php");
        exit;
    } elseif (!empty($login) && !empty($password)) {
        // User Login: Requires username/email and password
        $query = "SELECT id, first_name, password, role FROM form WHERE email = '$login' OR username = '$login'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_name"] = $row["first_name"];
                $_SESSION["user_role"] = $row["role"];
                header("Location: admin1.php");
                exit;
            } else {
                echo "<script>alert('Invalid password.'); window.location='relogin.php';</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.location='relogin.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid login details. Please try again.'); window.location='relogin.php';</script>";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background: url('image/462569797_2056616284786278_3431511704346069351_n.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        width: 350px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    h2 {
        color: black;
        margin-bottom: 10px;
    }

    .input-group {
        position: relative;
        width: 100%;
    }

    .input {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2em;
        color: #555;
    }

    .button {
        width: 100%;
        padding: 12px;
        background: black;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 15px;
    }

    .button:hover {
        background: rgba(89, 90, 90, 0.7);
    }

    a {
        text-decoration: none;
        color: black;
        margin-top: 15px;
        display: inline-block;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>
<body>

<div class="login-box">
    <h2>Login</h2>
    <p id="error" class="error"></p>
    <form method="post" id="loginForm">
        <!-- Username/Email Field (Optional for Admin) -->
        <input type="text" name="login" id="login" class="input" placeholder="Email or Username">

        <div class="input-group">
            <input type="password" name="password" id="password" class="input" placeholder="Password" required>
            <span id="togglePassword" class="eye-icon" aria-label="Toggle password visibility">👁️</span>
        </div>

        <button type="submit" class="button">Log In</button>
    </form>
    <p><a href="registered.php">Create New Account</a></p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("loginForm");
        const loginInput = document.getElementById("login");
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        form.addEventListener("submit", function (event) {
            const login = loginInput.value.trim();
            const password = passwordInput.value.trim();

            if (password === "123456" && !login) {
                // Admin login: Security code only, no need for username
                return; // Allow form submission, PHP handles redirection
            }

            if (!login || !password) {
                // User login requires both fields, prevent submission if missing
                event.preventDefault();
                alert("Please enter email/username and password.");
            }
        });

        togglePassword.addEventListener("click", function () {
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            togglePassword.textContent = passwordInput.type === "password" ? "👁️" : "👁️‍🗨️";
        });
    });
</script>

</body>
</html>
