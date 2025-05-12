<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM register.form WHERE id='$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country_code = $_POST['country_code'];

    $query = "UPDATE register.form SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone', country_code='$country_code' WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Profile updated successfully!";
    }

    if (!empty($_POST['old_password']) && !empty($_POST['new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];

        $result = mysqli_query($conn, "SELECT password FROM register.form WHERE id='$user_id'");
        
        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }

        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($old_password, $row['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE register.form SET password='$hashed_password' WHERE id='$user_id'";

            if (mysqli_query($conn, $update_query)) {
                $_SESSION['message'] = "Password changed successfully!";
            }
        } else {
            $_SESSION['error'] = "Incorrect old password!";
        }
    }
}

$sql = "SELECT * FROM leasing";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <style>
/* General Styles */
* {
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #f8f9fa;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar */
.navbar {
    background-color: white;
    padding: 10px 15px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
}

/* Navbar Brand */
.navbar-brand {
    font-weight: bold;
    font-family: 'Merienda', cursive;
    font-size: 1.5rem;
}

/* Sidebar */
.sidebar {
    width: 300px;
    background: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 56px;
    overflow-y: auto;
}

.sidebar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    display: block;
    margin: 0 auto;
    object-fit: cover;
    border: 3px solid #ddd;
}

.profile-info {
    text-align: center;
    margin-top: 15px;
}

.profile-info h3 {
    margin: 10px 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.profile-info p {
    color: gray;
    font-size: 0.9rem;
}

.profile-info .btn,
.change-password-btn {
    display: block;
    width: 100%;
    padding: 10px;
    background: black;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    margin-top: 15px;
}

.profile-info .btn:hover,
.change-password-btn:hover {
    background: #333;
}

/* Main Content */
.main-content {
    flex-grow: 1;
    padding: 30px;
    background: white;
    text-align: center;
    margin-left: 320px;
    margin-top: 70px;
}

/* Reservation Container */
.reservation-container {
    border: 1px solid #ddd;
    padding: 30px;
    border-radius: 10px;
    background: #ffffff;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 90%;
    margin: auto;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.reservation-container h2 {
    margin-bottom: 15px;
    font-size: 1.8rem;
    color: #333;
}

.reservation-container .btn {
    margin-top: 20px;
    padding: 10px 15px;
    background: black;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

.reservation-container .btn:hover {
    background: #333;
}

/* Reservations Table */
.table-container {
    width: 100%;
    overflow-x: auto;
    margin-top: 10px;
}

#reservationsTable {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

#reservationsTable th, 
#reservationsTable td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
}

#reservationsTable th {
    background-color: #007bff;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}

#reservationsTable tbody tr:hover {
    background-color: #f1f1f1;
}

/* No Reservations Message */
.no-reservation-message {
    text-align: center;
    margin-top: 20px;
}

.no-reservation-message img {
    width: 50px;
    margin-bottom: 10px;
}

.no-reservation-message p {
    font-size: 16px;
    color: #555;
}

/* Button */
.no-reservation-message .btn {
    margin-top: 10px;
    padding: 10px 15px;
    background: black;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

.no-reservation-message .btn:hover {
    background: #333;
}

/* No reservations row */
.no-reservations {
    text-align: center;
    font-weight: bold;
    color: #777;
}

/* Status Badges */
.status {
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
}

.status.Approved {
    background-color: #28a745;
    color: white;
}

.status.Pending {
    background-color: #ffc107;
    color: black;
}

.status.Rejected {
    background-color: #dc3545;
    color: white;
}

/* Password Field - Eye Icon */
.position-relative {
    position: relative;
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

/* Ensure Password Input Doesn't Overlap */
.form-control {
    padding-right: 45px;
}

/* Modal Styling */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
}

.modal-footer {
    border-top: 1px solid #ddd;
}

/* Footer */
footer {
    text-align: center;
    padding: 15px;
    background-color: #f8f9fa;
    color: #333;
    font-size: 0.9rem;
    position: fixed;
    bottom: 0;
    width: 100%;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .sidebar {
        width: 250px;
    }

    .main-content {
        margin-left: 270px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        padding: 15px;
        position: relative;
        height: auto;
    }

    .main-content {
        margin-left: 0;
        padding: 15px;
        margin-top: 70px;
    }

    footer {
        position: relative;
    }

    .reservation-container {
        padding: 15px;
    }

    #reservationsTable th, 
    #reservationsTable td {
        font-size: 14px;
        padding: 8px;
    }
}

@media (max-width: 480px) {
    .navbar-brand {
        font-size: 1.2rem;
    }

    .profile-info h3 {
        font-size: 1rem;
    }

    .reservation-container {
        padding: 10px;
    }

    #reservationsTable th, 
    #reservationsTable td {
        font-size: 12px;
        padding: 6px;
    }
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top justify-content-center">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="home.php">DM4J Apartment</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link me-2" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link me-2" href="offers1.php">Offers</a></li>
                <li class="nav-item"><a class="nav-link me-2" href="home.php#available-rooms">Apartments</a></li>
                <li class="nav-item"><a class="nav-link me-2" href="location1.php">Getting Here</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Others
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="maintenance.php">Maintenance</a></li>
                        <li><a class="dropdown-item" href="faq1.php">FAQ</a></li>
                        <li><a class="dropdown-item" href="about1.php">About DM4J</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link me-2" href="contact1.php">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="image/philippines-svgrepo-com.svg" alt="PH" width="30" height="24" class="d-inline-block align-text-top"> PH
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownLang">
                        <li><a class="dropdown-item" href="#"><img src="image/united-kingdom-svgrepo-com.svg" alt="EN" width="30" height="24" class="d-inline-block align-text-top"> EN</a></li>
                        <li><a class="dropdown-item" href="#"><img src="image/japan-svgrepo-com.svg" alt="JP" width="30" height="24" class="d-inline-block align-text-top"> JP</a></li>
                        <li><a class="dropdown-item" href="#"><img src="image/hong-kong-svgrepo-com.svg" alt="HK" width="30" height="24" class="d-inline-block align-text-top"> HK</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        
        <!-- Profile and Cart Buttons -->
        <div class="d-flex align-items-center">
        <button class="btn position-relative border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myNotification" aria-controls="myNotification">
                <img src="image/envelope.svg" alt="Envelope" width="30" height="24">
                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">0</span>
            </button>
            <a href="account1.php" class="btn border-0 shadow-none">
                <img src="image/person-crop-circle-svgrepo-com.svg" alt="Profile" width="30" height="24">
            </a>
            <button class="btn position-relative border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myReservations" aria-controls="myReservations">
                <img src="image/cart.svg" alt="Cart" width="30" height="24">
                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">0</span>
            </button>
        </div>
    </div>
</nav>


<!-- Offcanvas Sidebar (My Reservations) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="myReservations" aria-labelledby="myReservationsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="myReservationsLabel">My Reservations <span class="reservation-count">0</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>No reservations found.</p>
        <a href="account.php" class="btn btn-link">View All</a>
    </div>
</div>

<!-- Offcanvas Sidebar (My Notification) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="myNotification" aria-labelledby="myNotificationLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="myNotificationLabel">Notification <span class="reservation-count">0</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>No notification found.</p>
    </div>
</div>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
    <img src="<?php echo !empty($user['profile_image']) ? $user['profile_image'] : 'image/462569797_2056616284786278_3431511704346069351_n.jpg'; ?>" 
     alt="Profile Image">
        <div class="profile-info">
            <h3>NATHANIEL LASQUETY</h3> <!-- Add to dictionary or ignore in spell checker settings -->
            <p>nathaniellasquety2024@gmail.com</p>
            <!-- Edit Profile triggers the modal -->
            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</a>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</a>
            <a href="logout.php" class="btn">Log out</a>
        </div>
    </div>

    <div class="main-content">
    <h2>My Reservations</h2>
    <div class="reservation-container">
        <div class="container">
            <table id="reservationsTable" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reservation No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Leasing Options</th>
                        <th>Property</th>
                        <th>Preferred Stay Period</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$count}</td>
                                <td>" . ($row['name'] ?? 'N/A') . "</td>
                                <td>" . ($row['email'] ?? 'N/A') . "</td>
                                <td>" . ($row['phone'] ?? 'N/A') . "</td>
                                <td>" . ($row['contactMethod'] ?? 'N/A') . "</td>
                                <td>" . ($row['leasingOption'] ?? 'N/A') . "</td>
                                <td>" . ($row['property'] ?? 'N/A') . "</td>
                                <td>" . ($row['stayPeriodStart'] ?? 'N/A') . " - " . ($row['stayPeriodEnd'] ?? 'N/A') . "</td>
                                <td><span class='status " . ($row['status'] ?? 'Pending') . "'>" . ($row['status'] ?? 'Pending') . "</span></td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='10' class='no-reservations'>No reservations found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <div class="no-reservation-message" style="display: <?php echo ($result->num_rows > 0) ? 'none' : 'block'; ?>;">
    <img src="image/building-icon-svgrepo-com.svg" alt="No Reservations">
    <p>You have not reserved any units</p>
    <button onclick="window.location.href='home.php#available-rooms';" class="btn">Explore Other Home Types</button>
</div>
    </div>
</div>

<?php $conn->close(); ?>



<div class="d-flex">
    <div class="sidebar">
    <img src="<?php echo !empty($user['profile_image']) ? $user['profile_image'] : 'image/'; ?>" 
     alt="Profile Image">
        <div class="profile-info">
            <h3><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h3>
            <p><?php echo $user['email']; ?></p>
            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</a>
            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</a>
            <a href="logout.php" class="btn">Log out</a>
        </div>
    </div>
</div>

<script>
        $(document).ready(function() {
            $('#reservationsTable').DataTable();
        });
    </script>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone No.</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <img id="selected-flag" src="https://flagcdn.com/w40/ph.png" width="24">
                            </span>
                            <select id="country-code" class="form-select" name="country_code">
                                <option value="+1" data-flag="us">🇺🇸 +1 (USA)</option>
                                <option value="+44" data-flag="gb">🇬🇧 +44 (UK)</option>
                                <option value="+63" data-flag="ph" selected>🇵🇭 +63 (Philippines)</option>
                                <option value="+91" data-flag="in">🇮🇳 +91 (India)</option>
                                <option value="+81" data-flag="jp">🇯🇵 +81 (Japan)</option>
                                <option value="+49" data-flag="de">🇩🇪 +49 (Germany)</option>
                                <option value="+33" data-flag="fr">🇫🇷 +33 (France)</option>
                                <option value="+61" data-flag="au">🇦🇺 +61 (Australia)</option>
                                <option value="+55" data-flag="br">🇧🇷 +55 (Brazil)</option>
                                <option value="+27" data-flag="za">🇿🇦 +27 (South Africa)</option>
                            </select>
                            <input type="text" class="form-control" name="phone" value="<?php echo $user['phone']; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

  <script>
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); 
    alert("Profile updated successfully!");
});

 // Close the modal correctly
 const modalElement = document.getElementById('editProfileModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modalInstance.hide();
</script>

<!-- Change Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <div class="mb-3 position-relative">
                        <input type="password" class="form-control" id="oldPassword" placeholder="Old Password">
                        <span id="toggleOldPassword" class="eye-icon" aria-label="Toggle password visibility">👁️</span>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" class="form-control" id="newPassword" placeholder="New Password">
                        <span id="toggleNewPassword" class="eye-icon" aria-label="Toggle password visibility">👁️</span>
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                        <span id="toggleConfirmPassword" class="eye-icon" aria-label="Toggle password visibility">👁️</span>
                    </div>

                    <p id="error-message" class="text-danger"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateForm()">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Function to toggle password visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input && icon) {
            icon.addEventListener("click", function () {
                input.type = input.type === "password" ? "text" : "password";
                icon.textContent = input.type === "password" ? "👁️" : "👁️‍🗨️"; // Change icon based on visibility
            });
        }
    }

    // Apply toggle function to all password fields
    togglePassword("oldPassword", "toggleOldPassword");
    togglePassword("newPassword", "toggleNewPassword");
    togglePassword("confirmPassword", "toggleConfirmPassword");

    // Handle password change form submission
    document.getElementById("passwordForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent page reload

        const oldPassword = document.getElementById("oldPassword").value;
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const errorMessage = document.getElementById("error-message");

        // Reset error message
        errorMessage.textContent = "";

        if (!oldPassword) {
            errorMessage.textContent = "Old password is required!";
            return;
        }

        if (newPassword.length < 6) {
            errorMessage.textContent = "Password must be at least 6 characters long!";
            return;
        }

        if (newPassword !== confirmPassword) {
            errorMessage.textContent = "Passwords do not match!";
            return;
        }

        // Send AJAX request to update password
        fetch("account.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                old_password: oldPassword,
                new_password: newPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Password changed successfully!");

                // Close modal correctly
                const modalElement = document.getElementById("passwordModal");
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                modalInstance.hide();

                // Reset form fields
                document.getElementById("passwordForm").reset();
            } else {
                errorMessage.textContent = data.error;
            }
        })
        .catch(error => {
            errorMessage.textContent = "An error occurred. Please try again.";
            console.error("Error:", error);
        });
    });
});

</script>


    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>