<?php
$userrole = [3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Opvragen opdrachtinfo
$opdrachtid = $_GET["oi"];
$sql1 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdrachtid";
$res1 = mysqli_query($conn, $sql1);
$opdrachtinfo = mysqli_fetch_array($res1);
$sql5 = "SELECT * FROM `hw_klas_koppel` WHERE `hw_opdracht_id` = $opdrachtid";
$res6 = mysqli_query($conn, $sql5);
$rec5 = mysqli_fetch_array($res6);
$ki = $rec5['klas_id'];

// Opvragen leerlinginfo
$li = $_GET['li'];
$sql6 = "SELECT * FROM `woodklep_users` JOIN `woodklep_personalinfo` ON woodklep_users.userid=woodklep_personalinfo.userid WHERE woodklep_users.userid=$li";
$res6 = mysqli_query($conn, $sql6);
$rec6 = mysqli_fetch_array($res6);
if ($rec6['name']==='' | is_null($rec6['name'])) {
    $fullname = $rec6['username'];
}
else {
    $fullname = $rec6['name']." ".$rec6['infix']." ".$rec6['lastname'];
}

if (isset($_SESSION["nieuwvraag"])){
    switch ($_SESSION["nieuwvraag"]) {
      case "success":
        $pwclasses = "success";
        $msg = "Vraag is toegevoegd.";
        unset($_SESSION["nieuwvraag"]);
        break;
      case "error1":
        $pwclasses = "error";
        $msg = "Voer een vraag in.";
        unset($_SESSION["nieuwvraag"]);
        break;
      case "error2":
        $pwclasses = "error";
        $msg = "Voer een antwoord in";
        unset($_SESSION['nieuwvraag']);
        break;
      case "error3":
        $pwclasses = "error";
        $msg = "Er ging iets mis met de SQL Query";
        unset($_SESSION['nieuwvraag']);
        break;
    }
}
if (isset($_SESSION["bewerkvraag"])){
    switch ($_SESSION["bewerkvraag"]) {
      case "success":
        $pwclasses = "success";
        $msg = "Vraag is bijgewerkt.";
        unset($_SESSION["bewerkvraag"]);
        break;
      case "error1":
        $pwclasses = "error";
        $msg = "Voer een vraag in.";
        unset($_SESSION["bewerkvraag"]);
        break;
      case "error2":
        $pwclasses = "error";
        $msg = "Voer een antwoord in";
        unset($_SESSION['bewerkvraag']);
        break;
      case "error3":
        $pwclasses = "error";
        $msg = "Er ging iets mis met de SQL Query";
        unset($_SESSION['bewerkvraag']);
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
      <h2 class="display-4"><?php echo $opdrachtinfo['opdracht_naam']?></h2>
      <h2 class="display-5"><?php echo $fullname?></h2>
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <!-- Naamveranderen -->
        <!--<h4 class="lead">Nieuwe vraag</h4>-->
        <form action="index.php?content=script-" method="post">
            <div class="form-group">
                <?php
                $sql2 = "SELECT * FROM `opdrachtvraag_koppel` JOIN `huiswerk_vraag` ON opdrachtvraag_koppel.vraag_id=huiswerk_vraag.vraag_id WHERE opdracht_id=$opdrachtid";
                $res2 = mysqli_query($conn, $sql2);
                $teller1 = 0;
                while ($rec2 = mysqli_fetch_array($res2)) {
                    $teller1++;
                    $vraag = $rec2['vraag_id'];
                    $sql3 = "SELECT * FROM `student_antwoord` WHERE studentid = $li AND vraag_id = $vraag";
                    $res3 = mysqli_query($conn, $sql3);
                    $rec3 = mysqli_fetch_array($res3);
                    echo '<label for="exampleFormControlInput1" class="form-label">Vraag '.$teller1.': '.$rec2["vraag"].'</label><br>
                    <label for="exampleFormControlInput1" class="form-label">Juiste antwoord: '.$rec2['antwoord'].' </label><br>
                    <label for="exampleFormControlInput1" class="form-label"><b>Antwoord leerling: '.$rec3['antwoord'].'</b></label><br>
                    <input type="radio" name="truefalse'.$teller1.'" value="true">Correct!<input type="radio" name="truefalse'.$teller1.'" value="false">Fout!<br>
                    <br>';
                }
                ?>
                <input class='btn btn-dark' type='submit' value='Opslaan'>
                <!--
                <input class="form-control" style="width:320px" type="name" name="vraag" id="vraag" placeholder="Vraag" required>
                <textarea class="form-control" style="width:320px" type="bericht" name="antwoord" id="antwoord" placeholder="Antwoord" rows="5" cols="40" required></textarea>
                <input type="hidden" value="<?php echo $opdrachtid ?>" name="oi" id="oi">
                <input class="btn btn-dark" type="submit" value="Maak nieuwe vraag">-->
            </div>
        </form>
        <a href="./index.php?content=leerlingoverzicht&ki=<?php echo $ki?>&li=<?php echo $li?>" class="btn btn-dark">Terug naar <?php echo $fullname?></a>
      </div>
      <!-- Register form -->
    </div>
  </div>
</section>