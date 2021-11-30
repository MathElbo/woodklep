<?php
  include("./php-scripts/connectDB.php");
  include("./php-scripts/functions.php");

  //$username = sanitize($_POST["username"]);
  $password = sanitize($_POST["password"]);
  $checkpassword = sanitize($_POST["checkpassword"]);
  $id = sanitize($_POST["id"]);
  $nm = sanitize($_POST["nm"]);
  $pw = sanitize($_POST["pw"]);

  if ( !empty($password) && !empty($checkpassword)) {
    if ( !strcmp($password, $checkpassword)) {
      $result = getSpecificInfo('woodklep_users', 'userid', $id);
      if ( mysqli_num_rows($result) == 1 ) {
        $record = mysqli_fetch_assoc($result);
        $oldmail = $record["email"];
        $salt = $record["salt"];
        $hash = $record["password"];
        $gebruikersnaam = $record["username"];
        if (password_verify($password.$salt, $hash)) {
          if (password_verify($hash, $pw)) {
            $sql = "UPDATE `woodklep_users` 
                        SET `email` = '$nm'
                      WHERE `userid` = $id";

            $result = mysqli_query($conn, $sql);
            if ( $result ) {
              $_SESSION["kiesmail"] = "success";
              header("Location: index.php?content=script-kiesmail");
            } else {
              $_SESSION["kiesmail"] = "error1";
              header("Location: index.php?content=script-kiesmail&id=$id&pw$pw&nm=$nm");
            }
          }
          else {
            // het id en password matchen niet
            $_SESSION["choosepw"] = "error6";
            header("Location: index.php?content=script-kiesmail&id=$id&pw=$pw&nm=$nm");
          }
        } else {
            // echo "Password and database password do not match";
            $_SESSION["kiesmail"] = "error2";
            header("Location: index.php?content=script-kiesmail&id=$id&pw=$pw&nm=$nm");
        }
      } else {
        // Het id is niet bekend
        $_SESSION["kiesmail"] = "error3";
        header("Location: index.php?content=script-kiesmail&id=$id&pw=$pw&nm=$nm");
      }     
    } else {
      $_SESSION["kiesmail"] = "error4";
      header("Location: index.php?content=script-kiesmail&id=$id&pw=$pw&nm=$nm");
    } 
  } else {
    $_SESSION["kiesmail"] = "error5";
    header("Location: index.php?content=script-kiesmail&id=$id&pw=$pw&nm=$nm");
  }  
?>