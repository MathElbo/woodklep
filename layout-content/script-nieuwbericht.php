<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

//formulier gegevens
$ontvanger = sanitize($_POST['ontvanger']);
$onderwerp = sanitize($_POST['onderwerp']);
$bericht = sanitize($_POST['bericht']);
$antw = $_POST['antw'];
$sql1 = "SELECT * FROM `woodklep_users` WHERE `username` = '$ontvanger'";
$res1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($res1)) {
    $rec1 = mysqli_fetch_array($res1);
    $ontvangerid = $rec1['userid'];
    if ($antw==='NULL') {
        $sql3 = "INSERT INTO `bericht` VALUES (NULL, $id, $ontvangerid, '$onderwerp', '$bericht', CURRENT_DATE(), NULL)";
        $res3 = mysqli_query($conn, $sql3);
    }
    else {
        $sql3 = "INSERT INTO `bericht` VALUES (NULL, $id, $ontvangerid, '$onderwerp', '$bericht', CURRENT_DATE(), $antw)";
        $res3 = mysqli_query($conn, $sql3);
    }
    if ($res3) {
        $sql2 = "INSERT INTO `bericht_status` VALUES (NULL, 0)";
        $res2 = mysqli_query($conn, $sql2);
        if ($res2) {
            $_SESSION['nieuwbericht'] = 'success';
            header("Location: index.php?content=mijnberichten&action=default");
        }
        //bericht is in database gezet
        else {
            $_SESSION['nieuwbericht'] = 'error2';
            header("Location: index.php?content=mijnberichten&action=default");
        }
    }
    else {
        //bericht is niet in database gezet
        $_SESSION['nieuwbericht'] = 'error2';
        header("Location: index.php?content=mijnberichten&action=default");
    }
}
else {
    //user does not exist
    $_SESSION['nieuwbericht'] = 'error1';
    header("Location: index.php?content=mijnberichten&action=default");
}
?>