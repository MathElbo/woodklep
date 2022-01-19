<?php
$userrole = [1,2,3,4];
include("./php-scripts/security.php");
include("./php-scripts/connectDB.php");
$id = $_SESSION['id'];
$action = $_GET['action'];
if (isset($_GET['io'])) {
    $inout = $_GET['io'];
}
else {
    $inout = 'in';
}

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
        <div class='row'>
            <div class='col'>
                <?php
                if (!strcmp($action, "new")) {
                    $button1 = 'btn-light';
                }
                else {
                    $button1 = 'btn-dark';
                }
                ?>
            <a href='index.php?content=mijnberichten&action=new&io=<?php echo $inout?>' class='btn <?php echo $button1?>'>Nieuw bericht</a>
            </div>
        </div>
        <div class='row'>
            <br>
        </div>
        <div class='row'>
            <div class='col'>
            <?php
                if (!strcmp($inout, "in")) {
                    $button2 = 'btn-light';
                }
                else {
                    $button2 = 'btn-dark';
                }
                ?>
                <a href='index.php?content=mijnberichten&action=default&io=in' class='btn <?php echo $button2?>'>Inbox</a>
            </div>
            <div class='col'>
            <?php
                if (!strcmp($inout, "out")) {
                    $button3 = 'btn-light';
                }
                else {
                    $button3 = 'btn-dark';
                }
                ?>
                <a href='index.php?content=mijnberichten&action=default&io=out' class='btn <?php echo $button3?>'>Verstuurd</a>
            </div>
        </div>
        <table class="table table-hover">
        <?php
        if (!strcmp($inout, 'in')){
            $sql3 = "SELECT * FROM `bericht` WHERE `ontvanger` = $id ORDER BY `berichtid` DESC";
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
                echo "<tr><td>".$fullnamea."</td><td><a href='index.php?content=mijnberichten&action=default&io=in&text=".$rec3['berichtid']."' style='color:black'>".$rec3['onderwerp']."</a></td><td>".$rec3['datum']."</td></tr>";
            }
        } 
        else if (!strcmp($inout, 'out')){
            $sql3 = "SELECT * FROM `bericht` WHERE `afzender` = $id ORDER BY `berichtid` DESC";
            $res3 = mysqli_query($conn, $sql3);
            while ($rec3 = mysqli_fetch_array($res3)) {
                $ontvanger = $rec3 ['ontvanger'];
                $sql4 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $ontvanger";
                $res4 = mysqli_query($conn, $sql4);
                $rec4 = mysqli_fetch_array($res4);
                $sql5 = "SELECT * FROM `woodklep_users` WHERE `userid` = $ontvanger";
                $res5 = mysqli_query($conn, $sql5);
                $rec5 = mysqli_fetch_array($res5);
                if (is_null($rec4['name']) | !strcmp($rec4['name'], "")) {
                    $fullnamea = $rec5['username'];
                }
                else {
                    $fullnamea = $rec4['name'].' '.$rec4['infix'].' '.$rec4['lastname'];
                }
                echo "<tr><td>".$fullnamea."</td><td><a href='index.php?content=mijnberichten&action=default&io=".$inout."&text=".$rec3['berichtid']."' style='color:black'>".$rec3['onderwerp']."</a></td><td>".$rec3['datum']."</td></tr>";
            }
        } 
        ?>
        </table>
        </div>
        <!-- Error message display -->
        <!--<h2 class="display-4">Nieuwbericht opstellen</h2>-->
        <?php 
        if (!strcmp($action, 'new')|!strcmp($action, 'default')) {
            $border = ' border border-dark p-4';
        }
        else {
            $border = '';
        }
        echo '<div class="col-24 col-sm-6'.$border.'" style="background: white">';
        if (!strcmp($action, 'new')) {
            echo '<form action="index.php?content=script-nieuwbericht" method="post">';
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
            if (isset($_GET['sub'])) {
                $sub = $_GET['sub'];
                if (substr($sub,0,3)==='re:') {
                    $sub = substr($sub,3,strlen($sub)-3);
                    $onderwerp = "value='re: ".$sub."'";
                }
                else {
                    $onderwerp = "value=".$sub;
                }
            }
            else {
                $onderwerp = "placeholder='Onderwerp'";
            }
            if (isset($_GET['to'])) {
                $to = "value='".$_GET['to']."'";
            }
            else {
                $to = "placeholder='Gebruikersnaam'";
            }
            if (isset($_GET['antw'])) {
                $antw = "<input type='hidden' value='".$_GET['antw']."' name='antw' id='antw'>";
            }
            else {
                $antw = "<input type='hidden' value='NULL' name='antw' id='antw'>";
            }
            echo '<div class="form-row">
                <div class="col">
                    <label class="form-label"><b>Afzender: </b></label>
                </div>
                <div class="col">
                    <label class="form-label">'.$fullname.'</label>
                </div>
            </div>
            <div class="form-row">';
                echo "<div class='col'>
                    <label class='form-label'><b>Ontvanger: </b></label>
                </div>
                <div class='col'>
                    <input class='form-control'type='name' name='ontvanger' id='ontvanger' ".$to." required>
                </div>
            </div>";
            echo '<div class="form-row">';
                echo "<div class='col'>
                    <label class='form-label'><b>Onderwerp: </b></label>
                </div>
                <div class='col'>
                    <input class='form-control' type='name' name='onderwerp' id='onderwerp' ".$onderwerp." required>
                </div>
            </div>";
            echo '<div class="form-row">';
                echo "<div class='col'>
                    <label class='form-label'><b>Bericht: </b></label>
                </div>
            </div>";
            echo '<div class="form-row">';
                echo "<div class='col'>
                    <textarea class='form-control' type='name' name='bericht' id='bericht' placeholder='Bericht' rows=5 required></textarea>
                </div>
            </div>
            <div class='form-row'>
                <div class='col'>";
                    echo '<input class="btn btn-dark" type="submit" value="Verstuur">
                </div>
            </div>';
            echo "<div class='form-row'>
                <div class='col'>
                    ".$antw."
                </div>
            </div>
          </div>
        </form>";
        }
        else if (isset($_GET['text'])) {
            $berichtid = $_GET['text'];
            $sql6 = "SELECT * FROM `bericht` WHERE `berichtid` = $berichtid";
            $res6 = mysqli_query($conn, $sql6);
            if (mysqli_num_rows($res6)==1) {
                $rec6 = mysqli_fetch_array($res6);
                $afz = $rec6['afzender'];
                $ontv = $rec6['ontvanger'];
                $sql7 = "SELECT * FROM `woodklep_users` WHERE `userid` = $afz";
                $res7 = mysqli_query($conn, $sql7);
                $rec7 = mysqli_fetch_array($res7);
                $sql8 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $afz";
                $res8 = mysqli_query($conn, $sql8);
                $rec8 = mysqli_fetch_array($res8);
                if (is_null($rec8['name']) | !strcmp($rec8['name'], "")) {
                    $fullnameafz = $rec7['username'];
                }
                else {
                    $fullnameafz = $rec8['name'].' '.$rec8['infix'].' '.$rec8['lastname'];
                }
                $sql9 = "SELECT * FROM `woodklep_users` WHERE `userid` = $ontv";
                $res9 = mysqli_query($conn, $sql9);
                $rec9 = mysqli_fetch_array($res9);
                $sql10 = "SELECT * FROM `woodklep_personalinfo` WHERE `userid` = $ontv";
                $res10 = mysqli_query($conn, $sql10);
                $rec10 = mysqli_fetch_array($res10);
                if (is_null($rec10['name']) | !strcmp($rec10['name'], "")) {
                    $fullnameontv = $rec9['username'];
                }
                else {
                    $fullnameontv = $rec10['name'].' '.$rec10['infix'].' '.$rec10['lastname'];
                }
                $bericht = $rec6['bericht']."\n";
                $bericht = nl2br($bericht);
                echo "<table><tbody>
                     <tr><td><b>Afzender:</b> </td><td style='width:100px'></td><td>".$fullnameafz."</td><td width=30></td><td><a href='index.php?content=mijnberichten&action=new&io=in&sub=re:".$rec6['onderwerp']."&to=".$rec7['username']."&antw=".$rec6['berichtid']."' class='btn btn-dark'>Antwoord</a></td></tr>
                     <tr><td><b>Ontvanger: </b></td><td></td><td>".$fullnameontv."</td></tr>
                     </tbody></table>
                     <table><tbody>
                     <tr><td><b>Onderwerp: </b></td><td></td><td>".$rec6['onderwerp']."</td></tr>
                     <tr><td><b>Bericht: </b></td></tr>
                     </tbody></table>
                     <table><tbody>
                     <tr><td style='width:200%'>".$bericht."</td></tr>
                     </tbody></table>";
            }
            else {
                echo "<center>Geen bericht geselecteerd</center>";
            }
        }
        else if (!strcmp($action, 'default')){
            echo "<center>Geen bericht geselecteerd</center>";
        }
        ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</section>