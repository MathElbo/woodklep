<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
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

if (isset($_SESSION["namechange"])){
  switch ($_SESSION["namechange"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Klasnaam is succesvol gewijzigd";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["namechange"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Er ging iets mis met de SQL Query";
      unset($_SESSION["namechange"]);
      break;
    case "error3":
      $pwclasses = "error";
      $msg = "Deze klas bestaat niet in de database";
      unset($_SESSION['namechange']);
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
        <h2 class="display-4">Mijn klas: <?php echo $classinfo['klasnaam']?></h2>
        <!-- Naamveranderen -->
        <h4 class="lead">Verander naam</h4>
        <form action="index.php?content=script-namechangeclass" method="post">
            <div class="form-group">
                <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Nieuwe klasnaam" required>
                <input type="hidden" value="<?php echo $klasid ?>" name="ki" id="ki">
                <input class="btn btn-dark" type="submit" value="Verander klasnaam">
            </div>
        </form>
        <a href="./index.php?content=klas&ki=<?php echo $klasid ?>" class="btn btn-dark">Terug naar klas: <?php echo $classinfo['klasnaam'] ?></a>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h2 class="display-4">Leerlingen</h2>
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