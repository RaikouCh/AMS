<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php'; // Ensure database connection

// Ensure user is logged in and has an admin role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== "admin") {
    echo json_encode(["status" => "error", "message" => "Unauthorized access!"]);
    exit();
}

// Fetch admin data for display
$admin_query = "SELECT * FROM form WHERE role = 'admin' LIMIT 1";
$admin_result = $conn->query($admin_query);
$admin = $admin_result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];
    $security_code = $_POST['security_code'];

    // Ensure passwords match before updating
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match!"]);
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update admin information in the database
    $query = "UPDATE form SET 
                first_name = ?, 
                last_name = ?, 
                email = ?, 
                username = ?, 
                phone = ?, 
                dob = ?, 
                gender = ?, 
                location = ?, 
                password = ?, 
                security_code = ?
              WHERE role = 'admin' LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $username, $phone, $dob, $gender, $location, $hashed_password, $security_code);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Admin account updated successfully!"]);
        header("Location: settings.php");
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating admin account."]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

.eye-icon {
    cursor: pointer;
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2em;
    color: #555;
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
        <h2 class="text-center">Admin Account Information</h2>
        
        <form class="row g-3 justify-content-center">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" value="<?php echo $admin['first_name']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" value="<?php echo $admin['last_name']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="<?php echo $admin['email']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="<?php echo $admin['username']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <input type="text" class="form-control" value="<?php echo $admin['gender']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" value="<?php echo $admin['location']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" value="<?php echo $admin['phone']; ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="text" class="form-control" value="<?php echo $admin['dob']; ?>" disabled>
            </div>
            <div class="col-md-6 text-center">
                <label class="form-label">Security Code</label>
                <input type="text" class="form-control text-center" value="<?php echo $admin['security_code']; ?>" disabled>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="settings.php" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-control" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        </div>
                        <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <select class="form-control" name="location" required>
                            <option value="USA">USA</option>
                            <option value="UK">UK</option>
                            <option value="Canada">Canada</option>
                            <option value="India">India</option>
                            <option value="Australia">Australia</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Japan">Japan</option>
                            <option value="China">China</option>
                        </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                        <div class="col-md-6 position-relative">
    <label class="form-label">Password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'eyeIcon1')">
            <ion-icon id="eyeIcon1" name="eye-off-outline"></ion-icon>
        </button>
    </div>
</div>

<div class="col-md-6 position-relative">
    <label class="form-label">Confirm Password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', 'eyeIcon2')">
            <ion-icon id="eyeIcon2" name="eye-off-outline"></ion-icon>
        </button>
    </div>
</div>

                        <div class="col-md-6">
                            <label class="form-label">Security Code</label>
                            <input type="text" class="form-control" name="security_code" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" onclick="updateAdmin()">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
function updateAdmin() {
    let firstName = document.getElementById('first_name').value;
    let lastName = document.getElementById('last_name').value;
    let email = document.getElementById('email').value;
    let username = document.getElementById('username').value;
    let phone = document.getElementById('phone').value;
    let dob = document.getElementById('dob').value;
    let gender = document.getElementById('gender').value;
    let location = document.getElementById('location').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirm_password').value;
    let securityCode = document.getElementById('security_code').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
    }

    let formData = new FormData();
    formData.append("first_name", firstName);
    formData.append("last_name", lastName);
    formData.append("email", email);
    formData.append("username", username);
    formData.append("phone", phone);
    formData.append("dob", dob);
    formData.append("gender", gender);
    formData.append("location", location);
    formData.append("password", password);
    formData.append("security_code", securityCode);

    function updateAdmin() {
    let formData = new FormData();
    document.querySelectorAll("#adminForm input").forEach(input => {
        formData.append(input.id, input.value);
    });

    fetch("settings.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") location.reload();
    })
    .catch(error => console.error('Error:', error));
}}

function togglePassword(inputId, iconId) {
    let passwordField = document.getElementById(inputId);
    let eyeIcon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.setAttribute("name", "eye-outline");
    } else {
        passwordField.type = "password";
        eyeIcon.setAttribute("name", "eye-off-outline");
    }
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>