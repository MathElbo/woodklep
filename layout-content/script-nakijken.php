<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$groepsnaam = sanitize($_POST["name"]);
$id = $_SESSION["id"];

$li = $_POST['li'];
$oi = $_POST['oi'];
$sql1 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $oi";
$res1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($res1);
$sql5 = "SELECT woodklep_users.username, woodklep_personalinfo.name, woodklep_personalinfo.infix, woodklep_personalinfo.lastname FROM `woodklep_users` JOIN `woodklep_personalinfo` ON woodklep_users.userid=woodklep_personalinfo.userid WHERE woodklep_users.userid = $id";
$res5 = mysqli_query($conn, $sql5);
$rec5 = mysqli_fetch_array($res5);
if (is_null($rec5['name']) | $rec5['name'] === '') {
    $name = $rec5['username'];
}
else {
    $name = $rec5['name']." ".$rec5['infix']." ".$rec5['lastname'];
}
$teller1 = 0;
while ($rec1 = mysqli_fetch_array($res1)) {
    $vi = $rec1['vraag_id'];
    $sql2 = "SELECT huiswerk_vraag.vraag_id, huiswerk_vraag.antwoord, student_antwoord.studentid, student_antwoord.antwoord, student_antwoord.correctie FROM `huiswerk_vraag` JOIN `student_antwoord` ON student_antwoord.vraag_id=huiswerk_vraag.vraag_id WHERE huiswerk_vraag.vraag_id=$vi AND student_antwoord.studentid=$li";
    $res2 = mysqli_query($conn, $sql2);
    $rec2 = mysqli_fetch_array($res2);
    if (mysqli_num_rows($res2)>0) {
        $correctie = 'truefalse'.$vi;
        $corr = $_POST[$correctie];
        if ($corr==='false') {
            $sql3 = "UPDATE `student_antwoord` SET `correctie` = 0 WHERE `vraag_id` = $vi";
        }
        else {
            $sql3 = "UPDATE `student_antwoord` SET `correctie` = 1 WHERE `vraag_id` = $vi";
        }
        $res3 = mysqli_query($conn, $sql3);
        if ($res3) {
            $teller1++;
        }
    }
}
if ($teller1 == $count1) {
    $sql6 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $oi";
    $res6 = mysqli_query($conn, $sql6);
    $rec6 = mysqli_fetch_array($res6);
    $opdrachtnaam = $rec6['opdracht_naam'];
    $sql4 = "INSERT INTO `bericht` VALUES (NULL, $id, $li, '$name heeft je opdracht nagekeken', 'Opdracht $opdrachtnaam is nagekeken.\n<a href=index.php?content=myassignment&aid=$oi>Klik hier om het resultaat te zien.</a>', CURRENT_DATE(), NULL)";
    $res4 = mysqli_query($conn, $sql4);
    if ($res4) {
        $_SESSION['nakijken'] = 'success';
        header("Location: index.php?content=docentnakijken&oi=$oi&li=$li");
    }
    else {
        //Mis met bericht
        $_SESSION['nakijken'] = 'error2';
        header("Location: index.php?content=docentnakijken&oi=$oi&li=$li");
    }
}
else {
    //Er ging iets mis met het nakijken
    $_SESSION['nakijken'] = 'error1';
    header("Location: index.php?content=docentnakijken&oi=$oi&li=$li");
}

?>