<?php
session_start();

require_once "../config/connection.php";

$usernameErr = $passwordErr = "";
$set = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
      $set = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $set) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $validation = true;

      if (empty($username)) {
            $usernameErr = "Username field cannot be empty.";
            $validation = false;
      }

      if (empty($password)) {
            $passwordErr = "Password field cannot be empty.";
            $validation = false;
      }

      if ($validation) {
            $q = "SELECT * FROM `taster` WHERE `username` = '$username';";
            $res = $conn->query($q);

            if ($res->num_rows == 0) {
                  echo "Non-existent user.";
            } else {
                  $row = $res->fetch_assoc();
                  $dbPass = $row['password'];
                  if ($dbPass == md5($password)) {
                        $_SESSION['id'] = $row['id'];
                        header('Location:filter_by_allergens.php');
                  } else {
                        $passwordErr = "Incorrect password";
                  }
            }
      }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
</head>

<body>
      <form action="" method="POST">
            <p>
                  <label for="username">Username:</label>
                  <input type="text" name="username" id="username">
                  <span><?php echo $usernameErr; ?></span>
            </p>
            <p>
                  <label for="password">Password:</label>
                  <input type="password" name="password" id="password">
                  <span><?php echo $passwordErr; ?></span>
            </p>
            <p>
                  <input type="submit" value="Login">
            </p>
      </form>
</body>

</html>