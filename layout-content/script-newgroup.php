<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$groepsnaam = sanitize($_POST["name"]);
$id = $_SESSION["id"];

if(!empty($groepsnaam)){
    $sql = "INSERT INTO `klas` (`klas_id`,`klasnaam`)
                      VALUES ('$idgroup', '$groepsnaam')";
    $creategroup = mysqli_query($conn, $sql);
    $_SESSION["nieuwgroep"] = "success";
    header("Location: index.php?content=docentgroepen");
}
else {
    $_SESSION["nieuwgroep"] = "error1";
    header("Location: index.php?content=docentgroepen");
}