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
            echo $assignmentid;
            ?>
        </h1>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-1">
                    <form action="index.php?content=script-student-turnin&aid=
                    <?php echo $assignmentid; ?>
                    " method="post">
                        <div class="form-group">
                            <br>
                            <?php
                            $j = count($vraag);
                            for ($i = 1 ;$i <= $j; $i++){
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
                                echo '" placeholder="Antwoord" required> <br>';
                            }
                            ?>
                            <br>
                            <input class="btn btn-dark" type="submit" value="Lever in">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>