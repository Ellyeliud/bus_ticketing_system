<?php
include 'db_connect.php';

if(isset($_POST['from_city'], $_POST['to_city'], $_POST['trip_date'], $_POST['seat_number'], $_POST['passenger_name'], $_POST['passenger_email'])){

    $from = $_POST['from_city'];
    $to   = $_POST['to_city'];
    $date = $_POST['trip_date'];
    $seat = $_POST['seat_number'];
    $name = $_POST['passenger_name'];
    $email = $_POST['passenger_email'];

    // Save booking into DB
    $stmt = $conn->prepare("INSERT INTO bookings (from_city, to_city, trip_date, seat_number, passenger_name, passenger_email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $from, $to, $date, $seat, $name, $email);

    if($stmt->execute()){
        // success, show ticket
    } else {
        die("Booking failed: " . $stmt->error);
    }

} else {
    die("Missing booking details.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticket Confirmation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
 body {
  background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
  font-family: 'Segoe UI', sans-serif;
}

.ticket-card {
  width: 450px;
  margin: 80px auto;
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  position: relative;
  border: 3px solid #0d6efd;
}

.ticket-header {
  background: #0d6efd;
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 1.4rem;
  font-weight: bold;
  letter-spacing: 1px;
}

.ticket-body {
  padding: 20px 25px;
}

.ticket-body p {
  margin: 8px 0;
  font-size: 1rem;
  color: #333;
}

.ticket-body strong {
  color: #0d6efd;
}

.barcode {
  text-align: center;
  padding: 15px;
  background: #f1f1f1;
  border-top: 2px dashed #ccc;
}

.barcode img {
  width: 120px;
  height: 120px;
}

.ticket-footer {
  background: #0d6efd;
  color: white;
  text-align: center;
  padding: 10px;
  font-size: 0.9rem;
  font-style: italic;
}

  </style>
</head>
<body>
  <div class="ticket-card">
  <div class="ticket-header">
    🎟 Passenger Ticket
  </div>
  <div class="ticket-body">
    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>From:</strong> <?= htmlspecialchars($from) ?></p>
    <p><strong>To:</strong> <?= htmlspecialchars($to) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
    <p><strong>Seat:</strong> <?= htmlspecialchars($seat) ?></p>
  </div>
  <div class="barcode">
    <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($name.'-'.$seat.'-'.$date) ?>&size=150x150" alt="QR Code Ticket">
  </div>
  <div class="ticket-footer">
    Safe Journey! 
  </div>
</div>
    <button class="btn btn-primary mt-3" onclick="window.print()">Print Ticket</button>
  </div>
</body>
</html>
