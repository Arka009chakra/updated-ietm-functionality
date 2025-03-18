<?php
$servername = "localhost";
$username = "ietm";
$password = "ietm"; 
$database = "practice";
$conn=mysqli_connect($servername, $username, $password, $database);

if($conn)
{
    //echo("connection successfull!!!!!");
}
else{
   // echo("connection failed!!!!!");
}
?>