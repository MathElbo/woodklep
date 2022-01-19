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

if (isset($_SESSION["nakijken"])){
    switch ($_SESSION["nakijken"]) {
      case "success":
        $pwclasses = "success";
        $msg = "De opdracht is succesvol nagekeken.";
        unset($_SESSION["nakijken"]);
        break;
      case "error1":
        $pwclasses = "error";
        $msg = "Nakijken is mislukt.";
        unset($_SESSION["nakijken"]);
        break;
      case 'error2':
        $pwclasses = 'error';
        $msg = 'Er ging iets mis met het versturen van een bericht.';
        unset($_SESSION['nakijken']);
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
        <form action="index.php?content=script-nakijken" method="post">
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
                    echo '<label for="exampleFormControlInput1" class="form-label"><b>Vraag '.$teller1.': '.$rec2["vraag"].'</b></label><br>
                    <label for="exampleFormControlInput1" class="form-label">Juiste antwoord: '.$rec2['antwoord'].' </label><br>';
                    if(mysqli_num_rows($res3)>0) {
                        $rec3 = mysqli_fetch_array($res3);
                        if (!is_null($rec3['correctie'])) {
                          if ($rec3['correctie'] == 1) {
                            echo '<label for="exampleFormControlInput1" class="form-label"><i>Antwoord leerling: '.$rec3['antwoord'].'</i></label><br>
                            <input type="radio" name="truefalse'.$vraag.'" checked value="true">Correct!<input type="radio" name="truefalse'.$vraag.'" value="false">Fout!';
                          }
                          else {
                            echo '<label for="exampleFormControlInput1" class="form-label"><i>Antwoord leerling: '.$rec3['antwoord'].'</i></label><br>
                            <input type="radio" name="truefalse'.$vraag.'" value="true">Correct!<input type="radio" name="truefalse'.$vraag.'" checked value="false">Fout!';
                          }
                        }
                        else {
                          echo '<label for="exampleFormControlInput1" class="form-label"><i>Antwoord leerling: '.$rec3['antwoord'].'</i></label><br>
                            <input type="radio" name="truefalse'.$vraag.'" value="true">Correct!<input type="radio" name="truefalse'.$vraag.'" value="false">Fout!';
                        }
                        echo '<input type="hidden" name="vraagid'.$vraag.'" value="'.$vraag.'"><br>';
                    }
                    echo '<br>';
                }
                ?>
                <input type='hidden' name='li' value='<?php echo $li?>'>
                <input type='hidden' name='oi' value='<?php echo $opdrachtid?>'>
                <input class='btn btn-dark' type='submit' value='Opslaan'>
                <!--
                <input class="form-control" style="width:320px" type="name" name="vraag" id="vraag" placeholder="Vraag" required>
                <textarea class="form-control" style="width:320px" type="bericht" name="antwoord" id="antwoord" placeholder="Antwoord" rows="5" cols="40" required></textarea>
                <input type="hidden" value="<?php //echo $opdrachtid ?>" name="oi" id="oi">
                <input class="btn btn-dark" type="submit" value="Maak nieuwe vraag">-->
            </div>
        </form>
        <a href="./index.php?content=leerlingoverzicht&ki=<?php echo $ki?>&li=<?php echo $li?>" class="btn btn-dark">Terug naar <?php echo $fullname?></a>
      </div>
      <!-- Register form -->
    </div>
  </div>
</section>