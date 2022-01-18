<!DOCTYPE html>
<html>
<head>
<title>microbit test</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
</head>
<body>
<article>
<h1>Test website microbit</h1>
<?php


function helloWorld(){

exec("mode COM3 BAUD=115200 PARITY=n data=8 stop=1 xon=off");

$fp = fopen ("COM3", "w");

$data = ",Hellow World,";

fwrite($fp, $data);

fclose($fp);

}

function NewWorld() {
    $output = system(`mode COM3: BAUD=115200 PARITY=N data=8 stop=1 XON=off TO=on`);
    $fp = fopen('COM3', 'w');
    $writtenBytes = fwrite($fp, ",Hello,");
    fclose($fp);
}
?>

<form action='index.php' method='POST'>
    <input type='submit' name='action' value='Test'/>
</form>

<?php
if (isset($_POST) && !empty($_POST)) {
if ($_POST['action']=='Test') {
        helloWorld();
        header('Location: index.php?content=qingstest');
    }
}
?>

</body>
</html>