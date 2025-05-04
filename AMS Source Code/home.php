<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'register');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch apartment details if `apartment_id` is provided
$apartment_id = isset($_GET['apartment_id']) ? intval($_GET['apartment_id']) : 0;
$apartment = null;
$amenities = [];

if ($apartment_id > 0) {
    // Fetch apartment details
    $stmt = $conn->prepare("SELECT * FROM apartments WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $apartment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $apartment = $result->fetch_assoc();
        $stmt->close();
    }

    if ($apartment) {
        // Fetch amenities (without icon)
        $stmt = $conn->prepare("
            SELECT amenities.name 
            FROM apartment_amenities 
            JOIN amenities ON apartment_amenities.amenity_id = amenities.id 
            WHERE apartment_amenities.apartment_id = ?
        ");
        if ($stmt) {
            $stmt->bind_param("i", $apartment_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $amenities[] = $row['name'];
            }
            $stmt->close();
        }
    }
}

// Fetch all apartments with optional filters
$query = "SELECT * FROM apartments WHERE 1";
$params = [];
$types = "";

// Apply price filter if provided
if (isset($_GET['price']) && is_numeric($_GET['price'])) {
    $query .= " AND price <= ?";
    $params[] = $_GET['price'];
    $types .= "i";
}

// Apply room type filter if provided
if (isset($_GET['type']) && !empty($_GET['type'])) {
    $query .= " AND room_type = ?";
    $params[] = $_GET['type'];
    $types .= "s";
}

// Prepare and execute statement for apartment filtering
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $apartments = $stmt->get_result();
        $stmt->close();
    }
} else {
    $apartments = $conn->query($query);
}

// Fetch all amenities
$allAmenities = $conn->query("SELECT * FROM amenities");

// Fetch notifications from the announcements table
$notifications = [];
$announcements = $conn->query("SELECT * FROM announcements ORDER BY date_posted DESC");
if ($announcements) {
    while ($row = $announcements->fetch_assoc()) {
        $notifications[] = [
            "id" => $row["id"],
            "title" => $row["title"],
            "message" => $row["message"],
            "time" => $row["date_posted"]
        ];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <style>
 * {
        font-family: 'Poppins', sans-serif;
    }

    .h-font {
        font-family: "Merienda", cursive;
    }

body {
    background-color: #f8f9fa;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* Hero Section */
.hero {
    background-image: url('image/462569797_2056616284786278_3431511704346069351_n.jpg');
    height: 100vh;
    background-size: cover;
    background-position: center;
    color: black;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 20px;
}

.hero p {
    font-size: 1.2rem;
}

/* Buttons */
button {
    background-color: rgb(255, 255, 255);
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-hero {
    background-color:rgb(32, 32, 32);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
}

.btn-hero:hover {
    background: rgba(89, 90, 90, 0.7);
}

.btn-outline-dark {
    border: 2px solidrgb(165, 165, 165);
    color:rgb(95, 95, 95);
    transition: 0.3s;
}

.btn-outline-dark:hover {
    background:rgb(104, 104, 104);
    color: #fff;
}

/* Header Banner */
.header-banner {
    background: #FFD700;
    color: black;
    font-weight: bold;
    text-align: center;
    padding: 10px;
}

/* Filter Section */
form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

form label {
    font-weight: bold;
}

form input,
form select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

form button:hover {
    background: #0056b3;
}

/* Cards */
.card {
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #fff;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.card img,
.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    text-align: center;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
}

.card-text {
    font-size: 1rem;
    color: #666;
}

.text-muted {
    font-size: 1rem;
    font-weight: bold;
    color: #007bff;
}

/* Apartment Listing */
.listing-container {
    font-family: Arial, sans-serif;
}

.apartment-image {
    width: 100%;
    height: auto;
}

.info-section {
    padding: 20px;
    background-color: #f5f5f5;
}

.price {
    font-size: 24px;
    color: #008000;
    font-weight: bold;
}

/* Status Badge */
.status {
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 5px;
}

.status.available {
    color: green;
}

.status.booked {
    color: red;
}

/* Modal Styles */
.modal-content {
    border-radius: 10px;
}

.modal-header {
    background: #007bff;
    color: white;
    border-radius: 10px 10px 0 0;
}

.modal-body {
    padding: 0;
    background-color: #ffffff;
}

.modal-footer {
    background-color: #f8f9fa;
    justify-content: space-between;
}

/* Amenities */
.icon-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 10px;
    background-color: rgb(0, 0, 0);
    padding: 15px;
    border-radius: 5px;
}

.icon-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: bold;
    color: #333;
}

.icon-item i {
    font-size: 18px;
    color: rgb(0, 0, 0);
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        flex-direction: column;
        align-items: stretch;
    }

    .card {
        margin-bottom: 20px;
    }

    .hero h1 {
        font-size: 2.5rem;
    }

    .hero p {
        font-size: 1rem;
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
        <li><a class="dropdown-item" href="maintenance.php">Maintenance</a></li>
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
                <span id="notificationBadge" class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">
                    <span class="reservation-count"><?= count($notifications) ?></span>
                </span>
            </button>
            <a href="account1.php" class="btn border-0 shadow-none">
                <img src="image/person-crop-circle-svgrepo-com.svg" alt="Profile" width="30" height="24">
            </a>
          <!-- Cart Button with Red Dot Badge -->
<button class="btn position-relative border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#myReservations" aria-controls="myReservations">
    <img src="image/cart.svg" alt="Cart" width="30" height="24">
    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-2"></span>
</button>

        </div>
    </div>
</nav>

<script>
$(document).ready(function () {
    function updateNotificationCount() {
        let count = $("#notificationList .list-group-item").length;
        if (count === 0) {
            $("#notificationBadge").hide(); // Hide badge if no notifications
        } else {
            $("#notificationBadge").show().text(count); // Show updated count
        }
        $(".reservation-count").text(`(${count})`);
    }

    function addNotification(title, message) {
        let notificationItem = `
            <li class="list-group-item">
                <strong>${title}</strong>: ${message}
            </li>
        `;

        // Remove "No notifications found" message if exists
        if ($("#notificationList .list-group-item.text-muted").length) {
            $("#notificationList").empty();
        }

        $("#notificationList").prepend(notificationItem);
        updateNotificationCount(); // Update count dynamically
    }

    // On form submit, add notification and update count
    $("#announcementForm").on("submit", function (e) {
        e.preventDefault();
        let formData = {
            title: $("#announcementTitle").val().trim(),
            message: $("#announcementMessage").val().trim()
        };
        
        if (!formData.title || !formData.message) {
            alert("Title and message cannot be empty.");
            return;
        }
        
        addNotification(formData.title, formData.message);
        updateNotificationCount();
        
        let form = this;
        setTimeout(() => form.submit(), 300); // Proceed with form submission after a short delay
    });

    updateNotificationCount(); // Run initially to update count
});
</script>

<!-- Notifications Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="myNotification">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Notifications <span class="reservation-count">(<?= count($notifications) ?>)</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul id="notificationList" class="list-group">
            <?php if (empty($notifications)) : ?>
                <li class="list-group-item text-center text-muted">No notifications found.</li>
            <?php else : ?>
                <?php foreach ($notifications as $notification) : ?>
                    <li class="list-group-item">
                        <strong><?= $notification['title']; ?></strong>: <?= $notification['message']; ?>
                        <br><small class="text-muted"><?= $notification['time']; ?></small>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<!-- Reservations Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="myReservations">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">My Reservations (0)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul id="reservationList" class="list-group">
            <li class="list-group-item text-center text-muted">No reservations found.</li>
        </ul>
        <a href="account.php" class="btn btn-link">View All</a>
    </div>
</div>

<!-- Hero Section -->
<div class="hero position-relative">
    <div class="hero-overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>
    <div class="container text-light position-relative" style="z-index: 1;">
        <h1 class="fw-bold text-uppercase">DM4J Apartment</h1>
        <p>The ultimate place to call home.</p>
        <button onclick="window.location.href='#available-rooms';" class="btn btn-outline-light shadow-none py-2 px-4">
            View Rooms
        </button>
    </div>
</div>


    <div class="container mt-4" id="available-rooms">
    <h2 class="mb-4">Available Rooms</h2>

    <!-- Filter Section -->
    <form method="GET" class="mb-4">
        <label for="price">Max Price:</label>
        <input type="number" name="price" id="price" placeholder="Enter max price" value="<?php echo htmlspecialchars($price_filter); ?>">

        <label for="type">Room Type:</label>
        <select name="type" id="type">
            <option value="">All</option>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($apartment = $apartments->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="uploads/<?php echo htmlspecialchars($apartment['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($apartment['room_name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($apartment['room_name']); ?></h5>
                        <p class="card-text"><?php echo $apartment['person_quantity']; ?> Pax</p>
                        <p class="text-muted">₱<?php echo number_format($apartment['price'], 2); ?> / Month</p>
                        <div class="d-flex">
                            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#apartmentModal<?php echo $apartment['id']; ?>">Book Now</button>
                            <p>Status: <span class="<?php echo strtolower($apartment['status']); ?>"><?php echo ucfirst($apartment['status']); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartment Modal -->
            <div class="modal fade" id="apartmentModal<?php echo $apartment['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $apartment['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo htmlspecialchars($apartment['room_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="listing-container">
                                <div class="header-banner">Only one left</div>
                                <img src="uploads/<?php echo htmlspecialchars($apartment['image']); ?>" alt="Apartment Image" class="apartment-image">
                                <div class="info-section">
                                    <p><strong>Size:</strong> <i class="fas fa-building"></i> 26.7m² / 287ft²</p>
                                    <p class="price">₱<?php echo number_format($apartment['price'], 2); ?>/month</p>

                                    <h5>In-Unit Appliances & Amenities</h5>
                                    <div class="row row-cols-1 row-cols-md-3 g-4">
                                        <?php 
                                        // Fetch amenities for the current apartment
                                        $apartment_id = $apartment['id'];
                                        $amenities_query = $conn->query("
                                            SELECT amenities.name 
                                            FROM apartment_amenities 
                                            JOIN amenities ON apartment_amenities.amenity_id = amenities.id 
                                            WHERE apartment_amenities.apartment_id = '$apartment_id'
                                        "); 
                                        ?>

                                        <?php if ($amenities_query && $amenities_query->num_rows > 0): ?>
                                            <ul>
                                                <?php while ($a = $amenities_query->fetch_assoc()): ?>
                                                    <li><?php echo htmlspecialchars($a['name']); ?></li>
                                                <?php endwhile; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>No amenities found for this apartment.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button onclick="window.location.href='apartment.php?id=<?php echo $apartment['id']; ?>';" type="button" class="btn btn-primary">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>    
        <?php endwhile; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ================== Dynamic Notifications & Reservations ==================
    async function fetchData(url) {
        try {
            const response = await fetch(url);
            return response.json();
        } catch (error) {
            console.error(`Error fetching ${url}:`, error);
            return [];
        }
    }

    async function updateNotifications() {
        const data = await fetchData("fetch_notifications.php");
        const notificationList = document.getElementById("notificationList");
        const notificationBadge = document.getElementById("notificationBadge");

        notificationList.innerHTML = data.length === 0
            ? '<li class="list-group-item text-center text-muted">No notifications found.</li>'
            : data.map(notification => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${notification.title}</strong>: ${notification.message}
                        <br><small class="text-muted">${notification.time}</small>
                    </div>
                    <button class="btn btn-sm btn-danger remove-btn" data-id="${notification.id}">✖</button>
                </li>`).join("");

        notificationBadge.textContent = data.length;
        addRemoveListeners();
    }

    async function updateReservations() {
        const data = await fetchData("fetch_reservations.php");
        const reservationList = document.getElementById("reservationList");
        const reservationBadge = document.getElementById("reservationBadge");

        reservationList.innerHTML = data.length === 0
            ? '<li class="list-group-item text-center text-muted">No reservations found.</li>'
            : data.map(reservation => `<li class="list-group-item">${reservation.details}</li>`).join("");

        reservationBadge.textContent = data.length;
    }

    function addRemoveListeners() {
        document.querySelectorAll(".remove-btn").forEach(button => {
            button.addEventListener("click", async function () {
                await fetch(`delete_notification.php?id=${this.dataset.id}`);
                updateNotifications();
            });
        });
    }

    // Initial load and auto-refresh every 30 seconds
    updateNotifications();
    updateReservations();
    setInterval(() => {
        updateNotifications();
        updateReservations();
    }, 30000);

    // ================== Offcanvas Sidebar Handling ==================
    document.querySelectorAll(".offcanvas-trigger").forEach(trigger => {
        trigger.addEventListener("click", function () {
            const offcanvas = document.querySelector(this.dataset.bsTarget);
            if (offcanvas) new bootstrap.Offcanvas(offcanvas).show();
        });
    });

    // ================== Dark Mode Toggle ==================
    const darkModeToggle = document.getElementById("darkModeToggle");
    if (localStorage.getItem("darkMode") === "enabled") document.body.classList.add("dark-mode");
    
    darkModeToggle?.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        localStorage.setItem("darkMode", document.body.classList.contains("dark-mode") ? "enabled" : "disabled");
    });

    // ================== Sidebar Expand Animation ==================
    document.getElementById("sidebar")?.addEventListener("mouseenter", function () {
        this.classList.add("expanded");
    });
    document.getElementById("sidebar")?.addEventListener("mouseleave", function () {
        this.classList.remove("expanded");
    });

    // ================== Apartment Filter ==================
    document.getElementById("filterForm")?.addEventListener("submit", function (event) {
        event.preventDefault();
        const filterValue = document.getElementById("filterInput").value.toLowerCase();
        document.querySelectorAll(".card").forEach(card => {
            card.style.display = card.querySelector(".card-title").textContent.toLowerCase().includes(filterValue) ? "block" : "none";
        });
    });

    // ================== Booking Modal ==================
    document.querySelectorAll(".btn-book").forEach(button => {
        button.addEventListener("click", function () {
            const bookingModal = new bootstrap.Modal(document.getElementById("bookingModal"));
            document.getElementById("modalTitle").textContent = this.dataset.name;
            document.getElementById("modalBody").innerHTML = `
                <img src="${this.dataset.image}" class="img-fluid rounded mb-3" alt="${this.dataset.name}">
                <h5 class="text-success">Price: ${this.dataset.price}</h5>
                <p>Would you like to proceed with the booking?</p>`;
            bookingModal.show();
        });
    });

    // ================== Announcements System ==================
    document.getElementById("announcementForm")?.addEventListener("submit", async function (e) {
        e.preventDefault();
        try {
            await fetch("announcement.php", { method: "POST", body: new FormData(this) });
            updateNotifications();
            this.reset();
        } catch (error) {
            console.error("Error submitting announcement:", error);
        }
    });
});
</script>
            <footer class="text-center mt-5 p-4 bg-light">
                <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>