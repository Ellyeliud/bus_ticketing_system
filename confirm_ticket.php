<?php
// confirm_ticket.php
if(isset($_POST['from_city'], $_POST['to_city'], $_POST['trip_date'], $_POST['name'], $_POST['email'])){
    $from   = htmlspecialchars($_POST['from_city']);
    $to     = htmlspecialchars($_POST['to_city']);
    $date   = htmlspecialchars($_POST['trip_date']);
    $name   = htmlspecialchars($_POST['name']);
    $email  = htmlspecialchars($_POST['email']);
} else {
    die("Missing required fields!");
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
      background: #f4f6f9;
      font-family: Arial, sans-serif;
    }
    .ticket-card {
      max-width: 500px;
      margin: 80px auto;
      background: white;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      padding: 25px;
      text-align: center;
    }
    .ticket-card h2 {
      color: #0d6efd;
      margin-bottom: 20px;
    }
    .ticket-details {
      text-align: left;
      margin-top: 15px;
    }
    .ticket-details p {
      margin: 5px 0;
    }
    .barcode {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="ticket-card">
    <h2>🎟 Passenger Ticket</h2>
    <div class="ticket-details">
      <p><strong>Passenger:</strong> <?= $name ?></p>
      <p><strong>Email:</strong> <?= $email ?></p>
      <p><strong>From:</strong> <?= $from ?></p>
      <p><strong>To:</strong> <?= $to ?></p>
      <p><strong>Date:</strong> <?= $date ?></p>
    </div>
    <div class="barcode">
      <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($name.'-'.$date) ?>&size=150x150" alt="QR Code Ticket">
    </div>
    <button class="btn btn-primary mt-3" onclick="window.print()">Print Ticket</button>
  </div>
</body>
</html>
