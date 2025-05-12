<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="about.css">
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
                        <a class="nav-link me-2" href="viewing.php#available-rooms">Apartments</a>
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


    <div class="page-banner-wrap bg-dark">
        <div class="page-banner page-banner-m vh-50 bg-dark"></div>
        <div class="d-flex align-items-end badge bg-muted fs-1 fw-bold text-uppercase text-light">
            <h1>DM4J Apartment</h1>
        </div>
    </div>

    <br>
    <div class="container">
        <div class="card p-3 mb-2 bg-light">
            <div class="card-header p-3 mb-2 bg-light">
                About DM4J
            </div>
            <div class="card-body vh-50 p-3 mb-2 bg-light">
                <blockquote class="blockquote mb-0">
                    <p class="card-text text-center">Welcome to DM4J Apartment</p>
                    <p class="card-text text-center">"Where the ultimate place to call home</p>
                    <p class="card-text text-center">is not just a roof over your head</p>
                    <p class="card-text text-center">but a space where your heart feels at peace</P>
                    <p class="card-text text-center">and every corner tells a story of love, comfort, and belonging"</p>
                    </p>
                    <br>
                    <footer class="blockquote-footer fst-italic">From DM4J Apartment</cite></br>
                    </footer>
                </blockquote>
            </div>
        </div>
    </div>
    </br>

    <div class="container">
        <h2>Our Vision</h2>
    </div>

    <br>
    <div class="container">
        <div class="card mb-2 g-2 justify-content-center text-white bg-info" style="max-width: 2000px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="image/room2.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <br>
                        <br>
                        <p class="card-text fs-5 fw-bold text-center font-Merienda">At DM4J Apartment, our vision is to
                            create hassle-free
                            city living for all by
                            bringing people together in our inspiring spaces where they can thrive in an urban
                            environment.</p>
                        </br>
                        </br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </br>

    <div class="container">
        <h2>What We Do</h2>
    </div>

    </br>
    <div class="container">
        <div class="card mb-2 g-2 justify-content-center text-white bg-warning" style="max-width: 2000px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="image/room2.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <br>
                        <br>
                        <p class="card-text text-success fs-5 fw-bold text-center font-Merienda">Move-in ready, our
                            homes are fully
                            furnished with design-forward furniture and appliances, and a Apartment-quality bed offering
                            exceptional comfort.</p>
                        </br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </br>

    <div class="container">
        <h2>Owner of the DM4J Apartment</h2>
    </div>

    <br>
    <div class="container">
        <div class="card mb-2 g-2 justify-content-center text-dark bg-light" style="max-width: 2000px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="image/room2.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <br>
                        <br>
                        <h5 class="card-title text-uppercase fs-4 fw-bold text-dark text-center font-Merienda">Owner
                        </h5>
                        <p class="card-text text-uppercase fs-2 fw-bold text-dark text-center font-Merienda">Ms Karla
                            Mae Cajulao Portuguez</p>
                        </br>
                        </br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </br>

    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>