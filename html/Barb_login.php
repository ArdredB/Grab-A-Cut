<?php
session_start();

$no_credential = FALSE;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $dbconn = require "db.php";
    
    $uname = $_POST["Barb_Username"];
    $password = $_POST["Barb_Password"];
    
    $stmt = $dbconn->prepare("SELECT * FROM barber WHERE Barb_Username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        if (password_verify($password, $user["Barb_Password"])) {
            $_SESSION["Barb_Id"] = $user["Barb_Username"];
            header("Location: barber-page.html");
            exit;
        }
    }
    
    $no_credential = TRUE;
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
        <h1>Login</h1>

        <form method="post">
        <?php if ($no_credential): ?>
          <p style = "text-align: center;" >Invalid UserName or password</p>
        <?php endif; ?> 
          <div class="txt_field">
            <input type="text" name="Barb_Username">
            <span></span>
            <label>UserName</label>
          </div>
          <div class="txt_field">
            <input type="password" name="Barb_Password">
            <span></span>
            <label>Password</label>
          </div>
          <div class="pass">Forgot Password?</div>
          <input type="submit" value="Login">
          <div class="signup_link">
            Don't Have An Account? <a href="Barb_sign-up.php">Signup</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
