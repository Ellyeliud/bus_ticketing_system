<?php
include 'db_connect.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");
$comments = [];
while($row = $result->fetch_assoc()){
    $comments[] = $row;
}
echo json_encode($comments);
?>
