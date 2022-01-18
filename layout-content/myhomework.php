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
        /*
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
            
        }*/
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
                        <table class="table table-hover col-12">
                            <thead>
                                <tr>
                                    <th scope="col">Mijn Huiswerk</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- loop opracht + link en geef Opdracht ID mee  -->
                                <?php
                                $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `userid` = 2";
                                $res2 = mysqli_query($conn, $sql2);
                                while ($rec2 = mysqli_fetch_array($res2)){
                                    $ki = $rec2['klas_id'];
                                    $sql5 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
                                    $res5 = mysqli_query($conn, $sql5);
                                    $rec5 = mysqli_fetch_array($res5);
                                    $klasnaam = $rec5['klasnaam'];
                                    $sql3 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $ki";
                                    $res3 = mysqli_query($conn, $sql3);
                                    while ($rec3 = mysqli_fetch_array($res3)){
                                        $oi = $rec3['hw_opdracht_id'];
                                        $sql4 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $oi";
                                        $res4 = mysqli_query($conn, $sql4);
                                        $rec4 = mysqli_fetch_array($res4);
                                        echo "<tr><td><a href='index.php?content=klas&ki=".$ki."' style='color:black'>".$klasnaam."</a></td><td>".$rec4['opdracht_naam']."</td>";
                                        $sql1 = "SELECT * FROM `student_opdracht_voortgang` WHERE `studentid` = $id AND `opdracht_id`=$oi";
                                        $res1 = mysqli_query($conn, $sql1);
                                        if (mysqli_num_rows($res1)==0) {
                                            echo "<td class='todo'>Te doen.</td>";
                                        }
                                        else {
                                            $rec1 = mysqli_fetch_array($res1);
                                            if ($rec1['gemaakt']==1) {
                                                echo "<td class='done'>Gedaan!</td>";
                                            }
                                            else {
                                                echo "<td class='todo'>Te doen.</td>";
                                            }
                                        }
                                        echo "<td><a class='btn btn-dark' href='index.php?content=myassignment&aid=";
                                        echo $oi;
                                        echo "'>Maak opdracht!</a></td>";
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