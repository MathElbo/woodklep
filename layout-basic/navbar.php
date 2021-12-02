<?php $content = (isset($_GET['content']) ? $_GET['content'] : false); ?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="./index.php?content=homepage">
    <div class="navLogoText">
      Woodklep.org
      <img src="./assets/img/nlogo.jpg" class="d-inline-block align-top navLogo">

    </div>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="<?php if ($content == 'homepage') echo 'active' ?> nav-item">
        <a class="nav-link" href="./index.php?content=homepage">Home</a></li>
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