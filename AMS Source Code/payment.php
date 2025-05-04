<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "register");

if (!$conn) {
    die("Database connection failed.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $payment_method = htmlspecialchars($_POST['payment_method']);

    // File upload handling
    $receipt_path = "";
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["receipt"]["name"]);
        $receipt_path = $target_dir . $file_name;

        // Ensure the uploads directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES["receipt"]["tmp_name"], $receipt_path)) {
            echo "<script>alert('Failed to upload receipt.'); window.location.href = 'payment.php';</script>";
            exit();
        }
    }

    // Insert into database
    $sql = "INSERT INTO payment (firstname, lastname, phone_number, payment_method, receipt_path) 
            VALUES ('$firstname', '$lastname', '$phone_number', '$payment_method', '$receipt_path')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to success page with first and last name in URL
        header("Location: success.php?firstname=" . urlencode($firstname) . "&lastname=" . urlencode($lastname));
        exit;
    } else {
        echo "<script>alert('Error recording payment. Try again.'); window.location.href = 'payment.php';</script>";
        exit();
    }
}

mysqli_close($conn);
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="contact1.css">
    <style>
    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    .h-font {
        font-family: "Merienda", cursive;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .hero {
        background-image: url('image/462569797_2056616284786278_3431511704346069351_n.jpg');
        height: auto;
        background-size: cover;
        background-position: center;
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .hero h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: blue;
    }

    .hero p {
        font-size: 1.2rem;
    }

    .btn-hero {
        background-color: #007BFF;
        border: none;
    }

    .btn-hero:hover {
        background-color: #0056b3;
    }

/* Container */
.container {
    width: 80%;
    max-width: 900px;
    background: #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
}

/* Left Section (Payment Info) */
.contact-left {
    background:rgb(0, 0, 0);
    color: white;
    padding: 20px;
    border-radius: 10px 10px 0 0;
    text-align: center;
}

.contact-left h1 {
    margin: 0;
    font-size: 24px;
}

.contact-left .title {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
}

.contact-left .text, .contact-left .tel {
    font-size: 16px;
}

.contact-left a {
    color:rgb(255, 255, 255);
    font-weight: bold;
    text-decoration: none;
}

/* Form Section */
.contact-right-wrap {
    padding: 20px;
}

.title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
}

.form-remark {
    font-size: 14px;
    color: red;
    text-align: right;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.error {
    font-size: 12px;
    color: red;
    display: none;
}

/* Submit Button */
.btn-action {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-action:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }

    .contact-left {
        border-radius: 10px 10px 0 0;
    }
}

    footer {
        background-color: #f8f9fa;
        padding: 20px 0;
        page-break-after: always;
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

<div class="container vh-100">
        <div class="row contact-wrap">
            <div class="col-md-4 col-12">
                <div class="contact-left">
                    <h1>Payment Processing</h1>
                    <div class="title">Gcash Account</div>
                    <div class="text">Name: <a href="#">Karla Mae Cajulao Portuguez</a></div>
                    <div class="tel">Gcash Number: <a href="tel:+639760889796">+639760889796</a></div>
                </div>
            </div>
            <div class="col-md-8 col-12 contact-right-wrap">
                <form id="contactus-form" method="POST" action="payment.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="title">Ready Your Payment!</div>
                        </div>
                        <div class="col-md-4 col-12 text-end">
                            <div class="form-remark">* Compulsory fields</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name*" required>
                                <div class="error" id="firstname_error">First name is required.</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name*" required>
                                <div class="error" id="lastname_error">Last name is required.</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number*" pattern="[0-9+\s]*" required>
                                <div class="error" id="phone_number_error">Phone number is required.</div>
                                <div class="error" id="phone_number_format_error">Invalid phone number format.</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="">Preferred Payment Method*</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="receipt">Payment Receipt</label>
                                <input type="file" class="form-control" id="receipt" name="receipt" required>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-action">Submit Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script> 
 document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let valid = true;

    // Reset error messages
    document.querySelectorAll('.error').forEach(error => {
        error.style.display = 'none';
    });

    // Validate first name
    let firstname = document.getElementById('firstname').value.trim();
    if (!firstname) {
        document.getElementById('firstname_error').style.display = 'block';
        valid = false;
    }

    // Validate last name
    let lastname = document.getElementById('lastname').value.trim();
    if (!lastname) {
        document.getElementById('lastname_error').style.display = 'block';
        valid = false;
    }

    // Validate phone number
    let phone_number = document.getElementById('phone_number').value.trim();
    if (!phone_number) {
        document.getElementById('phone_number_error').style.display = 'block';
        valid = false;
    } else if (!/^[\d+\s]+$/.test(phone_number)) {
        document.getElementById('phone_number_format_error').style.display = 'block';
        valid = false;
    }

    // Validate payment method
    let payment_method = document.getElementById('payment_method').value;
    if (!payment_method) {
        document.getElementById('payment_method_error').style.display = 'block';
        valid = false;
    }

    // Validate receipt upload
    let receipt = document.getElementById('receipt').files[0];
    if (!receipt) {
        document.getElementById('receipt_error').style.display = 'block';
        valid = false;
    }

    if (valid) {
        let formData = new FormData(document.getElementById('payment-form'));

        fetch("payment.php", {  
            method: "POST",
            body: formData
        })
        .then(response => {
            // Redirect with first name and last name
            window.location.href = `success.php?firstname=${encodeURIComponent(firstname)}&lastname=${encodeURIComponent(lastname)}`;
        })
        .catch(error => console.error("Error:", error));
    }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>