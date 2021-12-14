<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// Get info van formulier
$studentid = sanitize($_POST["student"]);
$id = $_SESSION['id'];
$ki = sanitize($_POST['ki']);

$sql1 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $ki AND `userid` = $studentid";
$res1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($res1) == 1){
    $sql2 = "DELETE FROM `user_klas_koppel` WHERE `klas_id` = $ki AND `userid` = $studentid";
    $res2 = mysqli_query($conn,$sql2);
    if($res2) {
        // echo "Leerling is verwijderd"
        header ("Location: index.php?content=editklas&ki=$ki");
        $_SESSION['leerlingverwijder'] = 'success';
    }
    else {
        // echo "Er ging iets mis met de SQL Query"
        header("Location: index.php?content=editklas&ki=$ki");
        $_SESSION['leerlingverwijder'] = "error2";
    }
}
else {
    //echo "Leerling zit niet in de klas"
    header("Location: index.php?content=editklas&ki=$ki");
    $_SESSION['leerlingverwijder'] = 'error1';
}
?>