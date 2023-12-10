<?php

// Create connection
$conn = new mysqli('localhost:3307','root','','lost'); 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

  $Name = $_POST['Name'];
  $itemName = $_POST['itemName'];
  $description = $_POST['description'];
  $contactInfo = $_POST['contactInfo'];
  $vcode=$_POST['vcode'];

// File upload handling
$targetDirectory = "uploads/"; // Directory where images will be stored
$targetFile = $targetDirectory . basename($_FILES["imageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the file is an actual image
$check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Upload the file
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile)) {
        // File uploaded successfully, now insert data into database
        $filePath = $targetDirectory . basename($_FILES["imageUpload"]["name"]);

        // SQL query to insert data into the database
        $sql = "INSERT INTO founditem (Name,itemName, description, imageUpload,contactInfo,vcode) VALUES ('$Name','$itemName', '$description', '$filePath','$contactInfo','$vcode')";

        if ($conn->query($sql) === TRUE) {
           include("image.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

//$conn->close();
?>