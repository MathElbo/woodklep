<?php
$userrole = [3,4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];
$ki = $_GET["ki"];
$sql10 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
$res10 = mysqli_query($conn, $sql10);
$rec10 = mysqli_fetch_array($res10);

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
    $leerlingnaam = $leerlingpinfo['name']." ".$leerlingpinfo['infix']." ".$leerlingpinfo['lastname'];
}

if (isset($_SESSION["koppelopdracht"])) {
  switch ($_SESSION["koppelopdracht"]) {
    case "error1":
      $pwclasses = "error";
      $msg = "Huiswerkopdracht bestaat niet.";
      unset($_SESSION["koppelopdracht"]);
      break;
    case "success":
      $pwclasses = "success";
      $msg = "De gekoppelde opdracht is succesvol veranderd.";
      unset($_SESSION["koppelopdracht"]);
      break;
    case 'error2':
      $pwclasses = 'error';
      $msg = 'De huiswerkopdracht is al gekoppeld';
      unset ($_SESSION['koppelopdracht']);
      break;
    case 'error3':
      $pwclasses = 'error';
      $msg = 'Er ging iets mis in de SQL Query';
      unset ($_SESSION['koppelopdracht']);
      break;
    }
  }
?>

<div class="container-fluid">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 id="home" class="text-center"><?php echo $rec10['klasnaam']?></h1>
        <h2 id="home" class="text-center">Mijn leerling: <?php echo $leerlingnaam ?></h2>
        <h5 class="text-center">Op deze pagina kun je de gegevens van je leerling bekijken en wijzigen.</h5>
        <hr>
      </div>
    </div>
    <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
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
            <!--<tr>
            <td><a href='index.php?content=klas&ki=<?php echo $ki?>' class='btn btn-dark'>Terug naar klas</a></td>
            </tr>-->
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
                        $url = "index.php?content=leerlingoverzicht&li=$leerlingid&ki=$ki";
                    }
                    else {
                        $url = "index.php?content=leerlingoverzicht&li=$leerlingid&oi=$opdrachtid&ki=$ki";
                    }
                }
                else {
                    $url = "index.php?content=leerlingoverzicht&li=$leerlingid&oi=$opdrachtid&ki=$ki";
                }
                $sql9 = "SELECT * FROM `student_opdracht_voortgang` WHERE `studentid` = $leerlingid AND `opdracht_id` = $opdrachtid";
                $res9 = mysqli_query($conn, $sql9);
                if (mysqli_num_rows($res9)>0) {
                  $afgemaakt = "Klaar!";
                }
                else {
                  $afgemaakt = "Niet klaar";
                }
                echo "<tr>
                <td><a href='".$url."' style='Color:black'><b>".$rec5['opdracht_naam']."</b></a></td><td>".$afgemaakt."</td>
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
      <table class="table table-hover col-12 col-md-5">
        <thead>
          <tr>
            <th scope="col"><h3>Woodkleps</h3></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql11 = "SELECT * FROM `wk_leerling_koppel` WHERE `leerlingid` = $leerlingid";
          $res11 = mysqli_query($conn, $sql11);
          while ($rec11 = mysqli_fetch_array($res11)) {
            $wkid = $rec11['wk_id'];
            $sql12 = "SELECT * FROM `woodklep_status` WHERE `woodklep_id` = $wkid";
            $res12 = mysqli_query($conn, $sql12);
            $rec12 = mysqli_fetch_array($res12);
            if(!$rec12['locked']) {
              $status = "Dicht";
            }
            else {
              $status = "Open";
            }
            if (is_null($rec11['wkopdracht'])) {
              $kopdracht = "-";
            }
            else {
              $kopdracht = $rec11['wkopdracht'];
              $sql13 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $kopdracht";
              $res13 = mysqli_query($conn, $sql13);
              $rec13 = mysqli_fetch_array($res13);
              $kopdracht = $rec13['opdracht_naam'];
            }
            echo "<tr>
                    <td><b>Woodklepnaam</b></td><td>".$rec11['wkname']."</td>
                  </tr>
                  <tr>
                    <td><b>Status</b></td><td>".$status."</td>
                  </tr>
                  <tr>
                    <td><b>Gekoppelde opdracht</b></td><td>".$kopdracht."</td>
                  </tr>
                  <tr>
                    <td><b>Andere opdracht koppelen</b><td><form action='index.php?content=script-koppelwko' method='post'>
                    <select class='form-control' style='width:320px' name='opdracht' id='opdracht' required>
                      <option value=''>Selecteer opdracht</option>";
                      $sql14 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $ki";
                      $res14 = mysqli_query($conn, $sql14);
                      while($rec14 = mysqli_fetch_array($res14)) {
                        $opdr = $rec14['hw_opdracht_id'];
                        $sql15 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdr";
                        $res15 = mysqli_query($conn, $sql15);
                        $rec15 = mysqli_fetch_array($res15);
                        echo "<option value='".$opdr."'>".$rec15['opdracht_naam']."</option>";
                      }
                      if(mysqli_num_rows($res14)>0) {
                        $knop = "<br><input class='btn btn-dark' type='submit' value='Kies opdracht'></a>";
                      }
                      else {
                        $knop="";
                      }
                      echo "</select>
                      ".$knop."
                      <input type='hidden' value='".$ki."' name='ki' id='ki'>
                      <input type='hidden' value='".$leerlingid."' name='li' id='li'>
                      <input type='hidden' value='".$wkid."' name='wk' id='wk'>
                     </form></td>
                    </tr>";
          }
          ?>
            <tr>
            <td><a href='index.php?content=klas&ki=<?php echo $ki?>' class='btn btn-dark'>Terug naar klas</a></td>
            </tr>
        </tbody>
      </table>
    </div>