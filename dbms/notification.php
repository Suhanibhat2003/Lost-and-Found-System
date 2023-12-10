<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #AFEEEE;
        }

        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #AFEEEE;
            color: #fff;
        }

        h2 {
            text-align: center;
        }

        .no-records {
            text-align: center;
            color: red;
            margin-top: 20px;
        }
    </style>
    <title>Notification Log</title>
</head>

<body>
    <div class="table-container">
        <?php
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "lost";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch contents
        $sql = "SELECT * FROM notification_log";
        $result = $conn->query($sql);

        // Check if there are rows in the result set
        if ($result->num_rows > 0) {
            echo "<h2>Updates</h2>";
            echo "<table><tr><th>ID</th><th>Message</th><th>Created At</th></tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["message"] . "</td><td>" . $row["created_at"] . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<div class='no-records'>No records found</div>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>

</html>
