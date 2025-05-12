<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="" />
    <style> 
    
    @import url(https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic);

:root {
  --primary-clr: #7522e6;
  --bg-clr: #f2f4f5;
  --white-bg: #fff;
  --dark-text-clr: #363b46;
  --light-text-clr: #fff;
  --hover-clr: #f1e8fd;
}
body.dark-mode {
  --primary-clr: #7522e6;
  --bg-clr: #1e1e1e;
  --white-bg: #23262b;
  --dark-text-clr: #fff;
  --light-text-clr: #fff;
  --hover-clr: #31313f;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  height: 100%;
  position: absolute;
  top: 50% 50%; 
  align-items: center;
  background: var(--bg-clr);
}
.container {
  width: 85px;
  min-height: 500px;
  margin: 0 auto;
  padding: 20px;
  overflow: hidden;
  border-radius: 10px;
  background-color: var(--white-bg);
  transition: all 0.3s ease;
}
.container.active {
  width: 250px;
}
.container .logo {
  width: 100%;
  margin-bottom: 30px;
}
.container ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.link-item:last-child {
  margin-top: 100px;
}
.link-item a {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 10px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 16px;
  white-space: nowrap;
  text-transform: capitalize;
  color: var(--dark-text-clr);
}
.link-item a span {
  transition: transform 0.5s;
  transform: translateX(100px);
}
.link-item:last-child span h4 {
  line-height: 1;
}
.link-item:last-child span p {
  font-size: 12px;
}
.container.active .link-item a span {
  transition-delay: calc(0.02s * var(--i));
  transform: translateX(0px);
}
.link-item a:hover {
  background-color: var(--hover-clr);
}
.link-item.active a {
  color: var(--light-text-clr);
  background-color: var(--primary-clr);
}
.link-item ion-icon {
  min-width: 20px;
  min-height: 20px;
  margin-right: 20px;
  position: relative;
}
.link-item img {
  width: 30px;
  height: 30px;
  margin-right: 20px;
  border-radius: 50%;
}
.link-item ion-icon.notification-icon::before {
  content: "";
  display: block;
  position: absolute;
  top: 3px;
  right: 2px;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background-color: var(--primary-clr);
  border: 1px solid var(--white-bg);
}
.link-item a .num-notification {
  margin-left: 40px;
  font-size: 12px;
  color: var(--light-text-clr);
  background-color: var(--primary-clr);
  min-width: 15px;
  height: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}
.link-item.active a .num-notification {
  color: var(--primary-clr);
  background-color: var(--white-bg);
}

/* Side Bar */

/* Table Styles */
table {
  width: 100%;
  border-collapse: collapse;
  background: var(--white-bg);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

table th, table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

table th {
  background: var(--primary-clr);
  color: var(--light-text-clr);
}

table tr:hover {
  background: var(--hover-clr);
}

/* Buttons */
button {
  padding: 8px 12px;
  border-radius: 5px;
  font-size: 14px;
  border: none;
  cursor: pointer;
  color: white;
  transition: opacity var(--transition-speed);
}

button:hover {
  opacity: 0.8;
}

.accept-btn { background-color: green; }
.delete-btn { background-color: red; }
.view-btn { background-color: blue; }

/* Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: var(--white-bg);
  padding: 20px;
  width: 50%;
  max-width: 500px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  position: relative;
}

.close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  cursor: pointer;
  color: var(--dark-text-clr);
}

/* Chart */
#statusChart {
  width: 100% !important;
  height: 400px !important;
  display: block;
  margin: 20px auto;
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
                <a href="#" class="link">
                    <ion-icon name="speedometer-outline"></ion-icon>
                    <span style="--i: 2">dashboard</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="business-outline"></ion-icon>
                    <span style="--i: 2">apartment</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="person-outline"></ion-icon>
                    <span style="--i: 2">tenant</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="build-outline"></ion-icon>
                    <span style="--i: 2">maintenance</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="document-outline"></ion-icon>
                    <span style="--i: 2">reports</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="search-outline"></ion-icon>
                    <span style="--i: 3">search</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon class="notification-icon" name="notifications-outline"></ion-icon>
                    <span style="--i: 4">notifications</span>
                    <span class="num-notification">4 </span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="cog-outline"></ion-icon>
                    <span style="--i: 6">settings</span>
                </a>
            </li>

            <li class="link-item dark-mode">
                <a href="#" class="link">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span style="--i: 8">dark mode</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="speedometer-outline"></ion-icon>
                    <span style="--i: 2">register</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="speedometer-outline"></ion-icon>
                    <span style="--i: 2">logout</span>
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

    <div class="content">
        <h1>Maintenance Dashboard</h1>
        
        <!-- Maintenance Request Table -->
        <table>
            <tr>
                <th>Tenant</th>
                <th>Apartment</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>John Doe</td>
                <td>101</td>
                <td>Leaking Pipe</td>
                <td>Pending</td>
                <td>2025-03-01</td>
                <td>
                    <button class="accept-btn">Accept</button>
                    <button class="delete-btn">Delete</button>
                    <button class="view-btn" onclick="openModal('Leaking pipe in kitchen', 'High', 'leak.jpg')">View</button>
                </td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>202</td>
                <td>Broken AC</td>
                <td>In Progress</td>
                <td>2025-03-02</td>
                <td>
                    <button class="accept-btn">Accept</button>
                    <button class="delete-btn">Delete</button>
                    <button class="view-btn" onclick="openModal('AC not cooling', 'Medium', 'ac.jpg')">View</button>
                </td>
            </tr>
        </table>
    
        <!-- Chart Section -->
        <canvas id="statusChart"></canvas>
    </div>
    
    <!-- Modal Structure -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Maintenance Details</h2>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Urgency Level:</strong> <span id="modalUrgency"></span></p>
            <p><strong>Picture:</strong></p>
            <img id="modalImage" src="" alt="Maintenance Image" style="width:100%; max-height:300px;">
        </div>
    </div>

    <script>
  document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container");
  const linkItems = document.querySelectorAll(".link-item");
  const darkMode = document.querySelector(".dark-mode");
  const logo = document.querySelector(".logo img"); // Ensure logo is selected correctly

  // Check localStorage for dark mode preference
  function applyDarkMode(isEnabled) {
    if (isEnabled) {
      document.body.classList.add("dark-mode");
      darkMode.querySelector("span").textContent = "light mode";
      darkMode.querySelector("ion-icon").setAttribute("name", "sunny-outline");
      localStorage.setItem("dark-mode", "enabled");
    } else {
      document.body.classList.remove("dark-mode");
      darkMode.querySelector("span").textContent = "dark mode";
      darkMode.querySelector("ion-icon").setAttribute("name", "moon-outline");
      localStorage.setItem("dark-mode", "disabled");
    }
  }

  // Apply saved mode on page load
  applyDarkMode(localStorage.getItem("dark-mode") === "enabled");

  if (container) {
    container.addEventListener("mouseenter", () => container.classList.add("active"));
    container.addEventListener("mouseleave", () => container.classList.remove("active"));
  }

  if (linkItems.length > 0) {
    linkItems.forEach((item) => {
      if (!item.classList.contains("dark-mode")) {
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
      const isDarkMode = !document.body.classList.contains("dark-mode");
      applyDarkMode(isDarkMode);
    });
  }
});

        function openModal(description, urgency, image) {
            document.getElementById("modalDescription").innerText = description;
            document.getElementById("modalUrgency").innerText = urgency;
            document.getElementById("modalImage").src = image;
            document.getElementById("viewModal").style.display = "block";
        }
        
        function closeModal() {
            document.getElementById("viewModal").style.display = "none";
        }
        
        let ctx = document.getElementById("statusChart").getContext("2d");
        let statusChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Maintenance Requests',
                    data: [3, 7, 4, 8, 6, 9, 5, 8, 7, 6, 10, 12],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
</script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>

</html>