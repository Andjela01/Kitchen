<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "kitchen";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
      die("Neuspela konekcija:" . $conn->connect_error);
}