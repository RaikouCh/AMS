<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// DELETE Announcement
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM announcements WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: announced.php");
    exit();
}

// ADD or UPDATE Announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title']);
    $message = trim($_POST['message']);
    $priority = trim($_POST['priority']);

    if (!empty($title) && !empty($message) && !empty($priority)) {
        if ($id) {
            $stmt = $conn->prepare("UPDATE announcements SET title=?, message=?, priority=? WHERE id=?");
            $stmt->bind_param("sssi", $title, $message, $priority, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO announcements (title, message, priority) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $message, $priority);
        }
        $stmt->execute();
        $stmt->close();

        // Example tenant (for notification purposes)
        $tenants = [
            [
                "name"  => "Nathaniel Lasquety",
                "email" => "nathaniellasquety2024@gmail.com",
                "phone" => "+639081613490"
            ]
        ];
        $tenants_json = json_encode($tenants, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Call the Python script for notifications
        $python_script = "C:\\xampp\\htdocs\\amswebsite\\send_notifications.py";
        $command = escapeshellcmd("python \"$python_script\" \"$title\" \"$message\" '$tenants_json'");
        shell_exec($command);

        echo "success";
        exit();
    } else {
        echo "error: Missing required fields.";
        exit();
    }
}

// FETCH Announcements
$sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
$result = $conn->query($sql);
$announcements = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

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
  --green-btn: #28a745;
  --green-hover: #5cb85c;
  --blue-btn: #007bff;
  --blue-hover: #5bc0de;
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

/* Sidebar */
.container {
  width: var(--sidebar-width-collapsed);
  height: 100vh;
  background: var(--white-bg);
  padding: 10px 0px;
  border-radius: 10px;
  overflow-y: auto;
  transition: width var(--transition-speed);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
}

.container:hover {
  width: var(--sidebar-width-expanded);
}

/* Sidebar Menu */
.container ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: 100%;
  padding: 0;
}

.link-item {
  width: 100%;
}

.link-item a {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 16px;
  color: var(--dark-text-clr);
  white-space: nowrap;
  transition: background var(--transition-speed);
  position: relative;
  overflow: hidden;
}

.link-item a img {
  width: 45px;
  height: 45px;
  object-fit: cover;
  border-radius: 50%;
}

.link-item span {
  display: flex;
  flex-direction: column;
  justify-content: center;
  visibility: visible;
  opacity: 1;
  white-space: nowrap;
}

.link-item span h4 {
  font-size: 14px;
  font-weight: bold;
  margin: 0;
  color: var(--dark-text-clr);
}

.link-item span p {
  font-size: 12px;
  margin: 0;
  color: gray;
}

.link-item a:hover {
  background-color: var(--hover-clr);
}

.link-item.active a {
  background-color: var(--primary-clr);
  color: var(--light-text-clr);
}

/* Sidebar Icons */
.link-item ion-icon {
  font-size: 28px;
  min-width: 32px;
  transition: transform var(--transition-speed);
  position: relative;
  color: var(--dark-text-clr);
}

/* Ensure text is only visible on hover */
.link-item span {
  opacity: 0;
  transition: opacity var(--transition-speed);
  margin-left: 10px;
  display: inline-block;
  visibility: hidden;
}

.container:hover .link-item span {
  opacity: 1;
  visibility: visible;
}

/* Adjust alignment when hovered */
.container:hover .link-item a {
  justify-content: flex-start;
  padding-left: 20px;
}

.container:hover .link-item ion-icon {
  margin-right: 15px;
}

/* Notification Badge */
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

/* Content */
.content {
  margin-left: var(--sidebar-width-collapsed);
  padding: 20px;
  width: calc(100% - var(--sidebar-width-collapsed));
  transition: margin-left var(--transition-speed), width var(--transition-speed);
  background: var(--bg-clr);
  color: var(--dark-text-clr);
  height: 100vh;
  overflow-y: auto;
}

.container:hover + .content {
  margin-left: var(--sidebar-width-expanded);
  width: calc(100% - var(--sidebar-width-expanded));
}

/* Announcement Section */
.announcement {
  background: var(--white-bg);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  max-height: 400px;
  overflow-y: auto;
}

.announcement table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.announcement th, .announcement td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.announcement th {
  background-color: var(--primary-clr);
  color: var(--light-text-clr);
}

/* Priority Colors */
.announcement .priority.high {
  color: red;
  font-weight: bold;
}

.announcement .priority.medium {
  color: orange;
}

.announcement .priority.low {
  color: green;
}

/* Buttons */
button, .delete-btn {
  padding: 8px 12px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: background var(--transition-speed);
}

button {
  background-color: var(--primary-clr);
  color: var(--light-text-clr);
}

button:hover {
  background-color: #5e1ab6;
}

/* Add Announcement Button */
.add-btn {
  background-color: var(--green-btn);
  color: var(--light-text-clr);
}

.add-btn:hover {
  background-color: var(--green-hover);
}

/* Edit Announcement Button */
.edit-btn {
  background-color: var(--blue-btn);
  color: var(--light-text-clr);
}

.edit-btn:hover {
  background-color: var(--blue-hover);
}

/* Delete Button */
.delete-btn {
  background-color: red;
  color: white;
}

.delete-btn:hover {
  background-color: darkred;
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: var(--white-bg);
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}

.modal input, .modal textarea, .modal select {
  width: 100%;
  margin: 10px 0;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.modal button {
  width: 100%;
}

.close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  cursor: pointer;
}



</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

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
            <li class="link-item active">
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
    <h2>Announcements</h2>
        <div class="announcement">
        <button id="addBtn">Add Announcement</button>
        <table class="announcementList table">
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>Priority</th>
                <th>Date Posted</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($announcements as $announcement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($announcement['title']); ?></td>
                    <td><?php echo htmlspecialchars($announcement['message']); ?></td>
                    <td class="priority <?php echo strtolower($announcement['priority']); ?>">
                        <?php echo htmlspecialchars($announcement['priority']); ?>
                    </td>
                    <td><?php echo date("M d, Y h:i A", strtotime($announcement['date_posted'])); ?></td>
                    <td>
                        <button class="edit-btn btn" 
                                data-id="<?php echo $announcement['id']; ?>" 
                                data-title="<?php echo htmlspecialchars($announcement['title']); ?>" 
                                data-message="<?php echo htmlspecialchars($announcement['message']); ?>" 
                                data-priority="<?php echo htmlspecialchars($announcement['priority']); ?>">
                            Edit
                        </button>
                        <a href="announced.php?delete=<?php echo $announcement['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
    
    <!-- Edit Announcement Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add Announcement</h2>
            <form id="editForm">
                <input type="hidden" name="id" id="edit-id">
                <input type="text" name="title" id="edit-title" placeholder="Title" required>
                <textarea name="message" id="edit-message" placeholder="Message" required></textarea>
                <select name="priority" id="edit-priority">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
                <button type="submit">Save</button>
            </form>
        </div>
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

$(document).ready(function() {
    const modal = $("#editModal");
    const modalTitle = $("#modalTitle");
    const closeModal = $(".close");

    // Prevent flickering by ensuring the page is hidden before fading in
    $("body").hide().fadeIn(300);
    modal.hide();

    // Open modal for adding an announcement
    $("#addBtn").on("click", function() {
        $("#edit-id").val("");
        $("#edit-title").val("");
        $("#edit-message").val("");
        $("#edit-priority").val("Medium");
        modalTitle.text("Add Announcement");
        modal.fadeIn(300);
    });

    // Open modal for editing an announcement
    $(document).on("click", ".edit-btn", function() {
        $("#edit-id").val($(this).data("id"));
        $("#edit-title").val($(this).data("title"));
        $("#edit-message").val($(this).data("message"));
        $("#edit-priority").val($(this).data("priority"));
        modalTitle.text("Edit Announcement");
        modal.fadeIn(300);
    });

    // Close modal when clicking the close button
    closeModal.on("click", function() {
        modal.fadeOut(300);
    });

    // Close modal when clicking outside content
    $(window).on("click", function(e) {
        if ($(e.target).is(modal)) {
            modal.fadeOut(300);
        }
    });

    // Handle form submission via AJAX
    $("#editForm").on("submit", function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.post("announced.php", formData, function(response) {
            if ($.trim(response) === "success") {
                alert("Announcement saved successfully!");
                modal.fadeOut(300, function() {
                    $("body").fadeOut(300, function() {
                        location.reload();
                    });
                });
            } else {
                alert("Error saving announcement.");
            }
        }).fail(function() {
            alert("An error occurred while processing your request.");
        });
    });
});
    </script>
</body>
</html>
