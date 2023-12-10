
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Claim Lost Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(236, 236, 254);
           
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 800px;
            background: rgb(235, 254, 235);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .item-card {
            border-radius: 10px;
            padding: 20px;
            background: rgb(251, 233, 233);
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
</head>
<body>
    <div class="container">
        <h2>Lost Items</h2>

        <?php
        $conn = new mysqli("localhost:3307", "root", "", "lost");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $claimantName = $_POST['Name'];
            $claimedItemName = $_POST['claimedItemName'];

            if (isset($_POST['claimButton'])) {
                $claimedItemId = $_POST['claimedItemId'];
                $enteredCode = $_POST['code'];

                $sqlValidateCode = "SELECT vcode FROM founditem WHERE fid = ?";
                $stmtValidateCode = $conn->prepare($sqlValidateCode);
                $stmtValidateCode->bind_param("i", $claimedItemId);
                $stmtValidateCode->execute();
                $stmtValidateCode->bind_result($actualCode);
                $stmtValidateCode->fetch();
                $stmtValidateCode->close();

                if ($enteredCode != $actualCode) {
                    echo "Error: Code validation failed. Please enter the correct code.";
                    exit();
                }

                $sqlDeleteFoundItem = "DELETE FROM founditem WHERE fid = $claimedItemId";
                $conn->query($sqlDeleteFoundItem);

                $sqlDeleteLostItem = "DELETE FROM lostitem WHERE id = $claimedItemId";
                $conn->query($sqlDeleteLostItem);

                $sqlInsertClaimedItem = "INSERT INTO claimeditem (Name, ItemName) 
                                         VALUES (?, ?)";
                $stmtInsertClaimedItem = $conn->prepare($sqlInsertClaimedItem);
                $stmtInsertClaimedItem->bind_param("ss", $claimantName, $claimedItemName);
                $stmtInsertClaimedItem->execute();
                $stmtInsertClaimedItem->close();

                echo "Item claimed successfully.";
            }

            $sqlSelect = "SELECT * FROM founditem WHERE itemName = '$claimedItemName'";
            $result = $conn->query($sqlSelect);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='item-card'>";
                    echo "Name: " . $row['Name'] . "<br>";
                    echo "Item Name: " . $row['itemName'] . "<br>";
                    echo "Description: " . $row['description'] . "<br>";
                    echo "Contact Info: " . $row['contactInfo'] . "<br>";
                    echo "<img src='" . $row['imageUpload'] . "' alt='Found Item Image'><br>";

                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='Name' value='$claimantName'>";
                    echo "<input type='hidden' name='claimedItemName' value='$claimedItemName'>";
                    echo "<input type='hidden' name='claimedItemId' value='" . $row['fid'] . "'>";
                    echo "<div style='text-align: center;'>Enter Code: <input type='text' name='code' class='code-input' required></div>";
                    echo "<input type='submit' name='claimButton' value='Claim' class='claim-button'>";
                    echo "</form>";

                    echo "<hr>";
                    echo "</div>";
                }
                $result->close();
            } else {
                echo "No found items for the specified item name.";
            }
        }

        $conn->close();
        ?>
    </div>
    <script>
        function confirmClaim() {
            return confirm("Are you sure you want to claim this item? This action will permanently delete the item from the found items list.");
        }
    </script>
</body>
</html>