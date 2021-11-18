<?php
// Assign users that are allowed to visit this page
$userrole = [1,2,3,4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// Put all sanitized user inputs in variables
$newpassword = sanitize($_POST["newpassword"]);
$vnewpassword = sanitize($_POST["vnewpassword"]);

$password = sanitize($_POST["vpassword"]);
$passwordc = sanitize($_POST["vpasswordc"]);

if (!empty($password) && !empty($passwordc)) {
  if (!strcmp($password, $passwordc)) {
    $result = getSpecificInfo('pro4_users', 'userid', $id);

    if (mysqli_num_rows($result) == 1) {
      $record = mysqli_fetch_assoc($result);
      $salt = $record["salt"];
      $hash = $record["password"];

      if (password_verify($password.$salt, $hash)) {
        if (!empty($newpassword) && !empty($vnewpassword)) {
          if (!strcmp($newpassword, $vnewpassword)) {
            $hash = RandomString();
            $blowfish = password_hash($newpassword.$hash, PASSWORD_BCRYPT);

            $sql = "UPDATE `pro4_users` 
                        SET `password` = '$blowfish',
                            `salt` = '$hash'
                      WHERE `userid` = $id";

            $result = mysqli_query($conn, $sql);
            
            if ($result) {
              // echo "Succesvol";
              header("Location: index.php?content=myaccount#gegevens");
            } else {
              // echo "SQL Query is niet gelukt";
              header("Location: index.php?content=myaccount#gegevens");
            }
          } else {
            // echo "De nieuwe wachtwoorden komen niet overeen.";
            header("Location: index.php?content=myaccount#gegevens");
          }
        } else {
          // echo "Een van de nieuwe wachtwoorden zijn niet ingevuld.";
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