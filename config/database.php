<?php

require_once "connection.php";

$sql = "CREATE TABLE  IF NOT EXISTS recipe(
    id INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    PRIMARY KEY(ID)
)ENGINE = InnoDB;";

$sql .= "CREATE TABLE IF NOT EXISTS allergens(
    id INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
)ENGINE = InnoDB;";

$sql .= "CREATE TABLE IF NOT EXISTS recipe_has_allergens(
    id INT AUTO_INCREMENT,
    recipe_id INT NOT NULL,
    allergen_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(recipe_id) REFERENCES recipe(id) ON DELETE CASCADE,
    FOREIGN KEY(allergen_id) REFERENCES allergens(id) ON DELETE CASCADE
)ENGINE = InnoDB;";

$sql .= "CREATE TABLE IF NOT EXISTS taster(
    id INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password TEXT NOT NULL,
    PRIMARY KEY(id)
)ENGINE = InnoDB;";

$sql .= "CREATE TABLE IF NOT EXISTS allergic(
    id INT AUTO_INCREMENT,
    taster_id INT NOT NULL,
    allergen_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(taster_id) REFERENCES taster(id) ON DELETE CASCADE,
    FOREIGN KEY(allergen_id) REFERENCES allergens(id) ON DELETE CASCADE
)ENGINE = InnoDB;";

if ($conn->multi_query($sql)) {
      echo "Tables created successfully";
}