<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$groepsnaam = sanitize($_POST["name"]);
$id = $_SESSION["id"];

if(!empty($groepsnaam)){
    $sql1 = "SELECT * FROM `klas` WHERE `klasnaam` = '$groepsnaam'";
    $res1 = mysqli_query($conn, $sql1);
    if(mysqli_num_rows($res1)>0) {
        $rec1 = mysqli_fetch_array($res1);
        $ki = $rec1['klas_id'];
        $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $ki AND `userid` = $id";
        $res2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($res2)>0) {
            $_SESSION['lidgroep'] = 'error2';
            header("Location: index.php?content=studentklassen");
            //Je zit al in deze klas
        }
        else {
            $sql3 = "INSERT INTO `user_klas_koppel` VALUES ($id, $ki)";
            $res3 = mysqli_query($conn, $sql3);
            if($res3) {
                $_SESSION["lidgroep"] = "success";
                header("Location: index.php?content=studentklassen");
            }
            else {
                $_SESSION['lidgroep'] = 'error3';
                header("Location: index.php?content=studentklassen");
                //Er ging iets mis met SQL Query
            }
        }
    }
    else {
        $_SESSION['lidgroep'] = 'error4';
        header("Location: index.php?content=studentklassen");
    }
}
else {
    $_SESSION["lidgroep"] = "error1";
    header("Location: index.php?content=studentklassen");
}