<?php
include 'db_connect.php';

$tracking_no = $_GET['tracking_no'] ?? '';
if ($tracking_no === '') die("Tracking number missing.");

// Fetch booking info
$stmt = $conn->prepare("SELECT * FROM cargo_bookings WHERE tracking_no=?");
$stmt->bind_param("s", $tracking_no);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("Booking not found.");

$booking = $result->fetch_assoc();

// Pre-fill form if data exists
$sender_name    = $booking['sender_name'] ?? '';
$sender_phone   = $booking['sender_phone'] ?? '';
$receiver_name  = $booking['receiver_name'] ?? '';
$receiver_phone = $booking['receiver_phone'] ?? '';
$amount_paid    = $booking['amount_paid'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Confirm Payment</title>
<style>
form {
    max-width:500px; margin:50px auto; padding:30px; background:#f7f9fc; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.15); font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
form h4 { margin-bottom:10px; color:#333; border-bottom:2px solid #00aaff; padding-bottom:5px; font-size:18px; }
form input[type="text"], form input[type="number"] { width:100%; padding:12px 15px; margin:10px 0 20px 0; border:1px solid #ccc; border-radius:8px; font-size:16px; transition:0.3s; }
form input:focus { border-color:#00aaff; box-shadow:0 0 8px rgba(0,170,255,0.3); outline:none; }
form button { width:100%; background:#00aaff; color:#fff; padding:14px; border:none; border-radius:10px; font-size:18px; cursor:pointer; transition:0.3s; }
form button:hover { background:#0088cc; box-shadow:0 5px 15px rgba(0,0,0,0.2); }
</style>
</head>
<body>

<form action="cargo_payment_process.php" method="post">
<input type="hidden" name="tracking_no" value="<?php echo htmlspecialchars($tracking_no); ?>">

<h4>Sender Info</h4>
<input type="text" name="sender_name" placeholder="Sender Name" required value="<?php echo htmlspecialchars($sender_name); ?>">
<input type="text" name="sender_phone" placeholder="Sender Phone" required value="<?php echo htmlspecialchars($sender_phone); ?>">

<h4>Receiver Info</h4>
<input type="text" name="receiver_name" placeholder="Receiver Name" required value="<?php echo htmlspecialchars($receiver_name); ?>">
<input type="text" name="receiver_phone" placeholder="Receiver Phone" required value="<?php echo htmlspecialchars($receiver_phone); ?>">

<h4>Payment</h4>
<input type="number" name="amount" placeholder="Enter payment amount in TSH" required value="<?php echo htmlspecialchars($amount_paid); ?>">

<button type="submit">Confirm Payment & Booking</button>
</form>

</body>
</html>
