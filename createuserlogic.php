<?php
include 'config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$user = $input['user'] ?? '';
$psw = $input['psw'] ?? '';
$access = $input['access'] ?? '';

$query = "INSERT INTO `user`(`name`, `psw`,`access`) VALUES ('$user', '$psw','$access')";
$res = mysqli_query($conn,$query);
if($res)
{
    echo  "done";
}
?>