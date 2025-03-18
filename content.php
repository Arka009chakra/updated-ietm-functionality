<?php
include 'config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? '';

$query = "SELECT content FROM content WHERE id = '$id';";
$res = mysqli_query($conn, $query); // Added missing query execution

if ($res) {
    if ($row = mysqli_fetch_array($res)) {
        echo json_encode(['content' => $row['content']]); // Ensuring JSON response
    } else {
        echo json_encode(['error' => 'No content found']); // Handling empty result
    }
} 
?>
