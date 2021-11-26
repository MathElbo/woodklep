<?php
  include("./php-scripts/connectDB.php");
  include("./php-scripts/functions.php");

  //$username = sanitize($_POST["username"]);
  $password = sanitize($_POST["password"]);
  $checkpassword = sanitize($_POST["checkpassword"]);
  $id = sanitize($_POST["id"]);
  $pw = sanitize($_POST["pw"]);

  if ( !empty($password) && !empty($checkpassword)) {
    if ( !strcmp($password, $checkpassword)) {

      // Check met een select of het id bestaat in de database en of het gehashte password matched met het id
      $sql = "SELECT * FROM `woodklep_users` WHERE `userid` = $id;";

      $result = mysqli_query($conn, $sql);

      if ( mysqli_num_rows($result) == 1 ) {
        $record = mysqli_fetch_assoc($result);
        $dbpass = $record["password"];

        if (password_verify($dbpass, $pw)) {
          $salt = RandomString();
          $hashed_password = password_hash($password.$salt, PASSWORD_BCRYPT);
  
          $sql = "UPDATE `woodklep_users` 
                  SET `password` = '$hashed_password',
                      `salt` = '$salt'
                  WHERE `userid` = $id";
  
          $result = mysqli_query($conn, $sql);

          if ( $result ) {
            $_SESSION["choosepw"] = "success";
            header("Location: index.php?content=script-kiespw");
          } else {
            $_SESSION["choosepw"] = "error5";
            header("Location: index.php?content=script-kiespw&id=$id&pw=$pw");
          }
  
        } else {
          // het id en password matchen niet
          $_SESSION["choosepw"] = "error4";
          header("Location: index.php?content=script-kiespw&id=$id&pw=$pw");
        }
      } else {
        // Het id is niet bekend
        $_SESSION["choosepw"] = "error3";
        header("Location: index.php?content=script-kiespw&id=$id&pw=$pw");
      }     
    } else {
      $_SESSION["choosepw"] = "error2";
      header("Location: index.php?content=script-kiespw&id=$id&pw=$pw");
    } 
  } else {
    $_SESSION["choosepw"] = "error1";
    header("Location: index.php?content=script-kiespw&id=$id&pw=$pw");
  }  
?>