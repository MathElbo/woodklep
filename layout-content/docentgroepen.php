<?php
$userrole = [3,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");

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
            header ("Refresh: 1; url=./index.php?content=klas");
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
                        $id = $_SESSION['id'];
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
        <h4 class="lead">Test 2</h4>
      </div>
    </div>
  </div>
</section>