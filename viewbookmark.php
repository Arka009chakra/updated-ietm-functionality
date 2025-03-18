<?php
include 'config.php';
$query = "SELECT `id` FROM `bookmark`;";
$data=[];
$res = mysqli_query($conn,$query);
while($row=mysqli_fetch_array($res))
{
    $data[]=$row;
}
echo json_encode($data);
?>