<?php
// Assign users that are allowed to visit this page
$userrole = [1,2,3,4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// Put all sanitized user inputs in variables
$streetname = sanitize($_POST["streetname"]);
$postalcode = sanitize($_POST["postalcode"]);
$housenumber = sanitize($_POST["housenumber"]);
$city = sanitize($_POST["city"]);

$password = sanitize($_POST["vpassword"]);
$passwordc = sanitize($_POST["vpasswordc"]);

if (!empty($password) && !empty($passwordc)) {
  if (!strcmp($password, $passwordc)) {
    $result = getSpecificInfo('woodklep_users', 'userid', $id);

    if (mysqli_num_rows($result) == 1) {
      $record = mysqli_fetch_assoc($result);
      $salt = $record["salt"];
      $hash =  $record["password"];

      if (password_verify($password.$salt, $hash)) {
        $sql = "UPDATE `woodklep_personalinfo` 
                SET `housenumber` = '$housenumber',
                    `streetname` = '$streetname',
                    `postalcode` = '$postalcode',
                    `city` = '$city'
                WHERE `userid` = '$id';";

        $result = mysqli_query($conn, $sql);

        if ($result) {
          echo "User personal living info was succesfully edited";
          header("Location: index.php?content=myaccount#gegevens");
        } else {
          echo "Query was not send to database";
          header("Location: index.php?content=myaccount#gegevens");
        }
      } else {
        echo "Password and database password do not match"; 
        header("Location: index.php?content=myaccount#gegevens");
      }
    } else {
      echo "User does not exist in database";
      header("Location: index.php?content=myaccount#gegevens");
    }
  } else {
    echo "If passwords do not match";
    header("Location: index.php?content=myaccount#gegevens");
  }
} else {
  echo "If passwords or password is/are not entered";
  header("Location: index.php?content=myaccount#gegevens");
}

?>