<?php
require_once "../config/connection.php";
require_once "../includes/validation.php";

$q = "SELECT * FROM `allergens`";
$res = $conn->query($q);

$recipe_nameErr = $recipeErr = "";
$recipe_name = $recipe = "";
$validation = true;

$allergens = isset($_POST['allergens']) ? $_POST['allergens'] : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $recipe_name = $_POST['recipe_name'];
      $recipe = $_POST['recipe'];
}

if (recipe_name_validation($recipe_name, $conn)) {
      $recipe_nameErr = recipe_name_validation($recipe_name, $conn);
      $validation = false;
}

if (recipe_validation($recipe, $conn)) {
      $recipeErr = recipe_validation($recipe, $conn);
      $validation = false;
}

if ($validation) {
      $q = "INSERT INTO `recipe`(`name`, `text`)
            VALUES ('$recipe_name', '$recipe')";
      if ($conn->query($q)) {
            $recipe_id = $conn->insert_id;

            if (!empty($allergens)) {
                  foreach ($allergens as $allergen_id) {
                        $q = "INSERT INTO `recipe_has_allergens`(`recipe_id`, `allergen_id`)
                              VALUES ('$recipe_id', $allergen_id)";
                        $conn->query($q);
                  }
            }
            echo "Recipe successfully added.";
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
      <title>Add recipes</title>
</head>

<body>
      <form action="" method="POST">
            <p>
                  <label for="recipe_name">Recipe name:</label>
                  <input type="text" name="recipe_name" id="recipe_name">
                  <span><?php echo $recipe_nameErr; ?></span>
            </p>
            <p>
                  <label for="recipe">Recipe</label>
                  <textarea name="recipe" id="recipe"></textarea>
                  <span><?php echo $recipeErr; ?></span>
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