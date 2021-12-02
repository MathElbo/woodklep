<?php $content = (isset($_GET['content']) ? $_GET['content'] : false); ?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <?php
  if (isset($_SESSION["userrole"])){
    switch($_SESSION["userrole"]) {
      case "1": echo '<a class="navbar-brand" href="./index.php?content=studenthome"><div class="navLogoText">
        Woodklep.org
        <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">
        </div>
        </a>';
      break;
      case "2": echo '<a class="navbar-brand" href="./index.php?content=parenthome"><div class="navLogoText">
        Woodklep.org
        <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">
        </div>
        </a>';
      break;
      case "3": echo '<a class="navbar-brand" href="./index.php?content=teacherhome"><div class="navLogoText">
        Woodklep.org
        <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">
        </div>
        </a>';
      break;
      default: echo '<a class="navbar-brand" href="./index.php?content=homepage"><div class="navLogoText">
        Woodklep.org
        <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">
        </div>
        </a>';
      break;
    }
  }
  else {
    echo '<a class="navbar-brand" href="./index.php?content=homepage"><div class="navLogoText">
      Woodklep.org
      <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">
      </div>
      </a>';
  }
  ?>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <?php
      if (isset($_SESSION["userrole"])) {
        switch ($_SESSION["userrole"]) {
          case "1":
            echo "<li><a class='nav-link' href='index.php?content=studenthome'>Home</a></li>";
            break;
          case "2":
            echo "<li><a class='nav-link' href='index.php?content=parenthome'>Home</a></li>";
            break;
          case "3":
            echo "<li><a class='nav-link' href='index.php?content=teacherhome'>Home</a></li>";
            break;
          default: 
            echo "<li><a class='nav-link' href='index.php?content=homepage'>Home</a></li>";
            break;
        }
      }
      else {
        echo "<li><a class='nav-link' href='index.php?content=homepage'>Home</a></li>";
      }
      ?>
      <li class="<?php if ($content == 'contact') echo 'active' ?> nav-item">
        <a class="nav-link" href="index.php?content=contact">Contact</a></li>
        <li class="<?php if ($content == 'overons') echo 'active' ?> nav-item">
        <a class="nav-link" href="index.php?content=overons">Over ons</a></li>
      <?php 
      if (empty($_SESSION["id"])) {
        echo "<li><class='";
        if ($content == ' inloggen') echo 'active';
        echo " nav-item>
        <a class ='nav-link' href='index.php?content=inloggen'>Inloggen</a></li>";
      }
        if (isset($_SESSION["id"])) {
        echo "
      <li><a class='nav-link' href='index.php?content=myexercises'>Mijn opdrachten</a></li>
      <li><a class='nav-link' href='index.php?content=myaccount'>Mijn account</a></li>
      <li><a class='nav-link' href='index.php?content=uitloggen'>Uitloggen</a></li>
      ";
      }
      ?> 
    </ul>
  </div>
</nav>