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
        <a class="nav-link" href="index.php?content=overons">over ons</a></li>
      <li class="<?php if ($content == 'inloggen') echo 'active' ?> nav-item">
        <a class="nav-link" href="index.php?content=inloggen">Inloggen</a></li>

    </ul>

    <a href="index.php?content=redirect"><i class="fas fa-user" title="Mijn account"></i></a>
    <?php if (isset($_SESSION["id"])) {
      echo "<a href='index.php?content=uitloggen'><i class='fas fa-sign-out-alt'></i></a>";
        } 
    ?>
  </div>
</nav>