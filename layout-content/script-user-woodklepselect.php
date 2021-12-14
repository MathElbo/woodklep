<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

$woodklep = $_POST["woodklep"];


$sql = "INSERT INTO `woodklep_user_koppel`
(`woodklep_id`,`user_id`) VALUES ($woodklep, $id)";
$result = mysqli_query($conn, $sql);

if($result){
header("Location: index.php?content=studenthome");
}
?>