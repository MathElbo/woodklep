<?php
// Schoonmaken data input
function sanitize($raw_data)  {
    // search for $conn outside of the function
    global $conn;
    // Removes special characters from string
    $data = mysqli_real_escape_string($conn, $raw_data);
    // Converts special characters to HTMl entities
    $data = htmlspecialchars($data);
    // returns variable $data
    return $data;
}

// Salt
function RandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

// Get all from tables
function getInfo($tablename) {
  global $conn;
  $sql = "SELECT * FROM `$tablename`";

  $result = mysqli_query($conn, $sql);

  return $result;
}

// Get product information
function getSpecificInfo($tablename, $columnid, $id) {
  global $conn;
  $sql = "SELECT * FROM `$tablename` WHERE `$columnid` = '$id'";

  $result = mysqli_query($conn, $sql);

  return $result;
}
?>