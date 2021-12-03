<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$groepsnaam = sanitize($_POST["name"]);
$id = $_SESSION["id"];

if(!empty($groepsnaam)){
    $sql = "INSERT INTO `klas` (`klasnaam`)
                      VALUES ('$groepsnaam')";
    $creategroup = mysqli_query($conn, $sql);
    $query = mysqli_query($conn, "SELECT MAX(klas_id) as klas_id FROM klas"); 
    $row = mysqli_fetch_array($query);
    $klas_id = $row['klas_id'];
    $sql = "INSERT INTO `user_klas_koppel` (`userid`, `klas_id`)
                      VALUES ('$id', '$klas_id')";
    $creategroupteacher = mysqli_query($conn, $sql);
    $_SESSION["nieuwgroep"] = "success";
    header("Location: index.php?content=docentgroepen");
}
else {
    $_SESSION["nieuwgroep"] = "error1";
    header("Location: index.php?content=docentgroepen");
}