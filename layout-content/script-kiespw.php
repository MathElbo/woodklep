<?php
if (isset($_SESSION["choosepw"]))
  switch ($_SESSION["choosepw"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Uw wachtwoord is ingesteld. U wordt doorgestuurd naar de inlog pagina.";
      unset($_SESSION["choosepw"]);
      header("Refresh: 4; url=./index.php?content=redirect");
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "U heeft één of beide wachtwoorden niet ingevuld.";
      unset($_SESSION["choosepw"]);
      break;
    case "error2":
      $pwclasses = "error";
      $msg = "Uw opgegeven wachtwoorden komen niet overeen.";
      unset($_SESSION["choosepw"]);
      break;
    case "error3":
      $pwclasses = "error";
      $msg = "Oeps, er is iets mis gegaan! Probeert u opnieuw. Error3";
      unset($_SESSION["choosepw"]);
      break;
    case "error4":
      $pwclasses = "error";
      $msg = "Oeps, er is iets mis gegaan! Probeert u opnieuw. Error4";
      unset($_SESSION["choosepw"]);
      break;
    case "error5":
      $pwclasses = "error";
      $msg = "Oeps, er is iets mis gegaan! Probeert u opnieuw. Error5";
      unset($_SESSION["choosepw"]);
      break;
  }
?>

<section class="container-fluid content-kiespw">
  <div class="container">
    <div class="row">

      <!-- Inlog form -->
      <div class="col-12 col-md-11 offset-md-1">
        <h2>Registratie afronden</h2>
      </div>
      <div class="col-12 col-md-5 offset-md-1">
        <form action="./index.php?content=script-kiespwverify" method="post">
          <div class="form-group">
            <input class="form-control" type="password" name="password" id="password" placeholder="Wachtwoord" required>
            <input class="form-control" type="password" name="checkpassword" id="checkpassword"
              placeholder="Herhaal wachtwoord" required>
            <input class="btn btn-primary" type="submit" value="Wachtwoord bevestigen">
            <input type="hidden" value="<?php if (isset($_GET["id"])) echo $_GET["id"]; ?>" name="id">
            <input type="hidden" value="<?php if (isset($_GET["id"])) echo $_GET["pw"]; ?>" name="pw">
          </div>
        </form>
      </div>
      <!-- Error message display -->
      <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
      </div>
    </div>
  </div>
</section>