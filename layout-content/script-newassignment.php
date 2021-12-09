<?php
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");

// Get info van formulier
$opdrachtnaam = sanitize($_POST["name"]);
$id = $_SESSION['id'];
$ki = sanitize($_POST['ki']);

$sql1 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
$res1 = mysqli_query($conn, $sql1);

if(mysqli_num_rows($res1) == 1){
    $rec1 = mysqli_fetch_array($res1);
    $sql2 = "INSERT INTO `huiswerk_opdrachten` (`opdracht_id`, `opdracht_naam`) VALUES (NULL,'$opdrachtnaam')";
    $res2 = mysqli_query($conn, $sql2);
    if ($res2) {
        $sql3 = mysqli_query($conn, "SELECT MAX(opdracht_id) as opdracht_id FROM `huiswerk_opdrachten`"); 
        $row = mysqli_fetch_array($sql3);
        $opdrachtid = $row['opdracht_id'];
        $sql4 = "INSERT INTO `hw_klas_koppel`(`hwklas_id`, `hw_opdracht_id`, `klas_id`) VALUES (NULL, $opdrachtid, $ki)";
        $res4 = mysqli_query($conn, $sql4);
        if($res4) {
            //echo "Opdracht is aangemaakt"
            header("Location: index.php?content=changeassignements&ki=$ki");
            $_SESSION['nieuweopdracht'] = 'success';
        }
        else {
            //echo "Er ging iets mis met de SQL Query"
            header("Location: index.php?content=changeassignements&ki=$ki");
            $_SESSION['nieuweopdracht'] = 'error1';
        }
    }
    else {
        //echo "Er ging iets mis met de SQL Query"
        header("Location: index.php?content=changeassignements&ki=$ki");
        $_SESSION['nieuweopdracht'] = 'error1';
    }
}
else {
    //echo "klas bestaat niet in database"
    header("Location: index.php?content=changeassignements&ki=$ki");
    $_SESSION['nieuweopdracht'] = 'error3';
}
?>