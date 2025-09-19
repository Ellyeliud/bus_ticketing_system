<?php
include 'db_connect.php';

$tracking_no    = $_POST['tracking_no'] ?? '';
$sender_name    = $_POST['sender_name'] ?? '';
$sender_phone   = $_POST['sender_phone'] ?? '';
$receiver_name  = $_POST['receiver_name'] ?? '';
$receiver_phone = $_POST['receiver_phone'] ?? '';
$amount         = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

if ($tracking_no === '') die("Tracking number missing.");

// Update DB without payment_status (or add the column in DB if needed)
$stmt = $conn->prepare("UPDATE cargo_bookings 
    SET sender_name=?, sender_phone=?, receiver_name=?, receiver_phone=?, amount_paid=?
    WHERE tracking_no=?");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssds", $sender_name, $sender_phone, $receiver_name, $receiver_phone, $amount, $tracking_no);

if ($stmt->execute()) {
    header("Location: cargo_confirmation.php?tracking_no=" . urlencode($tracking_no));
    exit;
} else {
    die("Error updating booking: " . $stmt->error);
}
