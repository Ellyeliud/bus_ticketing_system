<?php
include 'db_connect.php';

// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Assume you get these values from your backend form
$pickup   = $_POST['pickup'] ?? '';
$delivery = $_POST['delivery'] ?? '';
$goods    = $_POST['goods'] ?? '';
$weight   = $_POST['weight'] ?? 0;

// Generate unique tracking number
$tracking_no = "CARGO" . time();

// Insert cargo into DB
$stmt = $conn->prepare("INSERT INTO cargo_bookings (pickup, delivery, goods, weight, tracking_no, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssds", $pickup, $delivery, $goods, $weight, $tracking_no);

if ($stmt->execute()) {
    // Redirect to payment form
    header("Location: cargo_payment_form.php?tracking_no=" . urlencode($tracking_no));
    exit;
} else {
    die("Error inserting cargo: " . $stmt->error);
}
