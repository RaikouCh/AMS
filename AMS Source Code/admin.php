<?
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

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
}

.container.active + .content {
  margin-left: var(--sidebar-width-expanded);
  width: calc(100% - var(--sidebar-width-expanded));
}

.dashboard-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 20px;
}

.card {
  padding: 20px;
  border-radius: 10px;
  color: white;
  text-align: center;
  transition: transform var(--transition-speed), background var(--transition-speed);
}

.card:hover {
  transform: scale(1.05);
}

.card.blue, .card.green, .card.orange, .card.red, .card.purple, .card.yellow {
  flex: 1;
}

.card.blue { background: #007bff; }
.card.green { background: #28a745; }
.card.orange { background: #fd7e14; }
.card.red { background: #dc3545; }
.card.purple { background: #6f42c1; }
.card.yellow { background: #ffc107; }

#charts {
  margin-top: 30px;
}

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
            <li class="link-item active">
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
            <li class="link-item">
                <a href="reservation.php" class="link">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <span style="--i: 2">Reservations</span>
                </a>
            </li>
            <li class="link-item">
                <a href="main.php" class="link">
                    <ion-icon name="build-outline"></ion-icon>
                    <span style="--i: 2">Maintenance</span>
                </a>
            </li>
            <li class="link-item">
                <a href="report.php" class="link">
                    <ion-icon name="document-outline"></ion-icon>
                    <span style="--i: 2">Reports</span>
                </a>
            </li>
            <li class="link-item">
                <a href="pay.php" class="link">
                    <ion-icon name="card-outline"></ion-icon>
                    <span style="--i: 3">Payments</span>
                </a>
            </li>
            <li class="link-item">
                <a href="announced.php" class="link">
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
                <a href="settings.php" class="link">
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
                <a href="registered.php" class="link">
                    <ion-icon name="person-add-outline"></ion-icon>
                    <span style="--i: 2">Register</span>
                </a>
            </li>
            <li class="link-item">
                <a href="logout.php" class="link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span style="--i: 2">Logout</span>
                </a>
            </li>
            <li class="link-item">
                <a href="admin.php" class="link">
                    <img src="image/philippines-svgrepo-com.svg" alt="" />
                    <span style="--i: 9">
                        <h4>DM4J Apartment</h4>
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="dashboard-cards">
            <div class="card blue"><ion-icon name="business-outline"></ion-icon><h3>Total Apartments</h3><p>3</p></div>
            <div class="card orange"><ion-icon name="build-outline"></ion-icon><h3>Pending Maintenance</h3><p>3</p></div>
            <div class="card red"><ion-icon name="calendar-outline"></ion-icon><h3>New Reservations</h3><p>16</p></div>
            <div class="card purple"><ion-icon name="document-outline"></ion-icon><h3>Reports Generated</h3><p>2</p></div>
            <div class="card yellow"><ion-icon name="card-outline"></ion-icon><h3>Total Payments</h3><p>16</p></div>
        </div>
        
        <div id="charts">
            <h3>Reservation Room Today</h3>
            <canvas id="roomTodayChart"></canvas>
            
            <h3>Reservation Chart</h3>
            <canvas id="reservationChart"></canvas>
        </div>
    </div>

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

function createCharts() {
        const roomTodayCtx = document.getElementById('roomTodayChart').getContext('2d');
        const reservationCtx = document.getElementById('reservationChart').getContext('2d');

        if (!roomTodayCtx || !reservationCtx) return;

        new Chart(roomTodayCtx, {
            type: 'bar',
            data: {
                labels: ['Room 101', 'Room 102', 'Room 103'],
                datasets: [{
                    label: 'Reservations Today',
                    data: [5, 3, 8],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        new Chart(reservationCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    label: 'Reservations Overview',
                    data: [12, 6, 2],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: { responsive: true }
        });
    }

    createCharts();
</script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>

</html>