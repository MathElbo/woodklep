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
          $sql2 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $ki";
          $res2 = mysqli_query($conn, $sql2);
          while ($rec2 = mysqli_fetch_array($res2)) {
            $li = $rec2['userid'];
            $sql3 = "SELECT * FROM `woodklep_users` WHERE `userid` = $li AND `userroleid` = 1";
            $res3 = mysqli_query($conn, $sql3);
            if(!empty($res3)) {
              $linfo = mysqli_fetch_array($res3);
              $sql4 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $li";
              $res4 = mysqli_query($conn, $sql4);
              $lpinfo = mysqli_fetch_array($res4);
              if(is_null($lpinfo['name']) | !strcmp($lpinfo['name'],"")) {
                $lnaam = $linfo['username'];
              }
              else {
                $lnaam = $lpinfo['name'];
              }
              echo "<tr>
                      <td><h4 class='lead'><a style='color:black'><b>".$lnaam."</b></a></h4></td>
                    </tr>";
            }
          }
        }
        ?>
      </div>
    </div>
  </div>
</section>