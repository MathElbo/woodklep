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
      <i class="fas fa-edit fa-5x"></i>
      <p>Gegevens wijzigen</p>
    </div>

    <!-- Wijzigingsformulier adres gegevens -->
    <form action="index.php?content=script-user-pinfo" method="post" class="vlr">
      <input class="fadeIn second" type="text" name="name" placeholder="Voornaam" value="<?php echo $pinfo["name"]; ?>">
      <input class="fadeIn second" type="text" name="infix" placeholder="Tussenvoegsel" value="<?php echo $pinfo["infix"]; ?>">
      <input class="fadeIn second" type="text" name="lastname" placeholder="Achternaam" value="<?php echo $pinfo["lastname"]; ?>">
      <input class="fadeIn second" type="date" name="birthday" placeholder="Geboortedatum" value="<?php echo $pinfo["birthday"]; ?>">
      <input class="mt-4 fadeIn third" type="password" name="vpassword" placeholder="Huidig wachtwoord">
      <input class="fadeIn third" type="password" name="vpasswordc" placeholder="Herhaal huidig wachtwoord">
      <input type="submit" class="fadeIn third" value="Aanpassen">
      <div>
        <a class="btn btn-danger fadeIn fourth mb-4" href="index.php?content=myaccount#aanpassen" role="button">Annuleren</a>
      </div>
    </form>
  </div>
</div>