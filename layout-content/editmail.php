<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// Ophalen van alle user info
$result = getSpecificInfo('woodklep_users', 'userid', $id);
$userinfo = mysqli_fetch_assoc($result);

// Ophalen van alle persoonlijke info
$sql = "SELECT p.* from `woodklep_personalinfo` p
        left join `woodklep_users` u on u.userid = p.userid
        where u.userid = '$id'";
$result1 = mysqli_query($conn, $sql);
$pinfo = mysqli_fetch_assoc($result1);

//check if session variable is set
if (isset($_SESSION["changemail"])) {
  switch ($_SESSION["changemail"]) {
    case "error1":
      $pwclasses = "error1";
      $msg = "Het ingevoerde e-mailadres is al in gebruik.";
      $email = $_SESSION["email"];
      unset($_SESSION["changemail"]);
      break;
    case "error2":
      $pwclasses = "error2";
      $msg = "Er ging iets mis met het wijzigen van uw e-mail adres. Probeer het later nog eens.";
      unset($_SESSION["changemail"]);
    case "success":
      $pwclasses = "success";
      $msg = "Er is een verificatiemail naar uw oude e-mail adres gestuurd. U wordt nu doorverwezen naar uw gegevens.";
      header("Refresh: 4, url=./index.php?content=redirect");
      unset($_SESSION["changemail"]);
      unset($_SESSION["email"]);
      break;
    }
  }
?>

<!-- Wijzigen -->
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-edit fa-5x"></i>
      <p>Gegevens wijzigen</p>
    </div>
    <!-- Error message -->
    <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
    </div>
    <!-- Wijzigingsformulier email gegevens -->
    <form action="index.php?content=script-user-mail" method="post" class="vlr">
      <input class="fadeIn second" type="email" name="email" placeholder="Nieuwe E-mail">
      <input class="faceIn second" type="email" name="emailv" placeholder="Herhaal E-mail">
      <input class="mt-4 fadeIn third" type="password" name="vpassword" placeholder="Huidig wachtwoord">
      <input class="fadeIn third" type="password" name="vpasswordc" placeholder="Herhaal huidig wachtwoord">
      <input type="submit" class="fadeIn third" value="Aanpassen">
      <div>
        <a class="btn btn-danger fadeIn fourth mb-4" href="index.php?content=myaccount#aanpassen" role="button">Annuleren</a>
      </div>
    </form>
  </div>
</div>