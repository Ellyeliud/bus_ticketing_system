<?php
// cargo_step1_process.php
include 'db_connect.php'; // Make sure this connects to your database

// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data safely
    $pickup   = trim($_POST['pickup'] ?? '');
    $delivery = trim($_POST['delivery'] ?? '');
    $goods    = trim($_POST['goods'] ?? '');
    $weight   = floatval($_POST['weight'] ?? 0);

    // Validate required fields
    if ($pickup === '' || $delivery === '' || $goods === '' || $weight <= 0) {
        die("All fields are required and weight must be greater than 0.");
    }

    // Generate unique tracking number
    $tracking_no = "CARGO" . time();

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO cargo_bookings (pickup, delivery, goods, weight, tracking_no, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssds", $pickup, $delivery, $goods, $weight, $tracking_no);

    // Execute statement
    if ($stmt->execute()) {
        // Redirect to payment form with tracking number
        header("Location: cargo_payment_form.php?tracking_no=" . urlencode($tracking_no));
        exit;
    } else {
        die("Error inserting cargo: " . $stmt->error);
    }

} else {
    die("Invalid request method.");
}
