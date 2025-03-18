<?php
include 'config.php';
$input = json_decode(file_get_contents('php://input'), true);
$check = $input['check'] ?? '';

$query = "SELECT id FROM bomtree1 WHERE name = '$check';";
$res = mysqli_query($conn, $query);

if ($res) {
    $row = mysqli_fetch_assoc($res); 
    if ($row) {
        echo $row['id']; 
    }
}
?>
