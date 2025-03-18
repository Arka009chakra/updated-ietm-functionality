<?php
include 'config.php';
$query="SELECT * FROM bomtree1;";
$data=[];
$res=mysqli_query($conn,$query);
if($res)
{
    while($row=mysqli_fetch_assoc($res))
    {
        $data[] = $row;
    }
}
echo json_encode($data);
?>