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
if (isset($_GET["aid"])) {
    $assignmentid = $_GET["aid"];
} else {
    echo "error";
}


//count rows
$sql = "SELECT * from `opdrachtvraag_koppel`";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);



// Putt all Vraag_Id's into array vraag
$vraag = array();




for($i=1; $i<=$rows; $i++){
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
        <h1 class="display-4">opdracht ?</h1>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <table class="table table-hover col-12 col-md-5">
                            <thead>
                                <tr>
                                    <th scope="col">Beantwoord de volgende vragen en lever in:</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $j = count($vraag);
                            for ($i = 1 ;$i <= $j; $i++){
                                $k = $i - 1;
                                $l = $vraag["$k"];
                                $sqlv = "SELECT * from `huiswerk_vraag`
                                WHERE vraag_id = '$l'";
                                $resultv = mysqli_query($conn, $sqlv);
                                $varray = mysqli_fetch_assoc($resultv);
                                echo '<tr><td>Vraag: </td> <td>';
                                echo $varray["vraag"];
                                echo '</td> </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>