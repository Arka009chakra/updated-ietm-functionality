<?php
include 'config.php';
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? '';
$query = $query = "INSERT INTO bookmark(`id`) VALUES ('$id');";
$res = mysqli_query($conn,$query);
if($res)
{
    echo "done";
}
?>