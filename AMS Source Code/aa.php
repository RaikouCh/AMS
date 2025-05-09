<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="" />
    <script src="script.js" defer></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
@import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900');

:root {
  --primary-clr: #7522e6;
  --bg-clr: #f2f4f5;
  --white-bg: #fff;
  --dark-text-clr: #363b46;
  --light-text-clr: #fff;
  --hover-clr: #f1e8fd;
  --transition-speed: 0.3s;
  --sidebar-width-collapsed: 80px;
  --sidebar-width-expanded: 250px;
}

body.Dark-Mode {
  --bg-clr: #1e1e1e;
  --white-bg: #23262b;
  --dark-text-clr: #fff;
  --hover-clr: #31313f;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  display: flex;
  height: 100vh;
  width: 100%;
  background: var(--bg-clr);
  overflow: hidden;
}

.container {
  width: var(--sidebar-width-collapsed);
  height: 100vh;
  background: var(--white-bg);
  padding: 20px 10px;
  border-radius: 10px;
  overflow: hidden;
  transition: width var(--transition-speed) ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
}

.container.active {
  width: var(--sidebar-width-expanded);
  overflow-y: auto;
}

.container .logo {
  width: 100%;
  margin-bottom: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: transform var(--transition-speed), justify-content var(--transition-speed);
}

.container .logo img {
  transition: transform var(--transition-speed);
}

.container:hover .logo {
  justify-content: flex-start;
}

.container ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.link-item a {
  display: flex;
  align-items: center;
  padding: 15px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 16px;
  color: var(--dark-text-clr);
  white-space: nowrap;
  justify-content: center;
  position: relative;
}

.link-item a:hover {
  background-color: var(--hover-clr);
}

.link-item.active a {
  background-color: var(--primary-clr);
  color: var(--light-text-clr);
}

.link-item ion-icon {
  font-size: 24px;
  min-width: 28px;
  transition: transform var(--transition-speed);
  position: relative;
}

.link-item span {
  display: none;
  transition: opacity var(--transition-speed);
}

.container.active .link-item {
  justify-content: flex-start;
}

.container.active .link-item a {
  justify-content: flex-start;
  padding-left: 20px;
}

.container.active .link-item ion-icon {
  margin-right: 15px;
}

.container.active .link-item span {
  display: inline;
  opacity: 1;
}

.link-item img {
  width: 40px;
  height: 40px;
  margin-right: 20px;
  border-radius: 50%;
}

.link-item ion-icon.notification-icon {
  position: relative;
}

.link-item ion-icon.notification-icon::before {
  content: "";
  display: block;
  position: absolute;
  top: 5px;
  right: 5px;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background-color: var(--primary-clr);
  border: 1px solid var(--white-bg);
}

.link-item a .num-notification {
  position: absolute;
  top: 50%;
  right: 8px;
  transform: translateY(-50%);
  font-size: 12px;
  font-weight: bold;
  color: var(--white-bg);
  background-color: var(--primary-clr);
  min-width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.link-item.active a .num-notification {
  color: var(--primary-clr);
  background-color: var(--white-bg);
}

.content {
  flex-grow: 1;
  padding: 20px;
  margin-left: var(--sidebar-width-collapsed);
  transition: margin-left var(--transition-speed);
  overflow-y: auto;
  height: 100vh;
  width: calc(100% - var(--sidebar-width-collapsed));
  display: flex;
  flex-direction: column;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
}

.container.active + .content {
  margin-left: var(--sidebar-width-expanded);
  width: calc(100% - var(--sidebar-width-expanded));
}

/* Table Styles */
.table {
    border-collapse: collapse;
  border-radius: 10px;
  width: 100%;
  overflow: hidden;
}

.table th {
  background: var(--primary-clr);
  color: var(--light-text-clr);
  padding: 15px;
  border-bottom: 1px solid #ddd;
}

.table td {
  padding: 12px;
  color: var(--dark-text-clr);
  border-bottom: 1px solid #ddd;
}

.img-thumbnail {
  border-radius: 10px;
  transition: transform 0.3s;
}

.img-thumbnail:hover {
  transform: scale(1.05);
}

.table tbody tr:hover {
  background: rgba(0, 123, 255, 0.1);
  transition: all 0.3s ease;
}

/* Buttons */
.btn {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s ease;
}

.btn-primary {
  background: #007bff;
  border: none;
}

.btn-warning {
  background: #ffc107;
  border: none;
  color: #333;
}

.btn-success {
  background:rgb(0, 255, 34);
  border: none;
  color: #333;
}

.btn-danger {
  background: #dc3545;
  border: none;
}

.btn:hover {
  opacity: 0.8;
}

/* Modal */
.modal-content {
  background: var(--white-bg);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-header, .modal-footer {
  border-bottom: 2px solid var(--primary-clr);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
  color: var(--dark-text-clr);
}

.btn-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--dark-text-clr);
}

.btn-close:hover {
  color: red;
}

.modal-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

#res-image {
    width: 50%; /* Adjust size */
    max-width: 300px; /* Ensures it doesn't get too large */
    height: auto; /* Keeps aspect ratio */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin-bottom: 15px;
}


.modal-body div {
  flex: 1;
}

.icon-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  padding: 5px 10px;
  border-radius: 8px;
  background: rgba(0, 123, 255, 0.1);
  color: #007bff;
  transition: all 0.3s ease;
}

.icon-item i {
  color: var(--primary-clr);
  font-size: 18px;
}

.icon-item:hover {
  background: #007bff;
  color: white;
}
    
.header-banner {
  background: var(--primary-clr);
  color: var(--light-text-clr);
  padding: 5px;
  font-size: 14px;
  text-align: center;
  border-radius: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .container {
    width: var(--sidebar-width-collapsed);
  }
  .content {
    margin-left: var(--sidebar-width-collapsed);
    width: calc(100% - var(--sidebar-width-collapsed));
  }
}
</style>
    <title>AMS Main Dashboard</title>
</head>

<body>
    <div class="container">
        <div class="logo">
            <image src="image/philippines-svgrepo-com.svg" width="32.519" height="30.7" viewBox="0 0 32.519 30.7"
                fill="#363b46">
                <g id="Logo" transform="translate(-90.74 -84.875)">
                    <path id="B"
                        d="M14.378-30.915c-5.124,0-9.292,3.767-9.292,10.228S9.254-10.46,14.378-10.46h1.471c5.124,0,9.292-3.767,9.292-10.228s-4.168-10.228-9.292-10.228H14.378M11.7-33.456h6.819A12.768,12.768,0,0,1,31.29-20.687,12.768,12.768,0,0,1,18.522-7.919H11.7A12.768,12.768,0,0,1-1.065-20.687C-2.4-51.282,4.652-33.456,11.7-33.456Z"
                        transform="translate(91.969 123.494)" />
                </g>
            </image>
        </div>
        <ul class="link-items">
            <li class="link-item">
                <a href="admin.php" class="link">
                    <ion-icon name="speedometer-outline"></ion-icon>
                    <span style="--i: 2">Dashboard</span>
                </a>
            </li>
            <li class="link-item">
                <a href="apart.php" class="link">
                    <ion-icon name="business-outline"></ion-icon>
                    <span style="--i: 2">Apartment</span>
                </a>
            </li> 
            <li class="link-item active">
                <a href="a.php" class="link">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <span style="--i: 2">Reservations</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="build-outline"></ion-icon>
                    <span style="--i: 2">Maintenance</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="document-outline"></ion-icon>
                    <span style="--i: 2">Reports</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="card-outline"></ion-icon>
                    <span style="--i: 3">Payments</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="megaphone-outline"></ion-icon>
                    <span style="--i: 3">Announcements</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon class="notification-icon" name="notifications-outline"></ion-icon>
                    <span style="--i: 4">Notifications</span>
                    <span class="num-notification">4 </span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="cog-outline"></ion-icon>
                    <span style="--i: 6">Settings</span>
                </a>
            </li>

            <li class="link-item Dark-Mode">
                <a href="#" class="link">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span style="--i: 8">Dark mode</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="person-add-outline"></ion-icon>
                    <span style="--i: 2">Register</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span style="--i: 2">Logout</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <img src="image/philippines-svgrepo-com.svg" alt="" />
                    <span style="--i: 9">
                        <h4>Mark Cooper</h4>
                        <p>DM4J Apartment</p>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    </body>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Report</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Apartment Reports</h2>

        <!-- Date Filter -->
        <label for="dateFilter">Filter by Date:</label>
        <input type="date" id="dateFilter" onchange="filterReports()">
        
        <!-- Table for Report -->
        <table id="reportTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Apartment</th>
                    <th>Tenant</th>
                    <th>Payment Status</th>
                    <th>Amount ($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2025-03-01</td>
                    <td>Apt 101</td>
                    <td>John Doe</td>
                    <td>Paid</td>
                    <td>1200</td>
                </tr>
                <tr>
                    <td>2025-03-02</td>
                    <td>Apt 202</td>
                    <td>Jane Smith</td>
                    <td>Pending</td>
                    <td>1000</td>
                </tr>
                <tr>
                    <td>2025-03-02</td>
                    <td>Apt 303</td>
                    <td>Michael Brown</td>
                    <td>Paid</td>
                    <td>1300</td>
                </tr>
            </tbody>
        </table>

        <!-- Export Button -->
        <button onclick="exportCSV()">Download CSV</button>

        <!-- Chart Section -->
        <h3>Payment Status Overview</h3>
        <canvas id="paymentChart"></canvas>
    </div>

    <script src="script.js"></script>

    <script>
  document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container");
  const linkItems = document.querySelectorAll(".link-item");
  const darkMode = document.querySelector(".Dark-Mode");
  const logo = document.querySelector(".logo img"); // Ensure logo is selected correctly

  // Check localStorage for dark mode preference
  function applyDarkMode(isEnabled) {
    if (isEnabled) {
      document.body.classList.add("Dark-Mode");
      darkMode.querySelector("span").textContent = "Light mode";
      darkMode.querySelector("ion-icon").setAttribute("name", "sunny-outline");
      localStorage.setItem("Dark-Mode", "enabled");
    } else {
      document.body.classList.remove("Dark-Mode");
      darkMode.querySelector("span").textContent = "Dark Mode";
      darkMode.querySelector("ion-icon").setAttribute("name", "moon-outline");
      localStorage.setItem("Dark-Mode", "disabled");
    }
  }

  // Apply saved mode on page load
  applyDarkMode(localStorage.getItem("Dark-Mode") === "enabled");

  if (container) {
    container.addEventListener("mouseenter", () => container.classList.add("active"));
    container.addEventListener("mouseleave", () => container.classList.remove("active"));
  }

  if (linkItems.length > 0) {
    linkItems.forEach((item) => {
      if (!item.classList.contains("Dark-Mode")) {
        item.addEventListener("click", () => {
          linkItems.forEach((linkItem) => linkItem.classList.remove("active"));
          item.classList.add("active");
        });
      }
    });
  }

  // Toggle dark mode on button click
  if (darkMode) {
    darkMode.addEventListener("click", () => {
      const isDarkMode = !document.body.classList.contains("Dark-Mode");
      applyDarkMode(isDarkMode);
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
    const viewBtns = document.querySelectorAll(".view1-btn");
    const modal = document.getElementById("editReserve");
    const closeModalBtns = document.querySelectorAll(".close-modal");

    viewBtns.forEach(button => {
        button.addEventListener("click", function () {
            modal.style.display = "block";
        });
    });

    closeModalBtns.forEach(button => {
        button.addEventListener("click", function () {
            modal.style.display = "none";
        });
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>
</html>