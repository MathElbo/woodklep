<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// Get info van formulier
$nieuwestudent = sanitize($_POST["name"]);
$id = $_SESSION['id'];
$ki = sanitize($_POST['ki']);

$sql1 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
$res1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($res1) == 1){
    $sql2 = "SELECT * FROM `woodklep_users` WHERE `username` = '$nieuwestudent' AND `userroleid` = 1";
    $res2 = mysqli_query($conn,$sql2);
    if(mysqli_num_rows($res)>0) {
        //User does not exist or is not a student
        header("Location: index.php?content=editklas&ki=$ki");
        $_SESSION['leerlingtoevoeg'] = 'error4';
    }
    else {
        $rec2 = mysqli_fetch_array($res2);
        $userid = $rec2['userid'];
        $sql3 = "SELECT * FROM `user_klas_koppel` WHERE `userid` = $userid AND `klas_id` = $ki";
        $res3 = mysqli_query($conn, $sql3);
        if(!mysqli_num_rows($res3)) {
            $sql4 = "INSERT INTO `user_klas_koppel` (`userid`, `klas_id`) VALUES ($userid, $ki)";
            $res4 = mysqli_query($conn, $sql4);
            if($res4) {
                $_SESSION['leerlingtoevoeg'] = "success";
                header("Location: index.php?content=editklas&ki=$ki");
            }
            else {
                //Er gaat iets mis in SQL query
                $_SESSION['leerlingtoevoeg'] = 'error1';
                header("Location: index.php?content=editklas&ki=$ki");
            }
        }
        else {
            //Leerling zit al in de klas
            $_SESSION['leerlingtoevoeg'] = 'error2';
            header("Location: index.php?content=editklas&ki=$ki");
        }
    }
}
else {
    //echo "klas bestaat niet in database"
    header("Location: index.php?content=editklas&ki=$ki");
    $_SESSION['leerlingtoevoeg'] = 'error3';
}
?>