<?php
  if ( !isset($_SESSION["id"])) {
    echo '<div class="alert alert-danger" role="alert">U bent niet ingelogd, U wordt doorgestuurd naar de homepage.</div>';
    header("Refresh: 4; url=./index.php?content=homepage");
    exit();
  } else if ( !in_array($_SESSION["userrole"], $userrole )) {
    echo '<div class="alert alert-danger" role="alert">U heeft niet de juiste gebruikerrol voor deze pagina.</div>';
    header("Refresh: 4; url=./index.php?content=homepage");
    exit();
  }
?>