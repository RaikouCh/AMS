<?
include 'db.php';

if (!isset($conn)) {
    die("Database connection error");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $id = $conn->real_escape_string($_POST['id']);
        echo "Received ID: " . $id . "<br>"; // Debugging output

        // Check if ID exists before deletion
        $check_query = "SELECT * FROM leasing WHERE id = '$id'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            $query = "DELETE FROM leasing WHERE id = '$id'";
            if ($conn->query($query)) {
                echo "Reservation deleted successfully.";
            } else {
                echo "Error deleting reservation: " . $conn->error;
            }
        } else {
            echo "ID not found in database.";
        }
    } else {
        echo "ID not received.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>