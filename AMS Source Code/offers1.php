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


    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .page-banner-wrap {
        background-image: url('image/462569797_2056616284786278_3431511704346069351_n.jpg');
        color: rgba(255, 255, 255, 0.5);
        height: 50vh;
        background-size: cover;
        background-position: center;
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

    * {
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.navbar {
    background-color: rgba(255, 255, 255, 0.5);
    
}

.occupied {
    color: red;
}

.vacant {
    color: green;
}

.hero {
    height: 400px; 
    background-size: cover;
    background-position: center;
    color: white;
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

.hero h1,
.hero p {
    color: blue;
    background-color: rgba(255, 255, 255, 0.5);
}


.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.hero h1 {
    font-size: 5rem;
    margin-bottom: 20px;
}

.hero h2 {
    font-size: 5rem;
    margin-bottom: 20px;
    background-color: rgba(255, 255, 255, 0.5);
}

.hero p {
    font-size: 1.5rem;
}

.arrow-btn {
    cursor: pointer;
    padding: 10px 20px;
    margin: 5px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    font-size: 1em;
}

.btn-hero:hover {
    background-color: #0056b3;
}

.container {
    margin-top: 40px;
}

.card {
    transition: transform 0.2s;
}


.card.active {
    display: block;
}

.card:hover {
    transform: scale(1.05);
}

.table {
    margin-top: 40px;
}

footer {
    background-color: #f8f9fa;
    padding: 20px;
    text-align: center;
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

    <div class="page-banner-wrap">
        <div class="page-banner page-banner-m vh-50"></div>
        <div class="container bg-transparent text-shadow-dark text-uppercase fw-bold text-light fs-1">
            <h1>DM4J Apartment</h1>
            <p class="fs-4 fw-bold">The ultimate place to call home.</p>
        </div>
    </div>

    <div class="container">
        <h2>Promotions DM4J</h2>
    </div>

    <div class="container">
        <div class="card mb-3" style="max-width: 100%; margin: 0 auto" style="height: 100-vh">
            <div class="col-md-8 justify-content-center">
                <div class="card-body">
                    <br></br>
                    <h5 class="card-title text-uppercase text-success text-center fs-1">First Anniversary Offer</h5>
                    <br></br>
                    <h5 class="card-title text-uppercase text-success text-center fs-1">Stay 3 months+ and get an extra
                        10% OFF!</h5>
                    <br>
                    </br>
                    <p class="card-text text-center fs-3">To celebrate DM4J Apartment Place's one-year milestone in
                        Moncada
                        Tarlac we’re
                        offering
                        this exclusive deal! For a limited time, enjoy a <u class="bg-warning">Further 10% OFF*</u>our
                        already discounted 3-month+ rent. Plus get <u class="bg-warning">PH 500 Masters
                            Credits^!</u>
                        <br></br>
                        Please note, 10% has already been applied to the price displayed on our website
                        To qualify, book before 30 November 2024, move in before 31 January 2025
                        and stay from 90 to 269 days
                        <br></br>
                        So <u class="text-danger">book your stay</u> today and enjoy the comfort of a stylish
                        fully-furnished apartment at our one PH locations!
                        <br></br>
                        <br></br>
                        <u class="text-dark text-center fs-4 fw-bold">Offer subject to availability.
                            Terms & Conditions apply.</u>
                    <p class="text-dark text-center fs-4 fw-bold">*Discount applies to our listed monthly rate.</p>
                    <p class="text-dark text-center fs-4 fw-bold">Master Credits will be provided to eligible residents
                        before
                        arrival at the property.</p>
                    <p class="text-dark text-center fs-4 fw-bold">Please note: If a resident terminates their lease
                        before the
                        agreed end date, a ₱500 fee
                        will be charged. This is in addition to the termination policy outlined in the contract and
                        serves as compensation for the Uber credit.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>