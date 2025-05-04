<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", "", "register");

if ($conn->connect_error) {
    die("Error: Database Connection Failed.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : "";
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
    $stayPeriodStart = isset($_POST['stayPeriodStart']) ? $_POST['stayPeriodStart'] : "";
    $stayPeriodEnd = isset($_POST['stayPeriodEnd']) ? $_POST['stayPeriodEnd'] : "";
    $leasingOption = isset($_POST['leasingOption']) ? $_POST['leasingOption'] : "";
    $property = isset($_POST['property']) ? $_POST['property'] : "";
    $contactMethod = isset($_POST['contactMethod']) ? $_POST['contactMethod'] : "";
    $message = isset($_POST['message']) ? $_POST['message'] : "";
    $source = isset($_POST['source']) ? $_POST['source'] : "";
    $terms = isset($_POST['terms']) ? 1 : 0;

    if (!$firstName || !$lastName || !$email || !$phone || !$stayPeriodStart || !$stayPeriodEnd) {
        die("Error: Missing required fields.");
    }

    // Handle file upload
    $idPicturePath = "";
    if (!empty($_FILES['idPicture']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['idPicture']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['idPicture']['tmp_name'], $targetFile)) {
            $idPicturePath = $targetFile;
        } else {
            die("Error: File upload failed.");
        }
    }

    // Insert into database
    $sql = "INSERT INTO leasing (firstName, lastName, email, phone, stayPeriodStart, stayPeriodEnd, leasingOption, property, contactMethod, message, source, terms, idPicture, created_at) 
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$stayPeriodStart', '$stayPeriodEnd', '$leasingOption', '$property', '$contactMethod', '$message', '$source', '$terms', '$idPicturePath', NOW())";

    if ($conn->query($sql) === TRUE) {
        $conn->close(); // Close connection before redirect
        header("Location: agreement1.php");
        exit();
    } else {
        $conn->close(); // Close connection on error
        die("Error: Database Issue.");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet">
    <style>
        * {
        font-family: 'Poppins', sans-serif;
    }

    .h-font {
        font-family: "Merienda", cursive;
    }

    /* Contact Details */
.contact-details {
    background: #fcf2d5;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    align-items: center;
}

.contact-details h3 {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 10px;
    align-items: center;
}

.contact-details p {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
    align-items: center;
}

/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    justify-content: center;
    align-items: center;
    background-image: url('image/462569797_2056616284786278_3431511704346069351_n.jpg');
}

/* Container */
.container {
    font-family: 'Poppins', sans-serif;
    background: white;
    align-items: start;
    padding: 30px;
    margin-top: 40px;
}

.contact-form-container {
    background: transparent !important;
}

/* Typography */
h2 {
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
}

h3 {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 10px;
}

p {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
}

/* Labels */
form label {
    font-size: 14px;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 5px;
    display: flex;
    align-items: center; /* Aligns items vertically */
    gap: 5px; /* Adds spacing between checkbox and label text */
}

/* Input Fields */
form input,
form select,
form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    margin-bottom: 15px;
}

/* File Input */
form input[type="file"] {
    padding: 5px;
}

/* Textarea */
form textarea {
    height: 80px;
    resize: vertical;
}

/* Checkbox Alignment Fix */
form label.checkbox-label {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Ensure checkbox doesn't have extra margins */
form label.checkbox-label input[type="checkbox"] {
    margin: 0;
    width: auto;
}


/* Submit Button */
button {
    background: #006644;
    color: white;
    padding: 12px;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #004d33;
}

/* Footer */
footer {
    background-color: #f8f9fa;
    padding: 20px;
    text-align: center;
    margin-top: 40px;
}

/* Responsive */
@media (max-width: 600px) {
    .container {
        padding: 20px;
    }

    h2 {
        font-size: 20px;
    }

    form label {
        font-size: 13px;
    }

    button {
        font-size: 14px;
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
                
                <!-- Others Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOthers" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Others
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownOthers">
                    <li><a class="dropdown-item" href="#">Maintenance</a></li>
                    <li><a class="dropdown-item" href="faq1.php">FAQ</a></li>
                    <li><a class="dropdown-item" href="about1.php">About DM4J</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link me-2" href="contact1.php">Contact</a></li>
                
                <!-- Language Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="image/philippines-svgrepo-com.svg" alt="PH" width="30" height="24" class="me-1"> PH
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownLang">
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="image/united-kingdom-svgrepo-com.svg" alt="EN" width="30" height="24" class="me-1"> EN</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="image/japan-svgrepo-com.svg" alt="JP" width="30" height="24" class="me-1"> JP</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><img src="image/hong-kong-svgrepo-com.svg" alt="HK" width="30" height="24" class="me-1"> HK</a></li>
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

<div class="container">
        <h2>We would love to hear from you!</h2>
        <div class="contact-details">
            <h3>Get in Touch</h3>
            <p><strong>Booking Enquiry</strong><br>
               Phone Number: +639760889796<br>
               Email: <a href="karlamaeportuquez15@gmail.com">karlamaeportuquez15@gmail.com</a></p>
            <p><strong>Media Enquiry</strong><br>
               Email: <a href="karlamaeportuquez15@gmail.com">karlamaeportuquez15@gmail.com</a></p>
            <p><strong>General Enquiry</strong><br>
               Email: <a href="karlamaeportuquez15@gmail.com">karlamaeportuquez15@gmail.com</a></p>
        </div>
        <form id="contactForm" enctype="multipart/form-data">
            <label for="firstName">First Name*</label>
            <input type="text" id="firstName" name="firstName" required>
            
            <label for="lastName">Last Name*</label>
            <input type="text" id="lastName" name="lastName" required>
            
            <label for="email">Email*</label>
            <input type="email" id="email" name="email" required>
            
            <label for="phone">Phone Number*</label>
            <input type="tel" id="phone" name="phone" required>
            
            <label for="contactMethod">Preferred Contact Method*</label>
            <select id="contactMethod" name="contactMethod" required>
                <option value="email">Email</option>
                <option value="phone">Phone</option>
            </select>
            
            <label for="leasingOption">Leasing Option*</label>
            <select id="leasingOption" name="leasingOption" required>
                <option value="short-term">Short-term</option>
                <option value="long-term">Long-term</option>
            </select>
            
            <label for="property">Interested Property*</label>
            <select id="property" name="property" required>
                <option value="apartment1">Apartment 1</option>
                <option value="apartment2">Apartment 2</option>
                <option value="apartment3">Apartment 3</option>
            </select>
            
            <label for="stayPeriod">Preferred Stay Period*</label>
            <input type="date" id="stayPeriodStart" name="stayPeriodStart" required>
            <input type="date" id="stayPeriodEnd" name="stayPeriodEnd" required>
            
            <label for="idPicture">Upload ID (Picture)*</label>
            <input type="file" id="idPicture" name="idPicture" accept="image/*" required>
            
            <label for="message">Any message for us</label>
            <textarea id="message" name="message"></textarea>
            
            <label for="source">How did you hear about us?*</label>
            <select id="source" name="source" required>
                <option value="google">Google</option>
                <option value="facebook">Facebook</option>
                <option value="friend">Friend</option>
                <option value="other">Other</option>
            </select>
            
            <label class="checkbox-label">
    <input type="checkbox" id="terms" name="terms" required> I agree to the Terms and Conditions
</label>

            <button type="submit">SUBMIT</button>
        </form>
    </div>

    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");

    form.onsubmit = function (event) {
        event.preventDefault(); // Prevent page reload

        if (!validateForm()) return;

        const formData = new FormData(form);
        const submitButton = form.querySelector("button[type='submit']");
        submitButton.disabled = true;
        submitButton.textContent = "Submitting...";

        fetch("agreement.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            window.location.href = "agreement1.php"; // Redirect after successful submission
        })
        .catch(() => {
            alert("Something went wrong. Please try again.");
            submitButton.disabled = false;
            submitButton.textContent = "SUBMIT";
        });
    };

    function validateForm() {
        const requiredFields = ["firstName", "lastName", "email", "phone", "stayPeriodStart", "stayPeriodEnd"];
        for (let field of requiredFields) {
            if (!document.getElementById(field).value.trim()) {
                alert("Please fill in all required fields.");
                return false;
            }
        }

        if (!document.getElementById("idPicture").files.length) {
            alert("Please upload an ID picture.");
            return false;
        }

        if (!document.getElementById("terms").checked) {
            alert("You must agree to the Terms and Conditions.");
            return false;
        }

        return true;
    }
});
</script>
</body>
</html>