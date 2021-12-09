<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$opdrachtid = sanitize($_POST["opdracht"]);
$id = $_SESSION['id'];
$ki = sanitize($_POST['ki']);

if(!empty($opdrachtid)){
    $_SESSION["opdrachtselect"] = "success";
    $_SESSION['opdrachtid'] = $opdrachtid;
    header("Location: index.php?content=changeassignements&ki=$ki");
}
else {
    $_SESSION["opdrachtselect"] = "error1";
    header("Location: index.php?content=changeassignements&ki=$ki");
}
?>