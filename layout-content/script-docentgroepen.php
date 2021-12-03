<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$groepid = sanitize($_POST["groep"]);
$id = $_SESSION["id"];

if(!empty($groepid)){
    $_SESSION["groepselect"] = "success";
    $_SESSION["groepid"] = $groepid;
    header("Location: index.php?content=docentgroepen");
}
else {
    $_SESSION["groepselect"] = "error1";
    header("Location: index.php?content=docentgroepen");
}
?>