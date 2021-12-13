<?php
$userrole = [3,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];
?>

<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1 class="display-4">Mijn Opdrachten</h1>
                    <?php
                    $sql1 = "SELECT * FROM `user_klas_koppel` WHERE `userid` = $id";
                    $res1 = mysqli_query($conn, $sql1);
                    while ($rec1 = mysqli_fetch_array($res1)){
                        $ki = $rec1['klas_id'];
                        $sql2 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
                        $res2 = mysqli_query($conn, $sql2);
                        $rec2 = mysqli_fetch_array($res2);
                        $klasnaam = $rec2['klasnaam'];
                        echo "<h4 class='display-6'>".$klasnaam."</h4>";
                        $sql3 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $ki";
                        $res3 = mysqli_query($conn, $sql3);
                        while ($rec3 = mysqli_fetch_array($res3)) {
                            $oi = $rec3['hw_opdracht_id'];
                            $sql4 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $oi";
                            $res4 = mysqli_query($conn, $sql4);
                            $rec4 = mysqli_fetch_array($res4);
                            $sql5 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $oi";
                            $res5 = mysqli_query($conn, $sql5);
                            $vraagaantal = mysqli_num_rows($res5);
                            echo "<tr>
                                  <td><p class='lead'><a href='http://www.woodklep.org/index.php?content=editopdracht&oi=".$oi."' style='color:black'><b>" . $rec4['opdracht_naam'] . "</b></a></p></td> <td><p>".$vraagaantal." vragen</p></td>
                                  </tr>";
                        }
                    }
                    ?>
            </div>                
        </div>
    </div>
</div>