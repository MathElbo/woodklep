<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

$opdrachtid = sanitize($_POST["oi"]);
$vraag = sanitize($_POST['vraag']);
$antwoord = sanitize($_POST['antwoord']);
$id = $_SESSION["id"];

if(!empty($vraag)){
    if(!empty($antwoord)) {
        $sql1 = "INSERT INTO `huiswerk_vraag` (`vraag_id`, `vraag`, `antwoord`) VALUES (NULL, '$vraag', '$antwoord')";
        $res1 = mysqli_query($conn, $sql1);
        if($res1){
            $sql3 = mysqli_query($conn, "SELECT MAX(vraag_id) as vraag_id FROM `huiswerk_vraag`"); 
            $row = mysqli_fetch_array($sql3);
            $vraagid = $row['vraag_id'];
            $sql2 = "INSERT INTO `opdrachtvraag_koppel` (`ov_koppel`, `opdracht_id`, `vraag_id`) VALUES (NULL, $opdrachtid, $vraagid)";
            $res2 = mysqli_query($conn, $sql2);
            if($res2) {
                $_SESSION["nieuwvraag"] = "success";
                header("Location: index.php?content=editopdracht&oi=$opdrachtid");
            }
            else {
                //SQL query mislukt
                $_SESSION['nieuwvraag'] = "error3";
                header("Location: index.php?content=editopdracht&oi=$opdrachtid");
            }
        }
        else {
            //SQL query mislukt
            $_SESSION['nieuwvraag'] = "error3";
            header("Location: index.php?content=editopdracht&oi=$opdrachtid");
        }
    }
    else {
        //Voer antwoord in
        $_SESSION['nieuwvraag'] = "error2";
        header("Location: index.php?content=editopdracht&oi=$opdrachtid");
    }
}
else {
    //Voer vraag in
    $_SESSION["nieuwvraag"] = "error1";
    header("Location: index.php?content=editopdracht&oi=$opdrachtid");
}