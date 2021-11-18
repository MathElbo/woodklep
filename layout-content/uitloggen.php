<?php
  $userrole = [1,2,3,4];
  include("./php-scripts/security.php");

  session_unset();
  session_destroy();
  header("Refresh: 5; url=./index.php?content=homepage");
?>

<!-- Inloggen -->
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Icon -->
    <div class="fadeIn first">
      <i class="fas fa-sign-out-alt fa-5x"></i>
      <p>U bent succesvol uitgelogd.<br>
        U zult nu worden doorverwezen naar onze startpagina.</p>
    </div>
    <!-- Login formulier -->
    <form class="vlr">
      
    </form>
  </div>
</div>