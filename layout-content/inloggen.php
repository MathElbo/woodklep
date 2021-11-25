<?php
// Check if session variable is set.
if (isset($_SESSION["login"]))
  switch ($_SESSION["login"]) {
    case "success":
      $pwclasses = "success";
      $msg = "U bent succesvol ingelogd. U wordt nu doorverwezen naar de inlog pagina.";
      header("Refresh: 4; url=./index.php?content=redirect");
      unset($_SESSION["login"]);
      break;
    case "shop":
      $pwclasses = "success";
      $msg = "Om uw bestelling te plaatsen moet u eerst inloggen.";
      unset($_SESSION["login"]);
      break;
    case "error1":
      $pwclasses = "error";
      $msg = "Één of meerdere vereiste gegevens zijn niet ingevuld.";
      unset($_SESSION["login"]);
      break;
    case "error2":
      $pwclasses = "error";
      $msg = "Uw opgegeven email of wachtwoord is onjuist.";
      unset($_SESSION["login"]);
      break;
    case "error3":
      $pwclasses = "error";
      $msg = "Uw opgegevens email of wachtwoord is onjuist.";
      unset($_SESSION["login"]);
      break;
  }

// Check if session variable is set.
if (isset($_SESSION["register"])) {
  switch ($_SESSION["register"]) {
    case "error":
      $pwclasses = "error";
      $msg = "Het ingevoerde e-mail adres is al in gebruik.";
      $email = $_SESSION["email"];
      unset($_SESSION["register"]);
      break;
    case "success":
      $pwclasses = "success";
      $msg = "Er is een verificatiemail naar uw e-mail adres gestuurd.";
      $email = $_SESSION["email"];
      unset($_SESSION["register"]);
      unset($_SESSION["email"]);
      break;
    }
  }
?>



<section class="container-fluid content-inloggen">
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
        <h2>Inloggen en Registreren</h2>
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <p>Bestaande klant:</p>
        <form action="index.php?content=script-inloggen" method="post">
          <div class="form-group">
            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" required>
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
            <input class="btn btn-dark" type="submit" value="Log In">
          </div>
        </form>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <p>Nieuw bij WoodKlep doet dingen</p>
        <form action="index.php?content=script-aanmelden" method="post">
          <div class="form-group">
            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" required>
            <input class="btn btn-dark" type="submit" value="Register">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>