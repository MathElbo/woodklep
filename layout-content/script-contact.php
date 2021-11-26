<?php

error_reporting(0);

// E-mailadres van de ontvanger
$mail_ontv = 'woodklep@gmail.com';

// set datum 
$datum = date('d/m/Y H:i:s');

$inhoud_mail = "Ingevuld contact formuliervan: " . $_SERVER['HTTP_HOST'] . "\n";
$inhoud_mail .=  "Naam: " . htmlspecialchars($_POST['name']) . "\n";
$inhoud_mail .= "E-mail adres: " . htmlspecialchars($_POST['email']). "\n";
$inhoud_mail .= "Bericht: \n";
$inhoud_mail .= htmlspecialchars($_POST['bericht']) . "\n\n";
$inhoud_mail .= "Verstuurd op " . $datum . " via het IP adres " . $_SERVER['REMOTE_ADDR'] . "\n\n";
$headers = 'From: ' . htmlspecialchars($_POST['name']) . ' <' . $_POST['email'] . '>';  
if (mail($mail_ontv, "Ingediend Contactforumulier door " . htmlspecialchars($_POST['name']), $inhoud_mail, $headers))
{   echo '<div class="jumbotron jumbotron-fluid homeJumbo">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h1 class="display-4">Het contactformulier is verzonden</h1>
                        <p class="lead">Bedankt voor het invullen van het contactformulier. We zullen zo spoedig mogelijk contact met u opnemen.</p>
                    </div>                
                </div>
            </div>
        </div>
    </div>';
}
else
{
    echo '<div class="jumbotron jumbotron-fluid homeJumbo">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h1 class="display-4">Het contactformulier is niet verzonden</h1>
                        <p class="lead"><b>Onze excuses.</b> Het contactformulier kon niet verzonden worden.</p>
                    </div>                
                </div>
            </div>
        </div>
    </div>';
}
?>