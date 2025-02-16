<?php
session_start();
require_once "../config/connection.php";

if (!isset($_SESSION['id'])) {
      header("Location: login.php");
      exit;
}

$taster_id = $_SESSION['id'];

$q = "SELECT allergen_id FROM allergic WHERE taster_id = $taster_id";
$res = $conn->query($q);

$allergic_allergen_ids = [];
while ($row = $res->fetch_assoc()) {
      $allergic_allergen_ids[] = $row['allergen_id'];
}

$allergic_allergen_ids_str = implode(",", $allergic_allergen_ids);
if (empty($allergic_allergen_ids)) {
      $allergic_allergen_ids_str = "NULL";
}

$q = "SELECT r.id, r.name, r.text
      FROM recipe r
      WHERE r.id NOT IN (
          SELECT rh.recipe_id
          FROM recipe_has_allergens rh
          WHERE rh.allergen_id IN ($allergic_allergen_ids_str)
      )";

$res = $conn->query($q);
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Recipes Without Allergens</title>
</head>

<body>
      <a href="logout.php">Logout</a>

      <h2>Recipes Safe for You</h2>

      <?php while ($row = $res->fetch_assoc()): ?>
            <div>
                  <h3><?= htmlspecialchars($row['name']) ?></h3>
                  <p><?= nl2br(htmlspecialchars($row['text'])) ?></p>

                  <p><strong>Allergens:</strong>
                        <?php
                        $recipe_id = $row['id'];
                        $q_allergens = "SELECT a.name 
                                FROM allergens a
                                JOIN recipe_has_allergens rh ON a.id = rh.allergen_id
                                WHERE rh.recipe_id = $recipe_id";
                        $res_allergens = $conn->query($q_allergens);

                        $allergens_list = [];
                        while ($allergen = $res_allergens->fetch_assoc()) {
                              $allergens_list[] = htmlspecialchars($allergen['name']);
                        }
                        echo empty($allergens_list) ? "No allergens" : implode(", ", $allergens_list);
                        ?>
                  </p>
            </div>
            <hr>
      <?php endwhile; ?>

</body>

</html>