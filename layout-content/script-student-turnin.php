<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$sql13 = "SELECT * FROM `woodklep_users` WHERE `userid` = $id";
$res13 = mysqli_query($conn, $sql13);
$rec13 = mysqli_fetch_array($res13);
$sql14 = "SELECT * FROM `woodklep_personalinfo WHERE `userid` = $id";
$res14 = mysqli_query($conn, $sql14);
$rec14 = mysqli_fetch_array($res14);
if ($rec14['name']==='' | is_null($rec14['name'])) {
    $name = $rec13['username'];
}
else {
    $name = $rec14['name']." ".$rec14['infix']." ".$rec14['lastname'];
}

$assignmentid = $_GET['aid'];
$sql16 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $assignmentid";
$res16 = mysqli_query($conn, $sql16);
$rec16 = mysqli_fetch_array($res16);
$opdrachtnaam = $rec16['opdracht_naam'];

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
                helloWorld();
                if ($res9) {
                    $teller2++;
                }
            }
            if ($teller2 == $aantalwoodkleps) {
                $sql10 = "SELECT * FROM `hw_klas_koppel` WHERE `hw_opdracht_id` = $assignmentid";
                $res10 = mysqli_query($conn, $sql10);
                $rec10 = mysqli_fetch_array($res10);
                $klas = $rec10['klas_id'];
                $sql15 = "SELECT * FROM `klas` WHERE `klas_id` = $klas";
                $res15 = mysqli_query($conn, $sql15);
                $rec15 = mysqli_fetch_array($res15);
                $klasnaam = $rec15['klasnaam'];
                $sql11 = "SELECT * FROM `user_klas_koppel` JOIN `woodklep_users` ON user_klas_koppel.userid=woodklep_users.userid WHERE `klas_id` = 1 AND `userroleid` = 3;";
                $res11 = mysqli_query($conn, $sql11);
                $resamount = mysqli_num_rows($res11);
                $teller3 = 0;
                while ($rec11 = mysqli_fetch_array($res11)) {
                    $docent = $rec11['userid'];
                    $sql12 = "INSERT INTO `bericht` VALUES (NULL, $id, $docent, '$name heeft opdracht voltooid', '$name van klas $klasnaam heeft opdracht $opdrachtnaam afgerond.', CURRENT_DATE(), NULL)";
                    $res12 = mysqli_query($conn, $sql12);
                    $sql17 = "INSERT INTO `bericht_status` VALUES (NULL,0)";
                    $res17 = mysqli_query($conn, $sql17);
                    if ($res12&$res17) {
                        $teller3++;
                    }
                }
                if ($teller3==$resamount) {
                    $_SESSION['turnin'] = 'success';
                }
                else {
                    $_SESSION['turnin'] = 'error4';
                    //Fout bij bericht
                }
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
                helloWorld();
                if ($res9) {
                    $teller2++;
                }
            }
            if ($teller2 == $aantalwoodkleps) {
                $sql10 = "SELECT * FROM `hw_klas_koppel` WHERE `hw_opdracht_id` = $assignmentid";
                $res10 = mysqli_query($conn, $sql10);
                $rec10 = mysqli_fetch_array($res10);
                $klas = $rec10['klas_id'];
                $sql15 = "SELECT * FROM `klas` WHERE `klas_id` = $klas";
                $res15 = mysqli_query($conn, $sql15);
                $rec15 = mysqli_fetch_array($res15);
                $klasnaam = $rec15['klasnaam'];
                $sql11 = "SELECT * FROM `user_klas_koppel` JOIN `woodklep_users` ON user_klas_koppel.userid=woodklep_users.userid WHERE `klas_id` = 1 AND `userroleid` = 3;";
                $res11 = mysqli_query($conn, $sql11);
                $resamount = mysqli_num_rows($res11);
                $teller3 = 0;
                while ($rec11 = mysqli_fetch_array($res11)) {
                    $docent = $rec11['userid'];
                    $sql12 = "INSERT INTO `bericht` VALUES (NULL, $id, $docent, '$name heeft opdracht voltooid', '$name van klas $klasnaam heeft opdracht $opdrachtnaam afgerond.', CURRENT_DATE(), NULL)";
                    $res12 = mysqli_query($conn, $sql12);
                    $sql18 = "INSERT INTO `bericht_status` VALUES (NULL,0)";
                    $res18 = mysqli_query($conn, $sql18);
                    if ($res12&$res18) {
                        $teller3++;
                    }
                }
                if ($teller3==$resamount) {
                    $_SESSION['turnin'] = 'success';
                }
                else {
                    $_SESSION['turnin'] = 'error4';
                    //Fout bij bericht
                }
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