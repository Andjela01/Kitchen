<?php
require_once "../config/connection.php";
require_once "../includes/validation.php";

$allergenErr = "";
$allergen = "";
$validation = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $allergen = $_POST['allergen'];
}

if (allergen_validation($allergen, $conn)) {
      $allergenErr = allergen_validation($allergen, $conn);
      $validation = false;
}

if ($validation) {
      $q = "INSERT INTO `allergens` (`name`)
            VALUES ('$allergen')";
      if ($conn->query($q)) {
            echo "Allergen successfully added.";
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
      <title>Add allergen</title>
</head>

<body>
      <form method="POST">
            <p>
                  <label for="allergen">Allergen</label>
                  <input type="text" name="allergen" id="allergen">
                  <span><?php echo $allergenErr; ?></span>
            </p>
            <p>
                  <input type="submit" value="Add">
            </p>
      </form>
</body>

</html>