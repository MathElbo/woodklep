<?php
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Get all userinfo
$resultu = getSpecificInfo('woodklep_users', 'userid', $id);
$userinfo = mysqli_fetch_assoc($resultu);

// get assignment_id
$assignmentid = $_GET["aid"];
$sql2 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $assignmentid";
$res2 = mysqli_query($conn, $sql2);
$rec2 = mysqli_fetch_array($res2);
$oname = $rec2['opdracht_naam'];


//count rows
$sql = "SELECT * from `opdrachtvraag_koppel`";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);


// Put all Vraag_Id's into array vraag
$vraag = array();


for ($i = 1; $i <= $rows; $i++) {
    $sql1 = "SELECT * from `opdrachtvraag_koppel`
    where ov_koppel = '$i'";
    $result1 = mysqli_query($conn, $sql1);
    $ovk = mysqli_fetch_assoc($result1);
    if ($ovk["opdracht_id"] == $assignmentid) {
        $vraag[] = $ovk["vraag_id"];
    }
}


?>



<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">opdracht
            <?php
            echo $oname;
            ?>
        </h1>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-1">
                    <form action="
                    <?php
                    $sql = "SELECT * FROM `student_opdracht_voortgang`
                    WHERE studentid = '$id' AND opdracht_id = '$assignmentid'";
                    $result = mysqli_query($conn, $sql);
                    $array = mysqli_fetch_assoc($result);
                    if (empty($array)) {
                    echo 'index.php?content=script-student-turnin&aid=';                        
                    } else {
                    echo 'index.php?content=script-student-redo&aid=';                        
                    }
                    echo $assignmentid;
                    echo '" method="post">
                        <div class="form-group">
                            <br>';

                    $j = count($vraag);
                    for ($i = 1; $i <= $j; $i++) {
                        $k = $i - 1;
                        $l = $vraag["$k"];
                        $sqlv = "SELECT * from `huiswerk_vraag`
                                WHERE vraag_id = '$l'";
                        $resultv = mysqli_query($conn, $sqlv);
                        $varray = mysqli_fetch_assoc($resultv);
                        echo '<label for="exampleFormControlInput1" class="form-label">Vraag ';
                        echo $i;
                        echo '</label> <br>
                                <label for="exampleFormControlInput1" class="form-label">';
                        echo $varray["vraag"];
                        echo '</label> <input class="form-control" type="antwoord';
                        echo $i;
                        echo '" name="antwoord';
                        echo $i;
                        echo '" id="antwoord';
                        echo $i;
                        
                        if (empty($array)) {
                            echo '" placeholder="';
                            echo 'Antwoord';                        
                            } else {
                            $sql = "SELECT * FROM `student_antwoord`
                            WHERE studentid  = '$id' AND vraag_id = '$l'";
                            $resulta = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($resulta)>0) {
                                $aarray = mysqli_fetch_assoc($resulta);
                                $antwoord = $aarray["antwoord"]; 
                                echo '" value="';
                                echo  $antwoord ;  
                            }
                            else {
                                echo '" placeholder="';
                                echo 'Antwoord';   
                            }         
                            }
                        
                        
                        echo '" required> <br>';
                    }
                    ?>
                            <br>
                            <input class="btn btn-dark" type="submit" value="Lever in">
                            <br>
                            <br><a href="./index.php?content=myhomework" class="btn btn-dark">Terug naar mijn huiswerk</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>