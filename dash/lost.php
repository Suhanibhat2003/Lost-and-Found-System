<?php

  $Name = $_POST['Name'];
  $itemName = $_POST['itemName'];
  $description = $_POST['description'];
  $dateLost = $_POST['dateLost'];
  $contactInfo = $_POST['contactInfo'];

// Create connection
$con = new mysqli('localhost:3307','root','','lost'); 
// Check connection
if($con->connect_error){
    echo "$con->connect_error";
    die("Connection Failed : ". $con->connect_error);
  } else {
    $stmt = $con->prepare("insert into lostitem(Name, itemName, description, dateLost, contactInfo) values(?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $Name, $itemName, $description, $dateLost, $contactInfo);
    $execval = $stmt->execute();
    //echo $execval;
    //echo " Report acknowledged";
    $stmt->close();
    $con->close();


    if ($execval) {
        // Display a styled acknowledgment message if the insertion was successful
        echo '<html>
            <head>
                <title>Report Acknowledged</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f0f0f0;
                        text-align: center;
                    }
                    .acknowledgment {
                        font-size: 36px;
                        color: #4CAF50;
                        margin-top: 100px;
                    }
                </style>
            </head>
            <body>
                <div class="acknowledgment">
                    Report Acknowledged Successfully
                </div>
            </body>
            </html>';
    } else {
        echo "Error occurred while saving the report.";
    }
}
?>
 