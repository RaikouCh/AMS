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
        <div class="container bg-transparent text-light fs-1 fw-bold text-uppercase">
            <h1>DM4J Apartment</h1>
            <p class="fs-4 fw-bold">The ultimate place to call home.</p>
        </div>
    </div>

    <div class="container text-uppercase fs-3 fw-bold">
        <h2>Location of DM4J Apartment</h2>
    </div>

    <div class="container">
        <p class="text-bottom-start text-muted fs-4 fw-bold">DM4J Apartment is located at the Heart of Moncada
            Tarlac, Philippines.</p>
        <div class="row">
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3840.3490867520645!2d120.56190756960136!3d15.732661638576822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391351852fd59d5%3A0x7c3980a16c0fb1f0!2sAkitsuki%20wig%20ventilation!5e0!3m2!1sen!2sph!4v1731113031384!5m2!1sen!2sph"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>


    <footer class="text-center mt-5 p-4 bg-light">
        <p class="mb-0">&copy; 2024 DM4J Apartment. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>