<?php
  include("./php-scripts/connectDB.php");
  include("./php-scripts/functions.php");

  $id = $_SESSION['id'];
  $opdracht = $_POST['opdracht'];
  $ki = $_POST['ki'];
  $li = $_POST['li'];
  $wk = $_POST['wk'];

  $sql1 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdracht";
  $res1 = mysqli_query($conn, $sql1);
  if (!empty($res1)) {
      $sql2 = "SELECT * FROM `wk_leerling_koppel` WHERE `wk_id` = $wk";
      $res2 = mysqli_query($conn, $sql2);
      $rec2 = mysqli_fetch_array($res2);
      if($rec2['wkopdracht']==$opdracht) {
          //huiswerkopdracht is al gekoppeld
          $_SESSION['koppelopdracht'] = 'error2';
          header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
      }
      else {
          $sql3 = "UPDATE `wk_leerling_koppel` SET `wkopdracht` = $opdracht WHERE `wk_id` = $wk";
          $res3 = mysqli_query($conn, $sql3);
          if($res3){
              $sql4 = "SELECT * FROM `student_opdracht_voortgang` WHERE `opdracht_id` = $opdracht AND `studentid` = $li";
              $res4 = mysqli_query($conn, $sql4);
              if (!empty($res4)) {
                  $rec4 = mysqli_fetch_array($res4);
                  if($rec4['gemaakt']==1) {
                    $opendicht = 1;
                  }
                  else {
                      $opendicht = 0;
                  }
              }
              else {
                  $opendicht = 0;
              }
              $sql5 = "UPDATE `woodklep_status` SET `locked` = $opendicht WHERE `woodklep_id` = $wk";
              $res5 = mysqli_query($conn, $sql5);
              if ($res5) {
                  //Succesvol
              $_SESSION['koppelopdracht'] = 'success';
              header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
              }
              else {
                  //Er ging iets mis in de SQL Query
              $_SESSION['koppelopdracht'] = 'error3';
              header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
              }
          }
          else {
              //Er ging iets mis in de SQL Query
              $_SESSION['koppelopdracht'] = 'error3';
              header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
          }
      }
  }
  else {
      //Huiswerkopdracht bestaat niet
      $_SESSION['koppelopdracht'] = 'error1';
      header("Location: index.php?content=leerlingoverzicht&ki=$ki&li=$li");
  }