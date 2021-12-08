<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// Get info van formulier
$nieuwgroepsnaam = sanitize($_POST["name"]);
$id = $_SESSION['id'];
$ki = sanitize($_POST['ki']);

$sql1 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
$res1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($res1) == 1){
    $rec1 = mysqli_fetch_array($res1);
    $sql2 = "UPDATE `klas` SET `klasnaam` = '$nieuwgroepsnaam' WHERE `klas_id` = 1;";
    $res2 = mysqli_query($conn, $sql2);
    if ($res2) {
        //echo "Groepsnaam is succesvol gewijzigd"
        header("Location: index.php?content=editklas&ki=$ki");
        $_SESSION['namechange'] = 'success';
    }
    else {
        //echo "Er ging iets mis met de SQL Query"
        header("Location: index.php?content=editklas&ki=$ki");
        $_SESSION['namechange'] = 'error1';
    }
}
else {
    //echo "klas bestaat niet in database"
    header("Location: index.php?content=editklas&ki=$ki");
    $_SESSION['namechange'] = 'error3';
}
?>