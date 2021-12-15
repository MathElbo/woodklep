<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

$klas = $_POST["klas"];


$sql = "INSERT INTO `user_klas_koppel`
(`userid`,`klas_id`) VALUES ($id, $klas)";
$result = mysqli_query($conn, $sql);

header("Location: index.php?content=studenthome");
?>