<?php
$userrole = [1,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];

if (isset($_SESSION["nieuwwoodklep"])){
  switch ($_SESSION["nieuwwoodklep"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Je hebt succesvol een woodklep gekoppeld";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["nieuwwoodklep"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Woodklep bestaat niet!";
      unset($_SESSION["nieuwwoodklep"]);
      break;
    case "error2":
      $pwclasses = 'error';
      $msg = 'Woodklep is al gekoppeld aan een andere gebruiker';
      unset($_SESSION['nieuwwoodklep']);
      break;
    case 'error3':
      $pwclasses = 'error';
      $msg = 'Er ging iets mis met SQL Query';
      unset($_SESSION['nieuwwoodklep']);
      break;
  }
}
if (isset($_SESSION['woodklepverwijder'])) {
    switch($_SESSION['woodklepverwijder']) {
        case 'success':
            $pwclasses = "success";
            $msg = "Je hebt succesvol je woodklep ontkoppeld";
            unset($_SESSION["woodklepverwijder"]);
            break;
        case 'error1':
            $pwclasses = 'error';
            $msg = 'Woodklep bestaat niet';
            unset($_SESSION['woodklepverwijder']);
            break;
        case 'error2':
            $pwclasses = 'error';
            $msg = 'Er ging iets mis met de SQL Query';
            unset($_SESSION['woodklepverwijder']);
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
        <h2 class="display-4">Bewerk Woodkleps</h2>
        <h4 class="lead">Woodklep toevoegen</h4>
        <!--<h4 class="lead">Nieuwe klas</h4>-->
        <!-- Nieuwe groep -->
        <form action="index.php?content=script-user-woodklepselect" method="post">
          <div class="form-group">
            <input class="form-control" style="width:320px" type="name" name="name" id="name" placeholder="Voer naam in voor je woodklep" required>
            <input class="form-control" style="width:320px" type="name" name="id" id="id" placeholder="Voer woodklepnummer in" required>
            <input class="form-control" style="width:320px" type="name" name="code" id="code" placeholder="Voer woodklepcode in" required>
            <input class="btn btn-dark" style="width:320px"type="submit" value="Voeg toe">
          </div>
        </form>
        <h4 class='lead'>Woodklep verwijderen</h4>
        <form action="index.php?content=script-user-woodklepverwijder" method="post">
          <div class="form-group">
            <select class="form-control" style="width:320px" name="wk" id="wk" required>
                <option value="">Selecteer woodklep</option>
                    <?php
                        $sql1 = "SELECT * FROM `wk_leerling_koppel` WHERE `leerlingid` = $id";
                        $res1 = mysqli_query($conn, $sql1);
                        while($rec1 = mysqli_fetch_array($res1)){
                            echo "<option value='".$rec1['wk_id']."'>" .$rec1['wkname'] ."</option>";
                        }
                    ?>  
            </select>
            <input class="btn btn-dark" style="width:320px"type="submit" value="Verwijder">
          </div>
        </form>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h2 class="display-4">Mijn Woodkleps</h2>
        <?php
            $sql1 = "SELECT * FROM `wk_leerling_koppel` WHERE `leerlingid` = $id";
            $res1 = mysqli_query($conn, $sql1);
            while ($rec1 = mysqli_fetch_array($res1)) {
              $wk = $rec1['wk_id'];
              $wkname = $rec1['wkname'];
              $sql2 = "SELECT * FROM `woodklep_status` WHERE `woodklep_id` = $wk";
              $res2 = mysqli_query($conn, $sql2);
              $rec2 = mysqli_fetch_array($res2);
              $wkopdracht = $rec1['wkopdracht'];
              $sql3 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $wkopdracht";
              $res3 = mysqli_query($conn, $sql3);
              $rec3 = mysqli_fetch_array($res3);
              $oname = $rec3['opdracht_naam'];
              if ($rec2['locked']==0) {
                  $status = "Dicht";
              }
              else {
                  $status = "Open";
              }
              echo "<p class='lead'><b><a>" . $wkname. "</a></b>
                    <br>Status: " . $status. "<br>
                    Gekoppelde opdracht: <a href='index.php?content=myassignment&aid=".$wkopdracht."' style='color:black'>".$oname." </a><br></p>";
              }
        ?>
      </div>
    </div>
  </div>
</section>