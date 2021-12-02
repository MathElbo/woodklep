<?php
$userrole = [3,4];
include("./php-scripts/security.php");
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
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <h2 class="display-4">Mijn groepen</h2>
        <h4 class="lead">Nieuwe groep</h4>
        <!-- Nieuwe groep -->
        <form action="index.php?content=script-newgroup" method="post">
          <div class="form-group">
            <input class="form-control" type="name" name="name" id="name" placeholder="Groepsnaam" required>
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
            <input class="btn btn-dark" type="submit" value="Opslaan">
          </div>
        </form>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h2 class="display-4">Mijn leerlingen</h2>
        <h4 class="lead">Test 2</h4>
      </div>
    </div>
  </div>
</section>