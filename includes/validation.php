<?php

function allergen_validation($allergen, $conn)
{
      $q = "SELECT * FROM `allergens` WHERE `name` LIKE '$allergen'";
      $res = $conn->query($q);

      if (empty($allergen)) {
            return "Allergen field cannot be empty.";
      } else if ($res->num_rows > 0) {
            return "This allergen already exists.";
      } else if (!preg_match("/^[a-zA-Z ]+$/", $allergen)) {
            return "Allergen name can only contain letters and spaces.";
      } else {
            return false;
      }
}

function recipe_name_validation($recipe_name, $conn)
{

      $q = "SELECT * FROM `recipe` WHERE `name` LIKE '$recipe_name'";
      $res = $conn->query($q);

      if (empty($recipe_name)) {
            return "Recipe name cannot be empty!";
      } else if ($res->num_rows > 0) {
            return "This recipe already exists!";
      } else if (!preg_match("/^[a-zA-Z0-9\s]+$/", $recipe_name)) {
            return "Recipe name can only contain letters, numbers, and spaces.";
      } else {
            return false;
      }
}

function recipe_validation($recipe, $conn)
{
      if (empty($recipe)) {
            return "Recipe description cannot be empty!";
      } else {
            return false;
      }
}