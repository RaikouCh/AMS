  <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

  // Database connection
  $conn = new mysqli('localhost', 'root', '', 'register');
  if ($conn->connect_error) {
      die('Connection failed: ' . $conn->connect_error);
  }

  // Handle CRUD Operations
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $roomName = $_POST['roomName'] ?? '';
      $personQuantity = $_POST['personQuantity'] ?? '';
      $price = $_POST['price'] ?? '';
      $roomType = $_POST['roomType'] ?? '';
      $status = $_POST['status'] ?? '';
      $amenities = $_POST['amenities'] ?? [];
      $id = $_POST['id'] ?? '';
      
      $image = '';
      if (!empty($_FILES['roomImage']['name'])) {
          $image = time() . "_" . $_FILES['roomImage']['name']; // Unique filename
          move_uploaded_file($_FILES['roomImage']['tmp_name'], "uploads/" . $image);
      }

      if (isset($_POST['addApartment'])) {
          $sql = "INSERT INTO apartments (room_name, person_quantity, price, room_type, status, image) VALUES (?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssisss", $roomName, $personQuantity, $price, $roomType, $status, $image);
          if ($stmt->execute()) {
              $apartment_id = $stmt->insert_id;
              foreach ($amenities as $amenity_id) {
                  $conn->query("INSERT INTO apartment_amenities (apartment_id, amenity_id) VALUES ('$apartment_id', '$amenity_id')");
              }
          }
      } elseif (isset($_POST['editApartment']) && !empty($id)) {
          $sql = $image ? 
              "UPDATE apartments SET room_name=?, person_quantity=?, price=?, room_type=?, status=?, image=? WHERE id=?" : 
              "UPDATE apartments SET room_name=?, person_quantity=?, price=?, room_type=?, status=? WHERE id=?";
          
          $stmt = $conn->prepare($sql);
          if ($image) {
              $stmt->bind_param("ssisssi", $roomName, $personQuantity, $price, $roomType, $status, $image, $id);
          } else {
              $stmt->bind_param("ssissi", $roomName, $personQuantity, $price, $roomType, $status, $id);
          }
          $stmt->execute();

          $conn->query("DELETE FROM apartment_amenities WHERE apartment_id='$id'");
          foreach ($amenities as $amenity_id) {
              $conn->query("INSERT INTO apartment_amenities (apartment_id, amenity_id) VALUES ('$id', '$amenity_id')");
          }
      } elseif (isset($_POST['deleteApartment']) && !empty($id)) {
          $conn->query("DELETE FROM apartments WHERE id='$id'");
          $conn->query("DELETE FROM apartment_amenities WHERE apartment_id='$id'");
      }
      echo "<script>window.location.href='apart.php';</script>";
      exit();
  }

  // Fetch all apartments
  $apartments = $conn->query("SELECT * FROM apartments");
  // Fetch all amenities
  $amenities = $conn->query("SELECT * FROM amenities");
  ?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900');

    :root {
  --primary-clr: #7522e6;
  --bg-clr: #f2f4f5;
  --white-bg: #fff;
  --dark-text-clr: #363b46;
  --light-text-clr: #fff;
  --hover-clr: #eae3fc;
  --transition-speed: 0.3s;
  --sidebar-width-collapsed: 80px;
  --sidebar-width-expanded: 260px;
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
  padding: 15px 10px;
  border-radius: 10px;
  overflow: hidden;
  transition: width var(--transition-speed) ease-in-out;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}

.container:hover {
  width: var(--sidebar-width-expanded);
  overflow-y: auto;
}

.container .logo {
  width: 100%;
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: var(--transition-speed);
}

.container .logo img {
  transition: transform var(--transition-speed);
  width: 50px;
}

.container:hover .logo {
  justify-content: center;
}

.container ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 8px;
  width: 100%;
  padding: 0;
}

.link-item a {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 16px;
  color: var(--dark-text-clr);
  white-space: nowrap;
  position: relative;
  transition: var(--transition-speed);
  width: 100%;
}

.link-item a:hover {
  background-color: var(--hover-clr);
  transform: scale(1.05);
}

.link-item.active a {
  background-color: var(--primary-clr);
  color: var(--light-text-clr);
}

.link-item ion-icon {
  font-size: 22px;
  transition: transform var(--transition-speed);
}

.link-item span {
  display: none;
  transition: opacity var(--transition-speed);
}

.container:hover .link-item a {
  justify-content: flex-start;
  padding-left: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.container:hover .link-item span {
  display: inline;
  opacity: 1;
}

.container .link-item a ion-icon {
  display: block;
}

.link-item img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

.link-item a .num-notification {
  position: absolute;
  top: 8px;
  right: 10px;
  font-size: 12px;
  font-weight: bold;
  color: var(--white-bg);
  background-color: var(--primary-clr);
  min-width: 20px;
  height: 20px;
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
}

.container:hover + .content {
  margin-left: var(--sidebar-width-expanded);
  width: calc(100% - var(--sidebar-width-expanded));
}

/* Table Styling */
.table {
  width: 90%;
  margin: 20px auto;
  border-collapse: collapse;
  background: white;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  overflow: hidden;
}

.table th, .table td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

.table th {
  background: var(--primary-clr);
  color: var(--light-text-clr);
}

.table tr:nth-child(even) {
  background: #f9f9f9;
}

/* Buttons Styling */
.btn {
  padding: 10px 14px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  margin: 5px;
  transition: var(--transition-speed);
}

.btn:hover {
  transform: scale(1.05);
}

.btn-success { background: #28a745; color: white; }
.btn-warning { background: #ffc107; color: black; }
.btn-danger { background: #dc3545; color: white; }
.btn-primary { background: #007bff; color: white; }
.btn-secondary { background: #6c757d; color: white; }
.btn-secondary:hover { background: #5a6268; }

/* Modal Styling */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
}

.modal form {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
  max-height: 80vh;
  overflow-y: auto;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
  text-align: left;
}

.modal label {
  font-weight: bold;
  display: block;
  margin: 10px 0 5px;
}

.modal input, .modal select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Management</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script defer src="script.js"></script>
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
            <li class="link-item active">
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
<h1>Apartment Management</h1>

<button class="btn btn-success" id="addApartmentBtn">Add Apartment</button>

<table class="table">
    <thead>
        <tr>
            <th>Room</th>
            <th>Persons</th>
            <th>Price</th>
            <th>Type</th>
            <th>Status</th>
            <th>Amenities</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $apartments->fetch_assoc()) { ?>
            <tr>
                <td><img src="uploads/<?php echo $row['image']; ?>" style="width:50px;height:50px;"> <?php echo $row['room_name']; ?></td>
                <td><?php echo $row['person_quantity']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['room_type']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php
                    $id = $row['id'];
                    $apartment_amenities = $conn->query("SELECT name FROM amenities INNER JOIN apartment_amenities ON amenities.id = apartment_amenities.amenity_id WHERE apartment_id='$id'");
                    while ($a = $apartment_amenities->fetch_assoc()) echo $a['name'] . ', ';
                    ?>
                </td>
                <td>
                    <button class="btn btn-warning edit-btn" data-id="<?php echo $row['id']; ?>">Edit</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="deleteApartment" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="modal" id="apartmentModal" style="display:none;">
    <form id="apartmentForm" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="apartmentId">
        <label>Room Name</label>
        <input type="text" name="roomName" required>
        <label>Image</label>
        <input type="file" name="roomImage" accept="image/*">
        <label>Person Quantity</label>
        <input type="text" name="personQuantity" required>
        <label>Price</label>
        <input type="text" name="price" required>
        <label>Room Type</label>
        <input type="text" name="roomType" required>
        <label>Status</label>
        <select name="status">
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
            <option value="Under Maintenance">Under Maintenance</option>
        </select>
        <label>Amenities</label>
        <div>
            <?php while ($a = $amenities->fetch_assoc()) { ?>
                <input type="checkbox" name="amenities[]" value="<?php echo $a['id']; ?>"> <?php echo $a['name']; ?><br>
            <?php } ?>
        </div>
        <div class="modal-buttons">
            <button type="submit" name="addApartment" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
        </div>
    </form>
</div>


<script>
document.getElementById("addApartmentBtn").addEventListener("click", function() {
    document.getElementById("apartmentForm").reset();
    document.getElementById("apartmentModal").style.display = "block";
});
document.querySelectorAll(".edit-btn").forEach(btn => {
    btn.addEventListener("click", function() {
        document.getElementById("apartmentId").value = this.dataset.id;
        document.getElementById("apartmentModal").style.display = "block";
    });
});

// Get elements
const modal = document.getElementById("apartmentModal");
const cancelBtn = document.getElementById("cancelModal");

// Function to close the modal
function closeModal() {
    modal.style.display = "none";
}

// Event listener for the Cancel button
cancelBtn.addEventListener("click", closeModal);

</script>

</body>
</html>
