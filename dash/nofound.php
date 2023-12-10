<?php


// Create connection
$conn = new mysqli("localhost:3307", "root", "", "lost");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count rows in your table (replace 'lost_items' with your actual table name)
$sql = "SELECT COUNT(*) AS total_rows FROM founditem";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalRows = $row["total_rows"];

    // Display the count in an alert message using JavaScript
    echo "<script>alert('Total number of found items reported: " . $totalRows . "');
     window.history.back();
    </script>";
} else {
    echo "No rows found";
}

$conn->close();
?>