<?php
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];
$ki = $_GET["ki"];

// Opvragen leerlinginfo
$leerlingid = $_GET["li"];
$sql1 = "SELECT * FROM `woodklep_users` WHERE `userid` = $leerlingid";
$res1 = mysqli_query($conn, $sql1);
$leerlinginfo = mysqli_fetch_array($res1);
$sql2 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $leerlingid";
$res2 = mysqli_query($conn, $sql2);
$leerlingpinfo = mysqli_fetch_array($res2);
if(is_null($leerlingpinfo['name']) | !strcmp($leerlingpinfo['name'], "")) {
    $leerlingnaam = $leerlinginfo['username'];
}
else {
    $leerlingnaam = $leerlingpinfo['name'];
}
?>

<div class="container-fluid">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 id="home" class="text-center">Mijn leerling: <?php echo $leerlingnaam ?></h2>
        <h5 class="text-center">Op deze pagina kun je de gegevens van je leerling bekijken en wijzigen.</h5>
        <hr>
      </div>
    </div>

    <div class="row">
      <!-- Informatie leraren -->
      <table class="table table-hover col-12 col-md-5">
        <thead>
          <tr>
            <th scope="col"><h3>Informatie</h3></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Gebruikersnaam</b></td><td><?php echo $leerlinginfo['username']?></td>
            </tr>
            <tr>
                <td><b>E-mail</b></td><td><?php echo $leerlinginfo['email']?></td>
            </tr>
            <tr>
                <td><a href='mailto:<?php echo $leerlinginfo['email']?>' class='btn btn-dark'>Stuur bericht</a></td>
            </tr>
        </tbody>
      </table>
      <!-- Leerlingen -->
      <table class="table table-hover col-12 offset-0 col-md-5 offset-md-2 myacc-card">
        <thead>
          <tr>
            <th scope="col"><h3>Opdrachten</h3></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php 
        //$sql3 = "SELECT * FROM `user_klas_koppel` WHERE `userid` = $leerlingid AND `klas_id` = $ki";
        //$res3 = mysqli_query($conn, $sql3);
        //while ($rec3 = mysqli_fetch_array($res3)) {
            //$klasid = $rec3['klas_id'];
            $sql4 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $ki";
            $res4 = mysqli_query($conn, $sql4);
            while ($rec4 = mysqli_fetch_array($res4)) {
                $opdrachtid = $rec4['hw_opdracht_id'];
                $sql5 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdrachtid";
                $res5 = mysqli_query($conn, $sql5);
                $rec5 = mysqli_fetch_array($res5);
                if(isset($_GET['oi'])){
                    if($_GET['oi']==$opdrachtid) {
                        $url = "index.php?content=leerlingoverzicht&li=$leerlingid";
                    }
                    else {
                        $url = "index.php?content=leerlingoverzicht&li=$leerlingid&oi=$opdrachtid";
                    }
                }
                else {
                    $url = "index.php?content=leerlingoverzicht&li=$leerlingid&oi=$opdrachtid";
                }
                echo "<tr>
                <td><a href='".$url."' style='Color:black'><b>".$rec5['opdracht_naam']."</b></a></td><td>Afgesloten</td>
                </tr>";
                if(isset($_GET['oi'])) {
                    if($_GET['oi']==$opdrachtid) {
                        $oi = $_GET['oi'];
                        $sql6 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $oi";
                        $res6 = mysqli_query($conn, $sql6);
                        $x = 1;
                        while ($rec6 = mysqli_fetch_array($res6)) {
                            $vraagid = $rec6['vraag_id'];
                            $sql7 = "SELECT * FROM `huiswerk_vraag` WHERE `vraag_id` = $vraagid";
                            $res7 = mysqli_query($conn, $sql7);
                            while ($rec7 = mysqli_fetch_array($res7)) {
                                echo "<tr>
                                    <td><i>Vraag ".$x."</i></td><td>".$rec7['vraag']."</td>
                                </tr>
                                <tr>
                                    <td><i>Juiste antwoord</i></td><td>".$rec7['antwoord']."</td>
                                </tr>";
                                $x = $x + 1;
                                $sql8 = "SELECT * FROM `student_antwoord` WHERE `vraag_id` = $vraagid AND `studentid` = $leerlingid";
                                $res8 = mysqli_query($conn, $sql8);
                                while($rec8 = mysqli_fetch_array($res8)) {
                                    echo "<tr>
                                        <td><i>Antwoord van ".$leerlingnaam."</i></td><td>".$rec8['antwoord']."</td>
                                    </tr.>";
                                }
                            }
                        }
                    }
                }
            }
        //}
        ?>
        </tbody>
      </table>
    </div>