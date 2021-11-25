<?php
//session_start(); // zorg ervoor dat session_start ALTIJD bovenaan ALLES van je pagina staat, anders werkt het niet!
 
/*******************************
*        CONTACT FORMULIER                     *
*        contactformulier.php             *
*                                                             *
*        Author: Miranda Verburg         *
*        Datum: 10 september 2010     *
*                                                             *
*        Pas het e-mail adres aan     *
*        bij $mail_ontv en upload   *
*        het naar je webserver..         *
********************************/

// E-mailadres van de ontvanger
$mail_ontv = 'woodklep@gmail.com'; // <<<----- voer jouw e-mailadres hier in!

// Speciale checks voor naam en e-mailadres
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // naam controle
    if (empty($_POST['naam']))
        $naam_fout = 1;
    // e-mail controle
    if (function_exists('filter_var') && !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
            $email_fout = 1;
    // antiflood controle
    if (!empty($_SESSION['antiflood']))
    {
        $seconde = 20; // 20 seconden voordat dezelfde persoon nog een keer een e-mail mag versturen
        $tijd = time() - $_SESSION['antiflood'];
        if($tijd < $seconde)
            $antiflood = 1;
    }
}

// Kijk of alle velden zijn ingevuld - naam mag alleen uit letters bestaan en het e-mailadres moet juist zijn
if (($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($antiflood) || empty($_POST['naam']) || !empty($naam_fout) || empty($_POST['mail']) || !empty($email_fout) || empty($_POST['bericht']) || empty($_POST['onderwerp']))) || $_SERVER['REQUEST_METHOD'] == 'GET')
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (!empty($naam_fout))
            echo '<p>Uw naam is niet ingevuld.</p>';
        elseif (!empty($email_fout))
            echo '<p>Uw e-mailadres is niet juist.</p>';
        elseif (!empty($antiflood))
            echo '<p>U mag slechts &eacute;&eacute;n bericht per ' . $seconde . ' seconde versturen.</p>';
        else
            echo '<p>U bent uw naam, e-mailadres, onderwerp of bericht vergeten in te vullen.</p>';
    }
        
  // HTML e-mail formlier
  echo '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '" />
  <p>
  
      <label for="naam">Naam:</label><br />
      <input type="text" id="naam" name="naam" value="' . (isset($_POST['naam']) ? htmlspecialchars($_POST['naam']) : '') . '" /><br />
      
      <label for="mail">E-mailadres:</label><br />
      <input type="text" id="mail" name="mail" value="' . (isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '') . '" /><br />
      
      <label for="onderwerp">Onderwerp:</label><br />
      <input type="text" id="onderwerp" name="onderwerp" value="' . (isset($_POST['onderwerp']) ? htmlspecialchars($_POST['onderwerp']) : '') . '" /><br />
      
      <label for="bericht">Bericht:</label><br />
      <textarea id="bericht" name="bericht" rows="8" style="width: 400px;">' . (isset($_POST['bericht']) ? htmlspecialchars($_POST['bericht']) : '') . '</textarea><br />
      
      <input type="submit" name="submit" value=" Versturen " />
  </p>
  </form>';
}
// versturen naar
else
{      
  // set datum
  $datum = date('d/m/Y H:i:s');
    
  $inhoud_mail = "===================================================\n";
  $inhoud_mail .= "Ingevulde contact formulier " . $_SERVER['HTTP_HOST'] . "\n";
  $inhoud_mail .= "===================================================\n\n";
  
  $inhoud_mail .= "Naam: " . htmlspecialchars($_POST['naam']) . "\n";
  $inhoud_mail .= "E-mail adres: " . htmlspecialchars($_POST['mail']) . "\n";
  $inhoud_mail .= "Bericht:\n";
  $inhoud_mail .= htmlspecialchars($_POST['bericht']) . "\n\n";
    
  $inhoud_mail .= "Verstuurd op " . $datum . " via het IP adres " . $_SERVER['REMOTE_ADDR'] . "\n\n";
    
  $inhoud_mail .= "===================================================\n\n";
  
  // --------------------
  // spambot protectie
  // ------
  // van de tutorial: http://www.phphulp.nl/php/tutorial/beveiliging/spam-vrije-contact-formulieren/340/
  // ------
  
  $headers = 'From: ' . htmlspecialchars($_POST['naam']) . ' <' . $_POST['mail'] . '>';
  
  $headers = stripslashes($headers);
  $headers = str_replace('\n', '', $headers); // Verwijder \n
  $headers = str_replace('\r', '', $headers); // Verwijder \r
  $headers = str_replace("\"", "\\\"", str_replace("\\", "\\\\", $headers)); // Slashes van quotes
  
  $_POST['onderwerp'] = str_replace('\n', '', $_POST['onderwerp']); // Verwijder \n
  $_POST['onderwerp'] = str_replace('\r', '', $_POST['onderwerp']); // Verwijder \r
  $_POST['onderwerp'] = str_replace("\"", "\\\"", str_replace("\\", "\\\\", $_POST['onderwerp'])); // Slashes van quotes
  
  if (mail($mail_ontv, $_POST['onderwerp'], $inhoud_mail, $headers))
  {
      // zorg ervoor dat dezelfde persoon niet kan spammen
      $_SESSION['antiflood'] = time();
      
      echo '<h1>Het contactformulier is verzonden</h1>
      
      <p>Bedankt voor het invullen van het contactformulier. We zullen zo spoedig mogelijk contact met u opnemen.</p>';
  }
  else
  {
      echo '<h1>Het contactformulier is niet verzonden</h1>
      
      <p><b>Onze excuses.</b> Het contactformulier kon niet verzonden worden.</p>';
  }
}
?>