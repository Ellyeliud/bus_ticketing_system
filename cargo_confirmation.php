<?php
include 'db_connect.php';

$tracking_no = $_GET['tracking_no'] ?? '';
if ($tracking_no === '') die("Tracking number missing.");

$stmt = $conn->prepare("SELECT * FROM cargo_bookings WHERE tracking_no=?");
$stmt->bind_param("s", $tracking_no);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("Booking not found.");

$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Confirmation</title>
<style>
body { font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f0f2f5; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.ticket { background:#fff; padding:30px 40px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.15); max-width:500px; width:100%; text-align:left; }
.ticket h2 { text-align:center; color:#00aaff; margin-bottom:20px; }
.ticket p { margin:8px 0; }
.btn { display:block; width:100%; margin-top:20px; padding:12px; border:none; border-radius:10px; font-size:16px; cursor:pointer; text-align:center; text-decoration:none; }
.receipt { background:#00cc66; color:#fff; }
.receipt:hover { background:#00994d; }
</style>
</head>
<body>

<div class="ticket">
<h2>Cargo Booking Ticket</h2>
<p><strong>Tracking No:</strong> <?php echo htmlspecialchars($booking['tracking_no']); ?></p>
<p><strong>Sender:</strong> <?php echo htmlspecialchars($booking['sender_name']); ?> (<?php echo htmlspecialchars($booking['sender_phone']); ?>)</p>
<p><strong>Receiver:</strong> <?php echo htmlspecialchars($booking['receiver_name']); ?> (<?php echo htmlspecialchars($booking['receiver_phone']); ?>)</p>
<p><strong>Amount Paid:</strong> TSH <?php echo number_format($booking['amount_paid']); ?></p>

<form method="post" action="generate_receipt.php">
<input type="hidden" name="tracking_no" value="<?php echo htmlspecialchars($booking['tracking_no']); ?>">
<button class="btn receipt">View / Print Receipt</button>
</form>
</div>

</body>
</html>
