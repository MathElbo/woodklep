<?php
// Assign users that are allowed to visit this page
$userrole = [1, 2, 3, 4];
include("./php-scripts/security.php");

// Include connectDB and set variables
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];

// get assignment_id
if (isset($_GET["aid"])) {
    $assignmentid = $_GET["aid"];
} else {
    echo "error";
}

//count rows
$sql = "SELECT * from `opdrachtvraag_koppel`";
$result = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($result);


// Put applicable Vraag_Id's into array vraag
$vraag = array();

for ($i = 1; $i <= $rows; $i++) {
    $sql1 = "SELECT * from `opdrachtvraag_koppel`
    where ov_koppel = '$i'";
    $result1 = mysqli_query($conn, $sql1);
    $ovk = mysqli_fetch_assoc($result1);
    if ($ovk["opdracht_id"] == $assignmentid) {
        $vraag[] = $ovk["vraag_id"];
    }
}

$j = count($vraag);
for ($i = 1; $i <= $j; $i++) {
    $k = $i - 1;
    $l = $vraag["$k"];
    $antwoord = sanitize($_POST["antwoord$i"]);
    $sql = "UPDATE `student_antwoord` SET `antwoord` = '$antwoord'
    WHERE (studentid = $id AND vraag_id = $l)";
    $result = mysqli_query($conn, $sql);
    if ($result){};
    }


header("Location: index.php?content=myassignment&aid=$assignmentid")
?>