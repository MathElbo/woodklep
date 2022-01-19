<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$wk = sanitize($_POST['wk']);
$li = sanitize($_POST['li']);
$ki = sanitize($_POST['ki']);

if (isset($_POST['open'])) {
    $sql1 = "UPDATE `woodklep_status` SET `locked` = 1 WHERE `woodklep_id` = $wk";
    helloWorld();
    $res1 = mysqli_query($conn, $sql1);
    if ($res1) {
        $_SESSION['wkopendicht'] = 'success1';
        header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
    }
    else {
        $_SESSION['wkopendicht'] = 'error1';
        header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
    }
}
elseif (isset($_POST['close'])) {
    $sql1 = "UPDATE `woodklep_status` SET `locked` = 0 WHERE `woodklep_id` = $wk";
    $res1 = mysqli_query($conn, $sql1);
    if ($res1) {
        $_SESSION['wkopendicht'] = 'success2';
        header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
    }
    else {
        $_SESSION['wkopendicht'] = 'error2';
        header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
    }
}
else {
    $_SESSION['wkopendicht'] = 'error3';
    header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
}
?>