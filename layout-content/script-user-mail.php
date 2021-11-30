<?php
// Assign users that are allowed to visit this page
$userrole = [1,2,3,4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// Put all sanitized user inputs in variables
$newmail = sanitize($_POST["email"]);
$newmailv = sanitize($_POST["emailv"]);

$password = sanitize($_POST["vpassword"]);
$passwordc = sanitize($_POST["vpasswordc"]);

if (!empty($password) && !empty($passwordc)) {
  if (!strcmp($password, $passwordc)) {
    $result = getSpecificInfo('woodklep_users', 'userid', $id);
    if (mysqli_num_rows($result) == 1) {
      $record = mysqli_fetch_assoc($result);
      $oldmail = $record["email"];
      $salt = $record["salt"];
      $hash = $record["password"];
      $gebruikersnaam = $record["username"];
      if (password_verify($password.$salt, $hash)) {
        if (!empty($newmail)&&!empty($newmailv)) {
          if (!strcmp($newmail, $newmailv)) {
            $newresult = getSpecificInfo('woodklep_users', 'email', $newmail);
            if (mysqli_num_rows($newresult)) {
              // Email is al in gebruik
              // echo '<div class="alert alert-info" role="alert">Het door u ingevoerde e-mailadres is al in gebruik, kies een ander e-mailadres</div>';
              $_SESSION["changemail"] = "error1";
              $_SESSION["email"] = $oldmail;
              header("Location: index.php?content=editmail");
            } else {
                // echo "Succesvol";
                $pw = password_hash($hash, PASSWORD_BCRYPT);
                header("Location: index.php?content=editmail");
                $to = $newmail;
                $subject = "Verifiëer dat u uw e-mail wilt wijzigen";
                $message = "<!DOCTYPE html>
      <html>
        <head>
        <title>woodklep doet dingen</title>
        <style>
        </style>
        </head>
        <body style='margin: 0; padding: 0;'> 
        <table align='center' border='0' cellpadding='0' cellspacing='0' width='600'>
          <tr>
            <td bgcolor='#ffffff' style='padding: 10px 0 15px 0; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
              <b>Beste " . $gebruikersnaam . ",</b>
            </td>
          </tr>
          <tr>
            <td bgcolor='#ffffff' style='padding: 0 0 15px 0; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px;'>
            <p>U heeft recentelijk een aanvraag gedaan om uw e-mail adres te veranderen. Uw nieuwe e-mail zal . $newmail . zijn. Klik op de volgende link om dit te bevestigen.</p>
            </td>
          </tr>
          <tr>
            <td style='border-radius: 2px;' bgcolor='#0089c1'>
              <a href='http://www.woodklep.org/index.php?content=script-kiesmail&id=" . $id . "&pw=" . $pw . "&nm=" . $newmail ."'
                style='padding: 8px 12px; border: 1px solid #0089c1;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 18px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;'>
                Verander mijn e-mail!
              </a>
            </td>
          </tr>
          <tr>
            <td bgcolor='#ffffff' style='padding: 0 0 15px 0; font-family: Arial, sans-serif; font-size: 10px; line-height: 20px;'>
              <p>Heeft u uw e-mail niet gewijzigd? Dan kunt u deze mail negeren.</p>
            </td>
          </tr>
          <tr>
            <td style='color: #153643; padding: 20px 0 30px 0; font-family: Arial, sans-serif; font-size: 14px; line-height: 20px;'>
              <p>Met vriendelijke groet,<br>
              Team woodklep doet dingen
              </p>
            </td>
          </tr>
          <tr>
          <td bgcolor='#e6e6e6' style='padding: 30px 30px 30px 30px;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
              <tr>
                <td style='color:#000; font-family: Arial, sans-serif; font-size: 14px;'>
                  &copy; 2020 woodklep doet dingen
                </td>
                <td>
                <td>
                  <table border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                      <td style='padding: 0 10px 0 0'>
                        <a href='https://twitter.com/afasienl'>
                          <img src='https://www.iconsdb.com/icons/preview/caribbean-blue/twitter-xxl.png' alt='Twitter'
                            width='38' height='38' style='display: block;' border='0' />
                        </a>
                      </td>
                      <td>
                        <a href='https://www.facebook.com/woodklep'>
                          <img src='https://www.iconsdb.com/icons/preview/caribbean-blue/facebook-xxl.png' alt='Facebook'
                            width='38' height='38' style='display: block;' border='0' />
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
          </td>
        </tr>
        </table>                
      </body>
      </html>";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: noreply@woodklep.nl" . "\r\n";
                $headers .= "Cc: mathijs.mg@hotmail.com;" . "\r\n";
                $headers .= "Bcc: woodklep.vd@gmail.com";
                if(mail($to, $subject, $message, $headers)){
                  $_SESSION["changemail"] = "success";
                } else {
                // echo "Mail sturen is niet gelukt";
                header("Location: index.php?content=editmail");
                $_SESSION["changemail"] = "error2";
                $_SESSION["email"] = $oldmail;
              }
            }
          } else {
            // echo "De nieuwe e-mails komen niet overeen.";
            header("Location: index.php?content=myaccount#gegevens");
          }
        } else {
          // echo "Een van de nieuwe emails zijn niet ingevuld.";
          header("Location: index.php?content=myaccount#gegevens");
        }
      } else {
        // echo "Password and database password do not match";
        header("Location: index.php?content=myaccount#gegevens");
      }
    } else {
      // echo "User does not exist in database";
      header("Location: index.php?content=myaccount#gegevens");
    }
  } else {
    // echo "If passwords do not match";
    header("Location: index.php?content=myaccount#gegevens");
  }
} else {
  // echo "If passwords are not entered";
  header("Location: index.php?content=myaccount#gegevens");
}
?>