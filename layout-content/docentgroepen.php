<?php
$userrole = [3,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];

if (isset($_SESSION["nieuwgroep"])){
  switch ($_SESSION["nieuwgroep"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Uw klas is succesvol aangemaakt";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["nieuwgroep"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "U heeft geen groepsnaam ingevuld!";
      unset($_SESSION["nieuwgroep"]);
      break;
  }
}
if (isset($_SESSION["groepselect"])){
    switch ($_SESSION["groepselect"]) {
        case "success":
            $pwclasses = "success";
            $msg = "U wordt nu doorgeleid naar de klassenpagina.";
            header ("Refresh: 1; url=./index.php?content=klas&ki=". $_SESSION["groepid"]);
            unset($_SESSION["groepselect"]);
            break;
        case "error1":
            $pwclasses = "error";
            $msg = "Er is geen groep geselecteerd!";
            unset($_SESSION["groepselect"]);
            break;
    }
}
?>

<section class="jumbotron jumbotron-fluid homeJumbo" style="background-color:gray">
  <div class="container">
    <div class="row">
      <!-- Error message display -->
      <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
      </div>
      <!-- Groepen -->
      <div class="col-12 col-md-11 offset-md-1">
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <h2 class="display-4">Mijn klassen</h2>
        <h4 class="lead">Klassenoverzicht</h4>
        <form action="index.php?content=script-docentgroepen" method="post">
            <div class="form-group">
                <select class="form-control" style="width:320px" name="groep" id="groep" required>
                    <option value="">Selecteer klas</option>
                    <?php
                        $sql = "SELECT * FROM `user_klas_koppel` WHERE `userid` = $id";
                        $klassen = mysqli_query($conn, $sql);
                        while($klas = mysqli_fetch_array($klassen)){
                            $klasid = $klas['klas_id'];
                            $sql = "SELECT * FROM `klas` WHERE `klas_id` = $klasid";
                            $klasjes = mysqli_query($conn, $sql);
                            while($klasnaam = mysqli_fetch_array($klasjes)){
                                echo "<option value='". $klasnaam['klas_id'] ."'>" .$klasnaam['klasnaam'] ."</option>";  // displaying data in option menu
                            }
                        }
                        //$records = mysqli_query($conn, "SELECT * From klas");
                        //while($data = mysqli_fetch_array($records)){
                        //    echo "<option value='". $data['klas_id'] ."'>" .$data['klasnaam'] ."</option>";  // displaying data in option menu
                        //}	
                    ?>  
                </select>
                <input class="btn btn-dark" type="submit" value="Kies groep">
            </div>
        </form>
        <h4 class="lead">Nieuwe klas</h4>
        <!-- Nieuwe groep -->
        <form action="index.php?content=script-newgroup" method="post">
          <div class="form-group">
            <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Groepsnaam" required>
            <input class="btn btn-dark" style="width:320px"type="submit" value="Maak nieuwe groep">
          </div>
        </form>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h2 class="display-4">Mijn leerlingen</h2>
        <?php
            $sql1 = "SELECT * FROM `user_klas_koppel` WHERE `userid` = $id";
            $res1 = mysqli_query($conn, $sql1);
            while ($rec1 = mysqli_fetch_array($res1)) {
              $ki = $rec1['klas_id'];
              $sql10 = "SELECT * FROM `klas` WHERE `klas_id` = $ki";
              $res10 = mysqli_query($conn, $sql10);
              $rec10 = mysqli_fetch_array($res10);
              echo "<b><h4 class='display-6'><a href='index.php?content=klas&ki=".$ki."' style='Color:black'>".$rec10['klasnaam']."</a></h4></b>";
              $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $ki";
              $res2 = mysqli_query($conn, $sql2);
              while($rec2 = mysqli_fetch_array($res2)) {
                $ui = $rec2['userid'];
                $sql11 = "SELECT * FROM `woodklep_users` WHERE `userid` = $ui AND `userroleid` = 1";
                $res11 = mysqli_query($conn, $sql11);
                if(mysqli_num_rows($res11)>0) {
                  $rec11 = mysqli_fetch_array($res11);
                  $sql12 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $ui";
                  $res12 = mysqli_query($conn, $sql12);
                  $rec12 = mysqli_fetch_array($res12);
                  if (is_null($rec12['name']) | !strcmp($rec12['name'], '')) {
                    $fullname = $rec11['username'];
                  }
                  else {
                    $fullname = $rec12['name']. " " . $rec12['infix'] . " " . $rec12['lastname'];
                  }
                  echo "<p class='lead'><b><a href='index.php?content=leerlingoverzicht&li=".$ui."&ki=".$ki."' style='color:black'>" . $fullname. "</a></b>
                        <br>E-mail: " . $rec11['email']. "<br>
                        <a href='mailto:". $rec11['email']. "' class='btn btn-dark'>Stuur bericht</a></p>";
                }
              }
            /*while ($userid = mysqli_fetch_array($res2)){
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
                echo "<p><b><a href='index.php?content=leerlingoverzicht&li=".$studentinfo['userid']."' style='color:black'>" . $studentfullname . "</a></b>
                      <br>E-mail: " . $studentinfo['email'] . "<br>
                      <a href='mailto:". $studentinfo['email'] . "' class='btn btn-dark'>Stuur bericht</a></p>";
            }
              }*/
            }
        ?>
      </div>
    </div>
  </div>
</section>