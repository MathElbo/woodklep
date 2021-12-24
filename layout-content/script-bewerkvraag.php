<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$opdrachtid = sanitize($_POST["oi"]);
$vraagid = sanitize($_POST["vi"]);
$vraag = sanitize($_POST['vraag']);
$antwoord = sanitize($_POST['antwoord']);
$id = $_SESSION["id"];

if(!empty($vraag)){
    if(!empty($antwoord)) {
        $sql1 = "UPDATE `huiswerk_vraag` SET  `vraag` = '$vraag', `antwoord` = '$antwoord' WHERE vraag_id = $vraagid";
        $res1 = mysqli_query($conn, $sql1);
        if($res1){
            $sql2 = "DELETE FROM `student_antwoord` WHERE `vraag_id` = $vraagid";
            $res2 = mysqli_query($conn, $sql2);
            if ($res2) {
                $sql3 = "UPDATE `student_opdracht_voortgang` SET `gemaakt` = 0 WHERE `opdracht_id` = $opdrachtid";
                $res3 = mysqli_query($conn, $sql3);
                if ($res3) {
                    $sql4 = "SELECT * FROM `wk_leerling_koppel` WHERE `wkopdracht` = $opdrachtid";
                    $res4 = mysqli_query($conn, $sql4);
                    while ($rec4 = mysqli_fetch_array($res4)) {
                        $wi = $rec4['wk_id'];
                        $sql5 = "UPDATE `woodklep_status` SET `locked` = 0 WHERE `woodklep_id` = $wi";
                        $res5 = mysqli_query($conn, $sql5);
                    }
                    $_SESSION["bewerkvraag"] = "success";
                    header("Location: index.php?content=editopdracht&oi=$opdrachtid");
                }
                else {
                    $_SESSION['bewerkvraag'] = "error3";
                    header("Location: index.php?content=editopdracht&oi=$opdrachtid");
                }
            }
            else {
                $_SESSION['bewerkvraag'] = "error3";
                header("Location: index.php?content=editopdracht&oi=$opdrachtid");
            }
        }
        else {
            //SQL query mislukt
            $_SESSION['bewerkvraag'] = "error3";
            header("Location: index.php?content=editopdracht&oi=$opdrachtid");
        }
    }
    else {
        //Voer antwoord in
        $_SESSION['bewerkvraag'] = "error2";
        header("Location: index.php?content=editopdracht&oi=$opdrachtid");
    }
}
else {
    //Voer vraag in
    $_SESSION["bewerkvraag"] = "error1";
    header("Location: index.php?content=editopdracht&oi=$opdrachtid");
}