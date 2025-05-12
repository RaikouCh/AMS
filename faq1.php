<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM4J Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="faq1.css">
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
        background-color:rgb(0, 0, 0);
        border: none;
    }

    .btn-hero:hover {
        background-color:rgb(0, 0, 0);
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
        <div class="container bg-transparent text-uppercase fw-bold text-light fs-1">
            <h1>DM4J Apartment</h1>
            <p class="fs-4 fw-bold">The ultimate place to call home.</p>
        </div>
    </div>

    <br>
    <h2 class="visually-hidden">Title for screen readers</h2>
    <a class="visually-hidden-focusable" href="#content">Skip to main content</a>
    <div class="visually-hidden-focusable">A container with a <a href="#">focusable element</a>.</div>
    </br>

    <ul class="nav text-success text-uppercase fw-bold fs-4 nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#general">General</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Leasing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Before Move-in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Property</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Residents</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">All Topics</a>
        </li>
    </ul>

    <br>
    <div class="accordion container-fluid g-2 col-9 gy-5 p-3 overflow-hidden" id="general">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="false" aria-controls="collapseOne">
                    Where are DM4J Apartment properties located?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="text-center text-uppercase fs-5 fw-bold">
                        <p>The location of DM4J Apartment</p>
                        <p>is located in</p>
                        <p>Poblacion 1, Moncada Tarlac</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How do DM4J Apartment furnished homes compare with regular rental properties in Moncada Tarlac?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="text-center fs-5 fw-bold text-break">
                        <p>All our furnished homes come with design-forward furniture and appliances
                            a Apartment-quality bed offering exceptional comfort, and ample storage
                            Moreover, residents can move in within as little as three days
                            By signing a fixed-term rental contract
                            which is renewable and ranges from a minimum of one month to a maximum of 18 months
                            you can enjoy an all-inclusive service
                            This includes all utilities, high-speed Wi-Fi, and a smart TV.</p>
                        <p>You can finalize a fixed-term rental contract online in around 15 minutes by using electronic
                            payments.
                            Our simple pricing structure, with no additional fees beyond rent and security deposit
                            to ensures a straightforward and speedy contract process</p>
                        <p>With a standard Apartment rental contract, you typically need to pay
                            a various fees such as key money, brokerage fees, management fees, internet charges, utility
                            bills
                            bicycle parking fees, renewal fees, re-contracting fees, key exchange fees, guarantor
                            company fees,
                            and furniture and appliance costs, and other miscellaneous expenses. For all Weave Place
                            properties,
                            however, none of these fees are required. For all DM4J Apartment Place properties.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Can you take videos or photos on the premises?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="text-center fs-5 fw-bold text-break">
                        <p>Filming, photography and videography for personal use is acceptable</p>
                        <p>However, you must seek prior authorization from DM4J Apartment for any marketing or
                            commercial content.</p>
                        <p>DM4J Apartment strictly prohibits any materials produced at any DM4J Apartment property
                            including – but not limited to photography, audio and video recording</p>
                        <p>from broadcast, release, publication, exhibition, or reproduction to be used for news,
                            webcasts, promotional purposes, telecasts, advertising, inclusion on websites, social media,
                            or any other use without our prior consent.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Do I have to bring my own linen?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <p>Bedding such as sheets, duvets, and pillows are provided</p>
                        <p>but we do not offer linen exchange or regular cleaning services during your stay</p>
                        <p>We kindly ask guests to arrange these services as needed.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    What is DM4J Apartment?
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <P>As Asia-Pacific’s living sector specialist, DM4J Apartment owns, develops and manages
                            properties to world-class standards – with many more planned for the future</p>
                        <p>We acquire properties as new constructions and cater to various customer needs by operating
                            some units as unfurnished standard rental properties and others as furnished monthly rental
                            properties</p>
                        <p>This allows us to provide an optimal living environment tailored to different preferences.
                        </p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    For a newly-arrived professional working in Moncada Tarlac, which DM4J Apartment property is most
                    suitable?
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <p>At DM4J Apartment Place, we provide the same standard of furniture, appliances, and
                            furnishings in all our properties</p>
                        <p>You can enjoy a comfortable living environment by selecting your desired room type and
                            contract duration from properties conveniently located</P>
                        <p>Utilities are all included in the rent so no need to register with utility companies
                            including electricity, gas, or water. Moreover, high-speed Wi-Fi is instantly available so
                            you can enjoy hassle-free living from day one.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    For exchange peoples/familys/groups/students or workers on a short-term stay with a limited budget,
                    which DM4J Apartment unit is most suitable?
                </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <p>For peoples/familys/groups/students or workers new to Moncada Tarlac, we recommend units such
                            as
                            those at our DM4J Apartment Place that are conveniently close to university campuses
                            and workplaces.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                    Do you have any pet-friendly apartments?
                </button>
            </h2>
            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <p>At DM4J Apartment, it is possible to have pets under certain conditions at specific units</p>
                        <p>Please inquire with our Leasing Team for details, as this applies only to certain units</p>
                        <p>Kindly understand that approval may not be guaranteed after the screening process.</p>
                    </strong>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                    Do DM4J Apartment units have their own kitchen?
                </button>
            </h2>
            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong class="fs-5 fw-bold text-center text-break">
                        <p>Yes, all units in DM4J Apartment have a system kitchen featuring a freezer, microwave,
                            kettle, pan(s), knives, as well as a complete set of cutlery, dishes, and glasses for the
                            number of occupants.</p>
                    </strong>
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