<?php
/* Check Login form submitted */
if (isset($_POST['Submit'])) {
    /* Define username and associated password array */
    $logins = array('subhiksha' => 'subhiksha', 'suhani' => 'suhani');

    /* Check and assign submitted Username and Password to new variable */
    $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
    $Password = isset($_POST['Password']) ? $_POST['Password'] : '';

    /* Check Username and Password existence in the defined array */
    if (isset($logins[$Username]) && $logins[$Username] == $Password) {
        /* Success: redirect to Protected page */
        header("Location: notification.php");
        exit;
    } else {
        /* Unsuccessful attempt: Set error message */
        $msg = "<span style='color:red'>Invalid Login Details</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #AFEEEE;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #AFEEEE;
            color: #000000;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <title>Login Page</title>
</head>

<body>
    <div class="login-container">
        <form action="" method="post" name="Login_Form">
            <h3>Login</h3>
            <?php if (isset($msg)) { ?>
                <div class="error-message"><?php echo $msg; ?></div>
            <?php } ?>
            <label for="Username">Username:</label>
            <input type="text" id="Username" name="Username" required>

            <label for="Password">Password:</label>
            <input type="password" id="Password" name="Password" required>

            <button type="submit" name="Submit">Login</button>
        </form>
    </div>
</body>

</html>
