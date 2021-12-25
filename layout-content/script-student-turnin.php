<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

$assignmentid = $_GET['aid'];

$sql1 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $assignmentid";
$res1 = mysqli_query($conn, $sql1);
$aantalvragen = mysqli_num_rows($res1);
$teller1 = 0;
while ($rec1 = mysqli_fetch_array($res1)) {
    $vi = $rec1['vraag_id'];
    $studentantwoord = $_POST[$vi];
    $sql2 = "SELECT * FROM `student_antwoord` WHERE `studentid` = $id AND `vraag_id` = $vi";
    $res2 = mysqli_query($conn, $sql2);
    if (!mysqli_num_rows($res2)) {
        $sql3 = "INSERT INTO `student_antwoord` VALUES ($id,$vi,'$studentantwoord')";
        $res3 = mysqli_query($conn, $sql3);
        if ($res3) {
            $teller1++;
        }
    }
    else {
        $sql4 = "UPDATE `student_antwoord` SET `antwoord` = '$studentantwoord' WHERE `studentid` = $id AND `vraag_id` = $vi";
        $res4 = mysqli_query($conn, $sql4);
        if ($res4) {
            $teller1++;
        }
    }
}
if ($teller1 == $aantalvragen) {
    $sql5 = "SELECT * FROM `student_opdracht_voortgang` WHERE `studentid` = $id AND `opdracht_id` = $assignmentid";
    $res5 = mysqli_query($conn, $sql5);
    if (!mysqli_num_rows($res5)) {
        $sql6 = "INSERT INTO `student_opdracht_voortgang` VALUES (NULL, $id, $assignmentid, 1)";
        $res6 = mysqli_query($conn, $sql6);
        if($res6) {
            $sql8 = "SELECT * FROM `wk_leerling_koppel` WHERE `wkopdracht` = $assignmentid AND `leerlingid` = $id";
            $res8 = mysqli_query($conn, $sql8);
            $aantalwoodkleps = mysqli_num_rows($res8);
            $teller2 = 0;
            while ($rec8 = mysqli_fetch_array($res8)) {
                $wi = $rec8['wk_id'];
                $sql9 = "UPDATE `woodklep_status` SET `locked` = 1 WHERE `woodklep_id` = $wi";
                $res9 = mysqli_query($conn, $sql9);
                if ($res9) {
                    $teller2++;
                }
            }
            if ($teller2 == $aantalwoodkleps) {
                $_SESSION['turnin'] = 'success';
            }
            else {
                //Fout bij updaten woodklepstatus
                $_SESSION['turnin'] = 'error3';
            }
        }
        else {
            //Fout bij opdrachtvoortgang aanpassen
            $_SESSION['turnin'] = 'error2';
        }
    }
    else {
        $sql7 = "UPDATE `student_opdracht_voortgang` SET `gemaakt` = 1 WHERE `studentid` = $id AND `opdracht_id` = $assignmentid";
        $res7 = mysqli_query($conn, $sql7);
        if ($res7) {
            $sql8 = "SELECT * FROM `wk_leerling_koppel` WHERE `wkopdracht` = $assignmentid AND `leerlingid` = $id";
            $res8 = mysqli_query($conn, $sql8);
            $aantalwoodkleps = mysqli_num_rows($res8);
            $teller2 = 0;
            while ($rec8 = mysqli_fetch_array($res8)) {
                $wi = $rec8['wk_id'];
                $sql9 = "UPDATE `woodklep_status` SET `locked` = 1 WHERE `woodklep_id` = $wi";
                $res9 = mysqli_query($conn, $sql9);
                if ($res9) {
                    $teller2++;
                }
            }
            if ($teller2 == $aantalwoodkleps) {
                $_SESSION['turnin'] = 'success';
            }
            else {
                //Fout bij updaten woodklepstatus
                $_SESSION['turnin'] = 'error3';
            }
        }
        else {
            //Fout bij opdrachtvoortgang aanpassen
            $_SESSION['turnin'] = 'error2';
        }
    }
}
else {
    $_SESSION['turnin'] = 'error1';
}


header("Location: index.php?content=myassignment&aid=$assignmentid");
?>