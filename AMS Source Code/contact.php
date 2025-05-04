<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="contact.css">
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

    <div class="page-banner-wrap">
        <div class="page-banner page-banner-m vh-50"></div>
        <div class="container bg-transparent text-uppercase fw-bold text-light fs-1">
            <h1>DM4J Apartment</h1>
            <p class="fs-4 fw-bold">The ultimate place to call home.</p>
        </div>
    </div>

    <section class="container my-5 contact text-uppercase fw-bold fs-5">
        <h1 class="mb-4"> <span class="highlight-letter">C</span>ontact Us</h1>
        <p>For your booking kindly call the following <br> from 7AM to 11PM</p>
        <br>

        <div class="contact-info">
            <p><i class="fas fa-phone-alt"></i> +63 663 945 1610 &nbsp;&nbsp; <i class="fas fa-phone-alt"></i> +63 663
                945
                1610 </p>
        </div>
        <br>
        <p>You can also contact us in facebook:</p>
        <p><i class="fas fa-envelope" style="font-size: 1.8rem;"></i> <a
                href="https://www.facebook.com/maemae.portuguez?mibextid=LQQJ4d" style="font-size: 1.3rem;">Facebook</a>
        </p>
    </section>
    </div>
    </div>
    </div>

    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>