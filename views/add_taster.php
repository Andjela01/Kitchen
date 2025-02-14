<?php
require_once "../config/connection.php";
require_once "../includes/validation.php";

$q = "SELECT * FROM `allergens`";
$res = $conn->query($q);

$usernameErr = $passwordErr = "";
$username = $password = "";
$validation = true;



if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $allergens = isset($_POST['allergens']) ? $_POST['allergens'] : [];
}

if (username_validation($username, $conn)) {
      $usernameErr = username_validation($username, $conn);
      $validation = false;
}

if (password_validation($password)) {
      $passwordErr = password_validation($password);
      $validation = false;
}

if ($validation) {
      $pass_new = md5($password);
      $q = "INSERT INTO `taster`(`username`, `password`)
            VALUES ('$username', '$pass_new')";
      if ($conn->query($q)) {
            $taster_id = $conn->insert_id;

            if (!empty($allergens)) {
                  foreach ($allergens as $allergen_id) {
                        $q = "INSERT INTO `allergic`(`taster_id`, `allergen_id`)
                              VALUES ('$taster_id', '$allergen_id')";
                        $conn->query($q);
                  }
            }
            echo "Taster successfully added.";
      } else {
            echo "Error" . $conn->error;

      }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add taster</title>
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
                  <label for="allergens">Allergens:</label>
                  <?php while ($row = $res->fetch_assoc()): ?>
                        <input type="checkbox" name="allergens[]" value="<?= $row['id'] ?>" id="allergen_<?= $row['id'] ?>">
                        <label for="allergen_<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></label>
                  <?php endwhile; ?>
            </p>
            <p>
                  <input type="submit" value="Add">
            </p>
      </form>
</body>

</html>