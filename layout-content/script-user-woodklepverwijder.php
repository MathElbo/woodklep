<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// Get info van formulier
$wkid = sanitize($_POST["wk"]);
$id = $_SESSION['id'];

$sql1 = "SELECT * FROM `wk_leerling_koppel` WHERE `wk_id` = $wkid";
$res1 = mysqli_query($conn,$sql1);
if(!empty($res1)) {
    $sql2 = "DELETE FROM `wk_leerling_koppel` WHERE `wk_id` = $wkid AND `leerlingid` = $id";
    $res2 = mysqli_query($conn,$sql2);
    if ($res2) {
        $_SESSION['woodklepverwijder'] = 'success';
        header('Location: index.php?content=mywoodkleps');
    }
    else {
        //Er ging iets mis met de SQL Query
        $_SESSION['woodklepverwijder'] = 'error2';
        header('Location: index.php?content=mywoodkleps');
    }
}
else {
    //Woodklep bestaat niet
    $_SESSION['woodklepverwijder'] = 'error1';
    header('Location: index.php?content=mywoodkleps&wk='.$wkid);
}