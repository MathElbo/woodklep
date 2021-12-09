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
        <a href="./index.php?content=klas&ki=<?php echo $klasid ?>" class="btn btn-dark">Terug naar klas: <?php echo $classinfo['klasnaam'] ?></a>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h3 class="display-5">Opdrachten</h3>
        <?php
            $sql9 = "SELECT * FROM `hw_klas_koppel` WHERE `klas_id` = $klasid";
            $res9 = mysqli_query($conn, $sql9);
            while ($huiswerkid = mysqli_fetch_array($res9)){
              $huiswerkid = $huiswerkid['hw_opdracht_id'];
              $sql10 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $huiswerkid";
              $res10 = mysqli_query($conn, $sql10);
              while ($rec10 = mysqli_fetch_array($res10)) {
                $sql11 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $huiswerkid";
                $res11 = mysqli_query($conn, $sql11);
                $vraagaatal = 0;
                if(!$res11){
                }
                else {
                  $vraagaatal = mysqli_num_rows($res11);
                }
                echo "<tr>
                      <td><h6><a href='http://www.woodklep.org/index.php?content=editopdracht&oi=".$rec10['opdracht_id']."' style='color:black'><b>" . $rec10['opdracht_naam'] . "</b></a></h6></td> <td>".$vraagaatal." vragen</td>
                    </tr>";
              }
            }
          ?>
      </div>
    </div>
  </div>
</section>