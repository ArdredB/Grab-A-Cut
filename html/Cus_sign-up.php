<?php

$incorrectpass = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fname = $_POST["Fname"];
    $Lname = $_POST["Lname"];
    $contact = $_POST["contact"];
    $uname = $_POST["uname"];
    $passwords = $_POST["passwords"];

    // Check if any fields are empty
    if (empty($Fname) || empty($Lname) || empty($contact) || empty($uname) || empty($passwords)) {
        echo "All fields are required";
        exit;
    }

    // Check if password meets requirements
    if (strlen($passwords) < 8 || !preg_match("/[a-z]/i", $passwords) || !preg_match("/[0-9]/", $passwords)) {
        $incorrectpass = TRUE;
    } else {
        $passwords = password_hash($passwords, PASSWORD_DEFAULT);

      $dbconn = require "db.php";

        $sql = "INSERT INTO customer (Cust_Firstname, Cust_Lastname, Cust_ContactNo, Cust_Username, Cust_Password)
            VALUES (?, ?, ?, ?, ?)";

        $stmt = $dbconn->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL error: " . $dbconn->error);
        }

        $stmt->bind_param("sssss", $Fname, $Lname, $contact, $uname, $passwords);

        try {
            if ($stmt->execute()) {
                header("Location: Cus_login.php");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Grab A Cut</title>
    <link rel="stylesheet" href="../css/login-signup.css">
</head>

<body>
    <div class="background-image">
        <div class="center">
            <h1>Sign-Up</h1>
            <form method="post">
                <div class="signup">
                    <div class="txt_field">
                        <input type="text" id="Fname" name="Fname" placeholder="First name" required>
                    </div>

                    <div class="txt_field">
                        <input type="text" id="Lname" name="Lname" placeholder="Last name" required>
                    </div>

                    <div class="txt_field">
                        <input type="text" id="contact" name="contact" placeholder="ContactNo." required>
                    </div>

                    <div class="txt_field">
                        <input type="text" id="uname" name="uname" placeholder="User name" required>
                    </div>

                    <div class="txt_field">
                        <?php if ($incorrectpass) : ?>
                            <em>Password must be at least 8 characters and have 1 letter and number</em>
                        <?php endif; ?>
                        <input type="password" id="passwords" name="passwords" placeholder="Password" required>
                    </div>
                    <div class="pass">Forgot Password?</div>
                    <input type="submit" value="Register">
                    <div class="signup_link">
                        Already have an account? <a href="Cus_login.php">Login</a>
                    </div>
            </form>
        </div>
    </div>

</body>

</html>
