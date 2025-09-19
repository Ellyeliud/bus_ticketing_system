<?php
include 'db_connect.php'; // Make sure DB connection works

if(isset($_POST['name'], $_POST['message'])){
    $name = $_POST['name'];
    $message = $_POST['message'];
    $stmt = $conn->prepare("INSERT INTO comments (name, message, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $name, $message);
    if($stmt->execute()){
        echo "success";
    } else {
        echo "error: ".$stmt->error;
    }
}
?>
