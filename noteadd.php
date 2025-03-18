<?php
include 'config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? '';
$selectiontext = $input['selectiontext'] ?? '';
$entertext = $input['entertext'] ?? '';
$breadcrumb2 = $input['breadcrumb2'] ?? '';
$query = "INSERT INTO `note`(`id`, `note`, `selected`,`crumb`) VALUES ($id, '$entertext', '$selectiontext','$breadcrumb2')";
$res = mysqli_query($conn,$query);
if($res)
{
    echo  "done";
}
?>