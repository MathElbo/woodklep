<?php
// Stuurt gebruiker door naar hun eigen pagina als ze zijn ingelogd, zo niet worden ze doorgestuurd naar inlog pagina.
if (isset($_SESSION["userrole"]))
  switch ($_SESSION["userrole"]) {
    case "1":
      header("Location: index.php?content=studenthome");
      break;
    case "2":
      header("Location: index.php?content=parenthome");
      break;
    case "3":
      header("Location: index.php?content=teacherhome");
      break;
    case "4":
      header("Location: index.php?content=myaccount");
      break;
  } else {
  header("Location: index.php?content=inloggen");
}
