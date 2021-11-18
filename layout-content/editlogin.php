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
?>

<!-- Wijzigen -->
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fa fa-lock fa-5x"></i>
      <p>Inlog gegevens wijzigen</p>
    </div>

    <!-- Wijzigingsformulier -->
    <form action="index.php?content=script-user-login" method="post" class="vlr">
      <input class="fadeIn second" type="password" name="newpassword" placeholder="Nieuwe wachtwoord">
      <input class="fadeIn second" type="password" name="vnewpassword" placeholder="Herhaal nieuwe wachtwoord">
      <hr>
      <input class="fadeIn second" type="password" name="vpassword" placeholder="Huidig wachtwoord">
      <input class="fadeIn second" type="password" name="vpasswordc" placeholder="Herhaal huidig wachtwoord">
      <input type="submit" class="fadeIn third" value="Aanpassen">
      <div>
        <a class="btn btn-danger fadeIn fourth mb-4" href="index.php?content=myaccount#aanpassen" role="button">Annuleren</a>
      </div>
    </form>
  </div>
</div>