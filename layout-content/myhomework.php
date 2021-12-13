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


        for($i = 1; $i<=$rows; $i++ ) {
        $sql = "SELECT * FROM `hw_klas_koppel`
                WHERE hwklas_id = '$i'";
        $result = mysqli_query($conn, $sql);
        $klaskoppelhw = mysqli_fetch_assoc($result);
        if ($klaskoppelhw["klas_id"] == $klas){
        $opdracht[] = $klaskoppelhw["hw_opdracht_id"];
        }

            
        }
    }
}
?>

<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <h1 class="display-4">Huiswerk overzicht</h1>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <table class="table table-hover col-12 col-md-5">
                            <thead>
                                <tr>
                                    <th scope="col">Mijn Huiswerk</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- loop opracht + link en geef Opdracht ID mee  -->
                                <?php
                                $j = count($opdracht);
                                for ($i = 1 ;$i <= $j; $i++){
                                $sqlv = "SELECT * from `huiswerk_opdrachten`
                                WHERE opdracht_id = '$i'";
                                $resultv = mysqli_query($conn, $sqlv);
                                $array = mysqli_fetch_assoc($resultv);
                                echo '<tr><td>Te doen: </td> <td>';
                                echo $array["opdracht_naam"];
                                echo "</td><td><a class='btn btn-dark' href='index.php?content=myassignment&aid=";
                                echo $i;
                                echo "'>klik hier!</a></td>";


                                $sql = "SELECT * from `opdrachtvraag_koppel`";
                                $result = mysqli_query($conn, $sql);
                                $l = mysqli_num_rows($result);
                        
                                $opdrachtcheck = array();
                                
                                for ($k = 1 ;$k <= $l; $k++){
                                $sqlc = "SELECT * FROM `opdrachtvraag_koppel`
                                WHERE ov_koppel  = '$k'";
                                $resultc = mysqli_query($conn, $sqlc);
                                $carray = mysqli_fetch_assoc($resultc);
                                if ($carray["opdracht_id"] == $i){
                                    $opdrachtcheck[] = $carray["vraag_id"];
                                }
                                }
                                
                                $l = count("$opdrachtcheck");
                                for ($k = 1; $k <= $l; $k++) {
                                    $m = $k - 1;
                                    $n = $opdrachtcheck["$m"];
                                    $sqloc = "SELECT * from `huiswerk_vraag`
                                    WHERE vraag_id = '$n'";
                                    $resultoc = mysqli_query($conn, $sqoc);
                                    $ocarray = mysqli_fetch_assoc($resultoc);
                                    if (isset($ocarray["antwoord"])){
                                        echo "kek.";
                                    }

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