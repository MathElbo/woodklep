<?php
$userrole = [1,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];

if (isset($_SESSION["lidgroep"])){
  switch ($_SESSION["lidgroep"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Je bent succesvol lid geworden van de klas";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["lidgroep"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "U heeft geen klasnaam ingevuld!";
      unset($_SESSION["lidgroep"]);
      break;
    case "error2":
      $pwclasses = 'error';
      $msg = 'Je zit al in deze klas';
      unset($_SESSION['lidgroep']);
      break;
    case 'error3':
      $pwclasses = 'error';
      $msg = 'Er ging iets mis met SQL Query';
      unset($_SESSION['lidgroep']);
      break;
    case 'error4':
      $pwclasses = 'error';
      $msg = 'Deze klas bestaat niet';
      unset($_SESSION['lidgroep']);
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
        <h4 class="lead">Klas toevoegen</h4>
        <!--<h4 class="lead">Nieuwe klas</h4>-->
        <!-- Nieuwe groep -->
        <form action="index.php?content=script-nieuwklaslid" method="post">
          <div class="form-group">
            <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Klasnaam" required>
            <input class="btn btn-dark" style="width:320px"type="submit" value="Voeg toe">
          </div>
        </form>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h2 class="display-4">Mijn klassen</h2>
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
                  echo "<p class='lead'><b><a>" . $fullname. "</a></b>
                        <br>E-mail: " . $rec11['email']. "<br>
                        <a href='mailto:". $rec11['email']. "' class='btn btn-dark'>Stuur bericht</a></p>";
                }
              }
            }
        ?>
      </div>
    </div>
  </div>
</section>