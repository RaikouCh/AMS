<?php 
include 'db.php';

$sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
$result = $conn->query($sql);

$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = [
        "id" => $row["id"],
        "title" => $row["title"],
        "message" => $row["message"],
        "priority" => $row["priority"],
        "time" => date("M d, Y h:i A", strtotime($row["date_posted"]))
    ];
}

header('Content-Type: application/json');
echo json_encode($announcements);
?>
