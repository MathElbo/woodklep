<?php
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Opvragen klasseninfo
$klasid = $_GET["ki"];

// Get all classinfo
$sql = "SELECT * FROM `klas` WHERE `klas_id` = $klasid";
$result3 = mysqli_query($conn, $sql);
$classinfo = mysqli_fetch_assoc($result3);
$sql = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $klasid AND `userid` = $id;";
$result = mysqli_query($conn, $sql);
$homepage;
switch ($userrole) {
  case 1: $homepage = "studenthome";
  break;
  case 2: $homepage = "parenthome";
  break;
  case 3: $homepage = "teacherhome";
  break;
  default: $homepage = "homepage";
  break;
}
if(is_null(mysqli_fetch_assoc($result))){
  echo '<div class="alert alert-danger" role="alert">U heeft geen toegang tot deze pagina.</div>';
    header("Refresh: 2; url=./index.php?content=". $homepage);
  exit();
}
?>

<!-- Content van pagina -->
<div class="container-fluid">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 id="home" class="text-center"> Mijn klas: <?php echo $classinfo['klasnaam']?></h2>
        <h5 class="text-center">Op deze pagina kun je je klasgegevens bekijken en wijzigen.</h5>
        <hr>
      </div>
    </div>

    <!-- Persoonlijke gegevens -->
    <div class="row">
      <!-- Persoonlijke info -->
      <table class="table table-hover col-12 col-md-5">
        <thead>
          <tr>
            <th scope="col"><h3>Docenten</h3></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $klasid";
            $res2 = mysqli_query($conn, $sql2);
            while ($userid = mysqli_fetch_array($res2)){
              $userid = $userid['userid'];
              $sql8 = "SELECT * FROM `woodklep_users` WHERE `userid` = $userid AND `userroleid` = 3";
              $res8 = mysqli_query($conn, $sql8);
              while ($teacherid = mysqli_fetch_array($res8)) {
                $teacherid = $teacherid['userid'];
                $sql3 = "SELECT * FROM `woodklep_users` WHERE `userid` = $teacherid";
                $res3 = mysqli_query($conn, $sql3);
                $teacherinfo = mysqli_fetch_array($res3);
                $sql4 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $teacherid";
                $res4 = mysqli_query($conn, $sql4);
                $teacherpinfo = mysqli_fetch_array($res4);
                if(is_null($teacherpinfo['name'])||!strcmp($teacherpinfo['name'], "")){
                  $teacherfullname = $teacherinfo['username'];
                }
                else {
                  $teacherfullname = $teacherpinfo["name"] . ' ' . $teacherpinfo["infix"] . ' ' . $teacherpinfo["lastname"];
                }
                echo "<tr>
                            <td><h6>" . $teacherfullname . "</h6></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td>" . $teacherinfo['email'] . "</td>
                        </tr>
                        <tr>
                            <td><a href='mailto:". $teacherinfo['email'] ."' class='btn btn-dark'>Stuur bericht</a></td>
                        </tr>";
            }
              }
            ?>
        </tbody>
      </table>
      <!-- Mijn adres gegevens -->
      <table class="table table-hover col-12 offset-0 col-md-5 offset-md-2 myacc-card">
        <thead>
          <tr>
            <th scope="col"><h3>Leerlingen</h3></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $klasid";
            $res2 = mysqli_query($conn, $sql2);
            while ($userid = mysqli_fetch_array($res2)){
              $userid = $userid['userid'];
              $sql8 = "SELECT * FROM `woodklep_users` WHERE `userid` = $userid AND `userroleid` = 1";
              $res8 = mysqli_query($conn, $sql8);
              while ($studentid = mysqli_fetch_array($res8)) {
                $studentid = $studentid['userid'];
                $sql3 = "SELECT * FROM `woodklep_users` WHERE `userid` = $studentid";
                $res3 = mysqli_query($conn, $sql3);
                $studentinfo = mysqli_fetch_array($res3);
                $sql4 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $studentid";
                $res4 = mysqli_query($conn, $sql4);
                $studentpinfo = mysqli_fetch_array($res4);
                if(is_null($studentpinfo['name'])||!strcmp($studentpinfo['name'], "")){
                  $studentfullname = $studentinfo['username'];
                }
                else {
                  $studentfullname = $studentpinfo["name"] . ' ' . $studentpinfo["infix"] . ' ' . $studentpinfo["lastname"];
                }
                echo "<tr>
                            <td><h6>" . $studentfullname . "</h6></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td>" . $studentinfo['email'] . "</td>
                        </tr>
                        <tr>
                            <td><a href='mailto:". $studentinfo['email'] . "' class='btn btn-dark'>Stuur bericht</a></td>
                        </tr>";
            }
              }
            ?>
        </tbody>
      </table>
    </div>



    <!-- Aanpassen/wijzigen -->
    <div class="row">
      <div class="col-12">
        <h2 class="text-center" id="aanpassen">Aanpassen/wijzigen</h2>
        <hr>
      </div>
      <div class="col-12">
        <table class="table table-hover myacc-card tablelinks" width="100%">
          <thead>
            <tr>
              <th scope="col">Aanpassen/wijzigen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($userrole = 3) {
              echo "<tr>
              <td><a href='index.php?content=editklas&ki=". $klasid ."'>Mijn klas wijzigen</a></td>
            </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>