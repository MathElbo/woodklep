<?php
$userrole = [1,2,3,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];
$action = $_GET['action'];

if (isset($_SESSION["nieuwbericht"])){
  switch ($_SESSION["nieuwbericht"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Je bericht is succesvol verzonden";
      //header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["nieuwbericht"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Deze gebruiker bestaat niet";
      unset($_SESSION["nieuwbericht"]);
      break;
    case "error2":
      $pwclasses = 'error';
      $msg = 'Er ging iets mis met het versturen van het bericht';
      unset($_SESSION['nieuwbericht']);
      break;
    case 'error3':
      $pwclasses = 'error';
      $msg = 'Er ging iets mis met SQL Query';
      unset($_SESSION['nieuwbericht']);
      break;
    case 'error4':
      $pwclasses = 'error';
      $msg = 'Deze klas bestaat niet';
      unset($_SESSION['nieuwbericht']);
      break;
  }
}
?>

<section class="jumbotron jumbotron-fluid homeJumbo" style="background-color:gray">
  <div class="container">
  <div class="<?php if (isset($pwclasses)) echo "col display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
      </div>
  <h1 class='display-4'>Mijn berichten</h1>
  <div class="container">
  <div class="row">
    <div class="col-sm-9">
      <div class="row">
        <div class="col-12 col-sm-6">
        <!--<h2 class="display-4">Mijn berichten</h2>-->
        <table class="table table-hover">
        <?php
            $sql3 = "SELECT * FROM `bericht` WHERE `ontvanger` = $id";
            $res3 = mysqli_query($conn, $sql3);
            while ($rec3 = mysqli_fetch_array($res3)) {
                $afzender = $rec3 ['afzender'];
                $sql4 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $afzender";
                $res4 = mysqli_query($conn, $sql4);
                $rec4 = mysqli_fetch_array($res4);
                $sql5 = "SELECT * FROM `woodklep_users` WHERE `userid` = $afzender";
                $res5 = mysqli_query($conn, $sql5);
                $rec5 = mysqli_fetch_array($res5);
                if (is_null($rec4['name']) | !strcmp($rec4['name'], "")) {
                    $fullnamea = $rec5['username'];
                }
                else {
                    $fullnamea = $rec4['name'].' '.$rec4['infix'].' '.$rec4['lastname'];
                }
                echo "<tr><td>".$fullnamea."</td><td><a href='' style='color:black'>".$rec3['onderwerp']."</a></td><td>".$rec3['datum']."</td></tr>";
            }
        ?>
        </table>
        </div>
        <!-- Error message display -->
        <div class="col-24 col-sm-6 border border-dark p-4">
        <!--<h2 class="display-4">Nieuwbericht opstellen</h2>-->
        <form action="index.php?content=script-nieuwbericht" method="post">
            <?php
            $sql1 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $id";
            $res1 = mysqli_query($conn, $sql1);
            $rec1 = mysqli_fetch_array($res1);
            $sql2 = "SELECT * FROM `woodklep_users` WHERE `userid` = $id";
            $res2 = mysqli_query($conn, $sql2);
            $rec2 = mysqli_fetch_array($res2);
            if (is_null($rec1['name']) | !strcmp($rec1['name'], "")) {
                $fullname = $rec2['username'];
            }
            else {
                $fullname = $rec1['name']." ".$rec1['infix'].' '.$rec1['lastname'];
            }
            ?>
            <div class="form-row">
                <div class="col">
                    <label class="form-label"><b>Afzender: </b></label>
                </div>
                <div class="col">
                    <label class="form-label"><?php echo $fullname?></label>
                </div>
            </div>
            <div class="form-row">
                <div class='col'>
                    <label class='form-label'><b>Ontvanger: </b></label>
                </div>
                <div class='col'>
                    <input class='form-control'type='name' name='ontvanger' id='ontvanger' placeholder='Gebruikersnaam' required>
                </div>
            </div>
            <div class="form-row">
                <div class='col'>
                    <label class='form-label'><b>Onderwerp: </b></label>
                </div>
                <div class='col'>
                    <input class='form-control' type='name' name='onderwerp' id='onderwerp' placeholder='Onderwerp' required>
                </div>
            </div>
            <div class="form-row">
                <div class='col'>
                    <label class='form-label'><b>Bericht: </b></label>
                </div>
            </div>
            <div class="form-row">
                <div class='col'>
                    <textarea class='form-control' type='name' name='bericht' id='bericht' placeholder='Bericht' rows=5 required></textarea>
                </div>
            </div>
            <div class='form-row'>
                <div class='col'>
                    <input class="btn btn-dark" type="submit" value="Verstuur">
                </div>
            </div>
            <div class='form-row'>
                <div class='col'>
                    
                </div>
            </div>
          </div>
        </form>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
</section>