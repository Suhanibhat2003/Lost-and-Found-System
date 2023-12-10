<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('bg14.jpg'); 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 230px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .item-card {
            border-radius: 10px;
            padding: 20px;
            background-color: #e1e1e1;
            background-image: url('bg14.jpg'); 
            background-size: cover;
            text-align: left;
            margin-bottom: 20px;
            font-size: 20px;
            color: black;
            font-family: Arial, sans-serif;
        }

        .item-card img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .claim-button {
            cursor: pointer;
            padding: 10px 20px;
            background: black;
            color: white;
            border-radius: 70px;
            width: 140px;
            border: none;
            margin: 20px auto 0;
            display: block;
            font-size: 18px;
        }

        .claim-button:hover {
            background: radial-gradient(rgb(43, 29, 4), white);
            width: 120px;
            transition: 0.5s;
            color: white;
        }

        .code-input {
            width: 30%;
            margin: 0 auto;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 80px;
            box-sizing: border-box;
            margin-top: 5px;
            text-align: center;
        }

        hr {
            margin-top: 20px;
            border: 0.5px solid #ddd;
        }
    </style>
    <title>Display Item Information</title>
</head>
<body>
    <div class="container">
<?php
$conn = new mysqli('localhost:3307','root','','lost'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select image paths from the database
$sql = "SELECT imageUpload FROM foundItem where itemName= '$itemName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $imagePath = $row['imageUpload'];
        echo '<img src="' . $imagePath . '" alt="Uploaded Image"><br>';
    }
} else {
    echo "0 results";
}

$conn->close();
?>
 </div>
</body>

</html>
