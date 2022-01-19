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

exec("mode COM5 BAUD=115200 PARITY=n data=8 stop=1 xon=off");

$fp = fopen ("COM5", "w");

$data = "Hellow World";

fwrite($fp, $data);

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
    }
}
?>

</body>
</html>