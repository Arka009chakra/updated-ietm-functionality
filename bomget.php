<?php
include 'config.php';

$data = [];
$input = json_decode(file_get_contents('php://input'), true);
$searchTerm = $input['searchterm'] ?? '';

if (!empty($searchTerm)) {
    $query = 'SELECT name FROM bomtree1 WHERE name LIKE "%' . mysqli_real_escape_string($conn, $searchTerm) . '%";';
    $res = mysqli_query($conn, $query);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row['name'];
        }
    }
}
echo json_encode($data);
?>
