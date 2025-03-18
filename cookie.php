<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <input type="text" name="t1"/>
    <button type="submit" name = "button">Click Bro</button>
    </form>
</body>
<?php
if(isset($_POST['button']))
{
    $var = $_POST['t1'];
    setcookie("value",$var);
}
if(isset($_COOKIE['value']))
{
    echo $var;
}
?>
</html>