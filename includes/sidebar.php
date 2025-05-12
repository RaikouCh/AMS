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
                    <ion-icon name="person-outline"></ion-icon>
                    <span style="--i: 2">Admin Account</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="database-down-outline"></ion-icon>
                    <span style="--i: 2">Database Backup</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="database-up-outline"></ion-icon>
                    <span style="--i: 2">Restore Database</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span style="--i: 2">Return</span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 2"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 3"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon class="notification-icon" name=""></ion-icon>
                    <span style="--i: 4"></span>
                    <span class="num-notification"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 6"></span>
                </a>
            </li>

            <li class="link-item dark-mode">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 8"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 2"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <ion-icon name=""></ion-icon>
                    <span style="--i: 2"></span>
                </a>
            </li>
            <li class="link-item">
                <a href="#" class="link">
                    <img src="" alt="" />
                    <span style="--i: 9">
                        <h4></h4>
                        <p></p>
                    </span>
                </a>
            </li>
        </ul>
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



</script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>

</html>