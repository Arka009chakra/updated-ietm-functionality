<?php
include 'config.php';
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? '';
$data=[];
$query = "SELECT level,name,id FROM bomtree1 WHERE id = '$id';";
$res = mysqli_query($conn, $query);
if($res)
{
if($row = mysqli_fetch_array($res))
{

    if ($row['level'] === '1') {
        $data[] = ['name' => $row['name'], 'id' => $row['id']];
    }
    else{
    
        $data[] = ['name' => $row['name'], 'id' => $row['id']];

        removedot($conn,$row['level'],$data);
    }
}
} 

function removedot($conn,$hnumber,&$data)
{
    if (strpos($hnumber, '.') === false) 
    {
        return;
    }


$array = explode('.', $hnumber);
array_pop($array);
$reshnumber = implode('.', $array);
    $query1 = "SELECT level,name,id FROM bomtree1 WHERE level = '$reshnumber';";
    $res1 = mysqli_query($conn, $query1);
    if ($res1) {
        if ($row1 = mysqli_fetch_assoc($res1)) {
            $data[] = ['name' => $row1['name'], 'id' => $row1['id']];

            removedot($conn,$row1['level'],$data);
        }
        
    }
}
mysqli_close($conn);


$data = array_reverse($data);


echo json_encode($data);
?>