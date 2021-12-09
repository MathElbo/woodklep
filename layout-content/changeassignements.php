<?php
// Assign users that are allowed to visit this page
$userrole = [3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// Ophalen klas informatie
$klasid = $_GET['ki'];
$sql1 = "SELECT * FROM `klas` WHERE `klas_id` = $klasid";
$result1 = mysqli_query($conn, $sql1);
$classinfo = mysqli_fetch_assoc($result1);

if (isset($_SESSION["nieuweopdracht"])){
  switch ($_SESSION["nieuweopdracht"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Opdracht is aangemaakt";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["nieuweopdracht"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Er ging iets mis met de SQL Query";
      unset($_SESSION["nieuweopdracht"]);
      break;
    case "error3":
      $pwclasses = "error";
      $msg = "Deze klas bestaat niet in de database";
      unset($_SESSION['nieuweopdracht']);
      break;
  }
}
if (isset($_SESSION['opdrachtselect'])) {
  switch($_SESSION['opdrachtselect']) {
    case "success": 
      $pwclasses = "success";
      $msg = "U wordt nu doorgeleid naar de opdrachtpagina.";
      header ("Refresh: 1; url=./index.php?content=editopdracht&oi=". $_SESSION['opdrachtid']);
      unset($_SESSION["opdrachtselect"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Selecteer een opdracht.";
      unset($_SESSION['opdrachtselect']);
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
      <h2 class="display-4"><?php echo $classinfo['klasnaam']?></h2>
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <h3 class="display-5">Nieuwe opdracht</h3>
        <!-- Naamveranderen -->
        <h4 class="lead">Nieuwe opdracht</h4>
        <form action="index.php?content=script-newassignment" method="post">
            <div class="form-group">
                <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Naam van opdracht" required>
                <input type="hidden" value="<?php echo $klasid ?>" name="ki" id="ki">
                <input class="btn btn-dark" type="submit" value="Maak nieuwe opdracht">
            </div>
        </form>
        <h4 class="lead">Bewerk opdracht</h4>
        <form action="index.php?content=script-docentassignments" method="post">
            <div class="form-group">
                <select class="form-control" style="width:320px" name="opdracht" id="opdracht" required>
                    <option value="">Selecteer opdracht</option>
                    <?php
                        $sql1 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $klasid";
                        $opdrachten = mysqli_query($conn, $sql1);
                        while($opdracht = mysqli_fetch_array($opdrachten)){
                            $opdrachtid = $opdracht['hw_opdracht_id'];
                            $sql2 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdrachtid";
                            $opdrachtinfos = mysqli_query($conn, $sql2);
                            while($opdrachtinfo = mysqli_fetch_array($opdrachtinfos)){
                                echo "<option value='". $opdrachtinfo['opdracht_id'] ."'>" .$opdrachtinfo['opdracht_naam'] ."</option>";  // displaying data in option menu
                            }
                        }
                    ?>  
                </select>
                <input type="hidden" value="<?php echo $klasid ?>" name="ki" id="ki">
                <input class="btn btn-dark" type="submit" value="Selecteer opdracht">
            </div>
        </form>
        <a href="./index.php?content=klas&ki=<?php echo $klasid ?>" class="btn btn-dark">Terug naar klas: <?php echo $classinfo['klasnaam'] ?></a>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h3 class="display-5">Leerlingen</h3>
        <h4 class="lead">Bewerk leerlingen</h4>
        <form action="index.php?content=script-klas-change" method="post">
            <div class="form-group">
                <select class="form-control" style="width:320px" name="groep" id="groep" required>
                    <option value="">Selecteer leerling</option>
                        <?php
                            $sql1 = "SELECT * FROM `user_klas_koppel` WHERE `klas_id` = $klasid";
                            $res1 = mysqli_query($conn, $sql1);
                            while($users = mysqli_fetch_array($res1)){
                                $usersid = $users['userid'];
                                $sql2 = "SELECT * FROM `woodklep_users` WHERE `userid` = $usersid";
                                $res2 = mysqli_query($conn, $sql2);
                                while ($userinfo = mysqli_fetch_array($res2)) {
                                    if($userinfo['userroleid']==1){
                                        echo "<option value='". $userinfo['userid'] ."'>" .$userinfo['username'] ."</option>";
                                    }
                                }
                            }
                        ?>
                </select>
                <input class="btn btn-dark" type="submit" value="Kies leerling">
            </div>
        </form>
        <h4 class="lead">Voeg leerlingen toe</h4>
        <form action="index.php?content=script-klas-change" method="post">
            <div class="form-group">
            <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Naam leerling" required>
            <input class="btn btn-dark" type="submit" value="Voeg leerling toe">
            </div>
        </form>
      </div>
    </div>
  </div>
</section>