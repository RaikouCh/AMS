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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="viewing.css">
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

    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="viewing.php">DM4J Apartment</a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link me-2" aria-current="page" href="viewing.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="offers.php">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="#available-rooms">Apartments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="location.php">Getting Here</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" aria-current="page" href="about.php">About DM4J</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="image/philippines-svgrepo-com.svg" alt="" width="30" height="24"
                                class="d-inline-block align-text-top">
                            PH
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">
                                    <img src="image/united-kingdom-svgrepo-com.svg" alt="" width="30" height="24"
                                        class="d-inline-block align-text-top">
                                    EN
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="#">
                                    <img src="image/japan-svgrepo-com.svg" alt="" width="30" height="24"
                                        class="d-inline-block align-text-top">
                                    JP
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="#">
                                    <img src="image/united-kingdom-svgrepo-com.svg" alt="" width="30" height="24"
                                        class="d-inline-block align-text-top">
                                    HK
                                </a>
                            </li>
                            <li>
                        </ul>
                </ul>
                <div class="d-flex">
                    <button onclick="window.location.href='login.php';"
                        class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal"
                        data-bs-target="#LoginModal">
                        <i class="bi bi-person-fill"></i>
                        Login
                    </button>
                    <button onclick="window.location.href='register.php';" class="btn btn-outline-dark shadow-none"
                        data-bs-toggle="modal" data-bs-target="#RegisterModal">
                        <i class="bi bi-person-fill"></i>
                        Register
                    </button>
                </div>
            </div>
        </div>
    </nav>


    <div class="hero">
        <div class="hero-overlay"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
        </div>
        <div class="container fs-1 fw-bold text-uppercase text-light position-relative z-index-1">
            <h1>DM4J Apartment</h1>
            <p>The ultimate place to call home.</p>
            <button onclick="window.location.href='#available-rooms';"
                class="button btn-outline-dark shadow-none py-2 px-4">
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
                            <button type="button"  onclick="window.location.href='login.php';" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#apartmentModal<?php echo $apartment['id']; ?>">Book Now</button>
                            <p>Status: <span class="<?php echo strtolower($apartment['status']); ?>"><?php echo ucfirst($apartment['status']); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
    </div>
</div>

<script>
     document.getElementById("filterForm")?.addEventListener("submit", function (event) {
        event.preventDefault();
        const filterValue = document.getElementById("filterInput").value.toLowerCase();
        document.querySelectorAll(".card").forEach(card => {
            card.style.display = card.querySelector(".card-title").textContent.toLowerCase().includes(filterValue) ? "block" : "none";
        });
    });

</script>

            <footer class="text-center mt-5 p-4 bg-light">
                <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
            </script>
</body>
</html>