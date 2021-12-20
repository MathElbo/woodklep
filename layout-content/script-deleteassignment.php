<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$id = $_SESSION["id"];
$oi = sanitize($_POST['oi']);
$ki = sanitize($_POST['ki']);

$sql1 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $oi";
$res1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($res1)>0) {
    $sql2 = "SELECT * FROM `wk_leerling_koppel` WHERE `wkopdracht` = $oi";
    $res2 = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($res2)) {
        $sql3 = "UPDATE `wk_leerling_koppel` SET `wkopdracht` = NULL WHERE `wkopdracht` = $oi";
        $res3 = mysqli_query($conn, $sql3);
    }
    $teller = 0;
    $sql4 = "DELETE FROM `student_opdracht_voortgang` WHERE `opdracht_id` = $oi";
    $res4 = mysqli_query($conn, $sql4);
    if($res4){
        $teller = $teller + 1;
    }
    $sql5 = "DELETE FROM `hw_klas_koppel` WHERE `opdracht_id` = $oi";
    $res5 = mysqli_query($conn, $sql5);
    if ($res5) {
        $teller = $teller + 1;
    }
    $sql6 = "DELETE FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $oi";
    $res6 = mysqli_query($conn, $sql6);
    if (res6) {
        $teller = $teller + 1;
    }
    $sql7 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $oi";
    $vraagteller = 0;
    $res7 = mysqli_query($conn, $sql7);
    while ($rec7 = mysqli_fetch_array($res7)){
        $vraagid = $rec7['vraag_id'];
        $sql8 = "DELETE FROM `student_antwoord` WHERE `vraag_id` = $vraagid";
        $res8 = mysqli_query($conn, $sql8);
        if($res8){
            $vraagteller = $vraagteller + 1;
        }
        $sql9 = "DELETE FROM `huiswerk_vraag` WHERE `vraag_id` = $vraagid";
        $res9 = mysqli_query($conn, $sql9);
        if ($res9){
            $vraagteller = $vraagteller + 1;
        }
        $sql10 = "DELETE FROM `opdrachtvraag_koppel` WHERE `vraag_id` = $vraagid";
        $res10 = mysqli_query($conn, $sql10);
        if ($res10) {
            $vraagteller = $vraagteller + 1;
        }
    }
    }
}
else {
    //Opdracht bestaat niet
    $_SESSION['verwijderassignment'] = 'error1';
    header("Location: index.php?content=changeassignements&ki=$ki");
}