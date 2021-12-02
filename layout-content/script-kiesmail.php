<?php
if (isset($_SESSION["kiesmail"]))
  switch ($_SESSION["kiesmail"]) {
    case "success":
      $pwclasses = "success";
      $msg = "Uw email is ingesteld. U wordt doorgestuurd naar de inlog pagina.";
      unset($_SESSION["kiesmail"]);
      $userrole = [1,2,3,4];
      session_unset();
      session_destroy();
      header("Refresh: 4; url=./index.php?content=redirect");
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Er ging iets mis, probeer het later opnieuw!";
      unset($_SESSION["kiesmail"]);
      break;
    case "error2":
      $pwclasses = "error";
      $msg = "Uw wachtwoord is niet juist.";
      unset($_SESSION["choosepw"]);
      break;
    case "error3":
      $pwclasses = "error";
      $msg = "Uw identiteit is ons niet bekend.";
      unset($_SESSION["kiesmail"]);
      break;
    case "error4":
      $pwclasses = "error";
      $msg = "Uw opgegeven wachtwoorden komen niet overeen.";
      unset($_SESSION["kiesmail"]);
      break;
    case "error5":
      $pwclasses = "error";
      $msg = "U heeft één of beide wachtwoorden niet ingevuld.";
      unset($_SESSION["kiesmail"]);
      break;
    case "error6": 
      $pwclasses = "error";
      $msg = "Er ging iets mis! Probeer het later opnieuw!";
      unset($_SESSION["kiesmail"]);
      break;
  }
?>

<section class="container-fluid content-kiespw">
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
      <!-- Inlog form -->
      <div class="col-12 col-md-11 offset-md-1">
        <h2>Bevestig e-mail wijziging</h2>
      </div>
      <div class="col-12 col-md-5 offset-md-1">
        <form action="./index.php?content=script-kiesmailverify" method="post">
          <div class="form-group">
            <input class="form-control" type="password" name="password" id="password" placeholder="Wachtwoord" required>
            <input class="form-control" type="password" name="checkpassword" id="checkpassword"
              placeholder="Herhaal wachtwoord" required>
            <input class="btn btn-primary" type="submit" value="e-mail wijzinging bevestigen">
            <input type="hidden" value="<?php if (isset($_GET["id"])) echo $_GET["id"]; ?>" name="id">
            <input type="hidden" value="<?php if (isset($_GET["id"])) echo $_GET["pw"]; ?>" name="pw">
            <input type="hidden" value="<?php if (isset($_GET["id"])) echo $_GET["nm"]; ?>" name="nm">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>