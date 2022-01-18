<?php
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Get all userinfo
$resultu = getSpecificInfo('woodklep_users', 'userid', $id);
$userinfo = mysqli_fetch_assoc($resultu);

// get assignment_id
$assignmentid = $_GET["aid"];
$sql2 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $assignmentid";
$res2 = mysqli_query($conn, $sql2);
$rec2 = mysqli_fetch_array($res2);
$oname = $rec2['opdracht_naam'];

if (isset($_SESSION["turnin"])) {
    switch ($_SESSION["turnin"]) {
      case "error1":
        $pwclasses = "error";
        $msg = "Het opslaan van je antwoorden is mislukt";
        unset($_SESSION["turnin"]);
        break;
      case "success":
        $pwclasses = "success";
        $msg = "Je opdracht is succesvol ingeleverd.";
        unset($_SESSION["turnin"]);
        break;
      case "error2":
        $pwclasses = "error";
        $msg = "Er ging iets mis bij het aanpassen van de opdrachtvoortgang.";
        unset($_SESSION['turnin']);
        break;
      case 'error3':
        $pwclasses = 'error';
        $msg = 'Er ging iets mis bij het updaten van de woodklepstatus';
        unset($_SESSION['turnin']);
        break;
      case 'error4':
        $pwclasses = 'error';
        $msg = 'Er ging iets mis bij het versturen van de notificatie';
        unset($_SESSION['turnin']);
        break;
      }
    }
?>



<div class="jumbotron jumbotron-fluid homeJumbo">
    <div class="container">
    <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
      </div>
        <h1 class="display-4">Opdracht
            <?php
            echo $oname;
            ?>
        </h1>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 offset-md-1">
                    <form action="index.php?content=script-student-turnin&aid=
                    <?php
                    echo $assignmentid.'" method="post"> <div class="form-group"><br>';
                    $sql3 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $assignmentid";
                    $res3 = mysqli_query($conn, $sql3);
                    while ($rec3 = mysqli_fetch_array($res3)) {
                        $vi = $rec3['vraag_id'];
                        $sql4 = "SELECT * FROM `huiswerk_vraag` WHERE `vraag_id` = $vi";
                        $res4 = mysqli_query($conn, $sql4);
                        $rec4 = mysqli_fetch_array($res4);
                        echo '<label for="exampleFormControlInput1" class="form-label"><br>'.$rec4["vraag"].'</label>';
                        echo '<input class="form-control" type="antwoord" name ="'.$vi.'" id="'.$vi.'"';
                        $sql5 = "SELECT * FROM `student_antwoord` WHERE `vraag_id` = $vi AND `studentid` = $id";
                        $res5 = mysqli_query($conn, $sql5);
                        if (mysqli_num_rows($res5)>0){
                            $rec5 = mysqli_fetch_array($res5);
                            echo '" value="'.$rec5["antwoord"].'" required>';
                        }
                        else {
                            echo '" placeholder="Antwoord" required>';
                        }
                    }
                    ?>
                            <br>
                            <input class='btn btn-dark' type="submit" value="Lever in">
                            <br>
                            <br><a href="./index.php?content=myhomework" class="btn btn-dark">Terug naar mijn huiswerk</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>