<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$name = $_POST["name"];
$code = $_POST['code'];
$wi = $_POST['id'];
$sql1 = "SELECT * FROM `woodklep` WHERE `wkcode` = $code AND `wk_id` = $wi";
$res1 = mysqli_query($conn,$sql1);
if (mysqli_num_rows($res1)>0) {
    $sql2 = "SELECT * FROM `wk_leerling_koppel` WHERE `wk_id` = $wi";
    $res2 = mysqli_query($conn, $sql2);
    if(!mysqli_num_rows($res2)) {
        $sql3 = "INSERT INTO `wk_leerling_koppel` VALUES ($wi, $id, '$name')";
        $res3 = mysqli_query($conn, $sql3);
        if($res3) {
            //Succesvol
            $_SESSION['nieuwwoodklep'] = 'success';
            header('Location: index.php?content=mywoodkleps');
        }
        else {
            //Er ging iets mis met de SQL Query
            $_SESSION['nieuwwoodklep'] = 'error3';
            header("Location: index.php?content=mywoodkleps");
        }
    }
    else {
        // Woodklep is al gekoppeld aan een andere gebruiker
        $_SESSION['nieuwwoodklep'] = 'error2';
        header("Location: index.php?content=mywoodkleps");
    }
}
else {
    // Woodklep bestaat niet
    $_SESSION['nieuwwoodklep'] = 'error1';
    header("Location: index.php?content=mywoodkleps");
}
?>