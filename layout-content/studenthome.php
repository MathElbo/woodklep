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

// First get u role from woodklep_users and see if role is student
if ($userinfo["userroleid"] == 1) {
    // Get klas from user_klas_koppel 
    $sql = "SELECT * FROM `user_klas_koppel`
            WHERE userid = '$id'";
    $result = mysqli_query($conn, $sql);
    $userkoppelklas = mysqli_fetch_assoc($result);
    $klas = $userkoppelklas["klas_id"];
    if (isset($klas)) {
        // Get opdrachten from hw_klas_koppel
        $sql = "SELECT * from `hw_klas_koppel`";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);

        $opdracht = array();


        for ($i = 1; $i <= $rows; $i++) {
            $sql = "SELECT * FROM `hw_klas_koppel`
                WHERE hwklas_id = '$i'";
            $result = mysqli_query($conn, $sql);
            $klaskoppelhw = mysqli_fetch_assoc($result);
            if ($klaskoppelhw["klas_id"] == $klas) {
                $opdracht[] = $klaskoppelhw["hw_opdracht_id"];
            }
        }
    }
}
?>

<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">student</h1>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mijn huiswerk</h5>
                                    <p class="card-text">Een overzicht van al jou gemaakte huiswerk.</p>
                                    <a href="./index.php?content=myhomework" class="btn btn-secondary">Klik Hier!</a>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Volgende Opdracht.</h5>
                                    <p class="card-text">De eerst volgende ongemaakte opdracht!</p>
                                    <?php
                                    $j = count($opdracht);
                                    for ($i = 1; $i <= $j; $i++) {
                                        $sqlv = "SELECT * from `huiswerk_opdrachten`
                                        WHERE opdracht_id = '$i'";
                                        $resultv = mysqli_query($conn, $sqlv);
                                        $array = mysqli_fetch_assoc($resultv);
                                        


                                        $sql = "SELECT * from `opdrachtvraag_koppel`";
                                        $result = mysqli_query($conn, $sql);
                                        $l = mysqli_num_rows($result);

                                        $opdrachtcheck = array();

                                        for ($k = 1; $k <= $l; $k++) {
                                            $sqlc = "SELECT * FROM `opdrachtvraag_koppel`
                                             WHERE ov_koppel  = '$k'";
                                            $resultc = mysqli_query($conn, $sqlc);
                                            $carray = mysqli_fetch_assoc($resultc);
                                            if ($carray["opdracht_id"] == $i) {
                                                $opdrachtcheck[] = $carray["vraag_id"];
                                            }
                                        }

                                        $o = 0;
                                        $l = count($opdrachtcheck);
                                        for ($k = 1; $k <= $l; $k++) {
                                            $m = $k - 1;
                                            $n = $opdrachtcheck["$m"];
                                            $sqloc = "SELECT * from `huiswerk_vraag`
                                            WHERE vraag_id = '$n'";
                                            $resultoc = mysqli_query($conn, $sqloc);
                                            $ocarray = mysqli_fetch_assoc($resultoc);
                                            if (isset($ocarray["antwoord"])) {
                                                $o++;
                                            }
                                        }
                                        if ($o == 0) {
                                        } else {
                                            echo "<a href='./index.php?content=myassignment&aid=";
                                            echo $i;
                                            echo "' class='btn btn-secondary'>Klik Hier!</a>";
                                            $i = $j;
                                        }
                                    }
                                    ?>

                                    
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="width: fit-content;">
                        <img src="./assets/img/nlogo.jpg" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">
                                Doe "X" om doos te ontgrendellen
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>