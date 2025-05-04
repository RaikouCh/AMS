<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "register");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $gender = trim($_POST['gender']);
    $location = trim($_POST['location']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    $password = trim($_POST['password']);

    // Default role is 'user'
    $role = 'user';

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($gender) || 
        empty($location) || empty($phone) || empty($dob) || empty($password)) {
        die("All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate phone number (only digits, max length 12)
    if (!ctype_digit($phone) || strlen($phone) > 12) {
        die("Invalid phone number. Only up to 12 digits allowed.");
    }

    // Check if user is at least 18 years old
    $birth_year = date("Y", strtotime($dob));
    $current_year = date("Y");
    if (($current_year - $birth_year) < 18) {
        die("You must be at least 18 years old to register.");
    }

    // Check if username or email already exists
    $query = "SELECT id FROM form WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        die("Username or email is already taken.");
    }

    // Hash password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO form (first_name, last_name, email, username, gender, location, phone, dob, password, role) 
            VALUES ('$first_name', '$last_name', '$email', '$username', '$gender', '$location', '$phone', '$dob', '$hashed_password', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: confirmation.php?firstname=" . urlencode($first_name) . "&lastname=" . urlencode($last_name));
        exit;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// Close connection
mysqli_close($conn);
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* General Page Styles */
body {
    background: url('image/462569797_2056616284786278_3431511704346069351_n.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

/* Form Container */
.container {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
    max-width: 600px;
    width: 100%;
}

/* Form Header */
h2 {
    color: #000;
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

/* Form Fields */
.form-group {
    position: relative;
    margin-bottom: 15px;
}

.form-control {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 16px;
    transition: border-color 0.3s ease-in-out;
}

.form-control:focus {
    border-color: #000;
    outline: none;
}

/* Password Visibility Toggle */
.eye-icon {
    cursor: pointer;
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2em;
    color: #555;
}

/* Labels */
label {
    font-weight: 500;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

/* Checkbox Container */
.checkbox-container {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    margin-top: 20px;
}

/* Submit Button */
button {
    width: 100%;
    background: #000;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: background 0.3s ease;
}

button:hover {
    background: rgba(0, 0, 0, 0.8);
}

/* Login Link */
.login-container {
    text-align: center;
    margin-top: 20px;
}

.login-btn {
    display: inline-block;
    padding: 10px 15px;
    background: black;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    transition: background 0.3s ease;
}

.login-btn:hover {
    background: rgba(0, 0, 0, 0.8);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container {
        max-width: 90%;
        padding: 20px;
    }

    button {
        font-size: 16px;
    }
}

    </style>
</head>

<div class="container">
    <h2>Create a New Account</h2>
    <form id="signupForm" action="register.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" name="terms" required>
                    <label>I agree to the terms and conditions</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Living Location</label>
                    <select name="location" class="form-control" required>
                        <option value="">Select Location</option>
                        <option value="USA">United States</option>
                        <option value="UK">United Kingdom</option>
                        <option value="Canada">Canada</option>
                        <option value="India">India</option>
                        <option value="Australia">Australia</option>
                        <option value="Philippines">Philippines</option>
                        <option value="China">China</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <span id="togglePassword" class="eye-icon">👁️</span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    <span id="toggleConfirmPassword" class="eye-icon">👁️</span>
                </div>
            </div>
        </div>
        <button type="submit">Sign Up</button>
    </form>

    <!-- Message Box -->
    <p id="messageBox" class="message"></p>

    <!-- Login Section -->
    <div class="login-container">
        <p>Already have an account?
        <a href="login.php" class="login-btn">Login</a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signupForm");
    const messageBox = document.getElementById("messageBox");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const togglePassword = document.getElementById("togglePassword");
    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

    form.addEventListener("submit", async (event) => {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);
        const dob = formData.get("dob");
        const phone = formData.get("phone");

        // Validate required fields
        const requiredFields = ["first_name", "last_name", "email", "username", "gender", "location", "phone", "dob", "password"];
        for (const field of requiredFields) {
            if (!formData.get(field)) {
                return showMessage("Please fill in all fields.", "error");
            }
        }

        // Validate phone number (only digits, max length 12)
        if (!/^\d{1,12}$/.test(phone)) {
            return showMessage("Phone number must be numeric and up to 12 digits.", "error");
        }

        // Validate password confirmation
        if (confirmPasswordInput.value !== passwordInput.value) {
            return showMessage("Passwords do not match.", "error");
        }

        // Age validation (must be at least 18)
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        if (today.getMonth() < birthDate.getMonth() || 
            (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 18) {
            return showMessage("You must be at least 18 years old to register.", "error");
        }

        // Send AJAX request
        try {
            const response = await fetch("register.php", {
                method: "POST",
                body: formData
            });
            const data = await response.text();

            if (!data.includes("Error:")) {
                const firstName = encodeURIComponent(formData.get("first_name"));
                const lastName = encodeURIComponent(formData.get("last_name"));
                window.location.href = `confirmation.php?firstname=${firstName}&lastname=${lastName}`;
            } else {
                showMessage(data, "error");
            }
        } catch {
            showMessage("Error submitting form!", "error");
        }
    });

    // Password visibility toggle
    function toggleVisibility(inputField, toggleButton) {
        toggleButton.addEventListener("click", () => {
            const isPassword = inputField.type === "password";
            inputField.type = isPassword ? "text" : "password";
            toggleButton.textContent = isPassword ? "👁️‍🗨️" : "👁️";
        });
    }

    if (togglePassword) toggleVisibility(passwordInput, togglePassword);
    if (toggleConfirmPassword) toggleVisibility(confirmPasswordInput, toggleConfirmPassword);

    // Display messages with animation
    function showMessage(text, type) {
        if (!messageBox) return;
        messageBox.textContent = text;
        messageBox.className = `message ${type}`;
        messageBox.style.opacity = "1";
        setTimeout(() => (messageBox.style.opacity = "0"), 3000);
    }
});
</script>

</body>
</html>



