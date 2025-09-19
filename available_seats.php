<?php
include 'db_connect.php';

$from = $_GET['from_city'];
$to   = $_GET['to_city'];
$date = $_GET['trip_date'];

// Fetch booked seats for this trip & date
$stmt = $conn->prepare("SELECT seat_number FROM bookings WHERE from_city=? AND to_city=? AND trip_date=?");
$stmt->bind_param("sss", $from, $to, $date);
$stmt->execute();
$result = $stmt->get_result();

$bookedSeats = [];
while ($row = $result->fetch_assoc()) {
    $bookedSeats[] = $row['seat_number'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Seats</title>
  <style>
   <style>
body {
    background: #f0f2f5;
    font-family: 'Segoe UI', sans-serif;
}

h2 {
    text-align: center;
    color: #0d6efd;
    margin-top: 20px;
    margin-bottom: 25px;
}

/* Container like bus interior */
.bus-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #e9ecef;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    max-width: 800px;
    margin: 0 auto 30px auto;
}

/* Row of seats */
.row {
    display: flex;
    justify-content: center;
    margin: 10px 0;
}

/* Individual seats */
.seat {
    width: 55px;
    height: 55px;
    margin: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}

.available {
    background: #28a745;
    color: white;
}

.available:hover {
    background: #218838;
    transform: scale(1.15);
}

.booked {
    background: #dc3545;
    color: white;
    cursor: not-allowed;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.selected {
    background: #ffc107;
    color: #212529;
    transform: scale(1.2);
}

.aisle {
    width: 50px;
}

/* Legend for seat colors */
.legend {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 15px;
}

.legend div {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: bold;
}

.legend .box {
    width: 25px;
    height: 25px;
    border-radius: 5px;
}

/* Form for name/email */
.booking-form {
    text-align: center;
    background: white;
    padding: 25px 20px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    max-width: 700px;
    margin: 0 auto 30px auto;
}

.booking-form input[type="text"],
.booking-form input[type="email"] {
    padding: 12px 15px;
    margin: 8px 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 250px;
    font-size: 1rem;
}

.booking-form button {
    padding: 12px 40px;
    margin-top: 15px;
    background: #0d6efd;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}

.booking-form button:hover {
    background: #0b5ed7;
    transform: scale(1.05);
}

@media (max-width:768px) {
    .seat {
        width: 45px;
        height: 45px;
        font-size: 0.9rem;
    }
    .aisle {
        width: 30px;
    }
    .booking-form input[type="text"],
    .booking-form input[type="email"] {
        width: 90%;
    }
}
</style>

  </style>
</head>
<body>
  <h2 style="text-align:center;">
    Seats for <?php echo "$from → $to on $date"; ?>
  </h2>

  <form method="POST" action="confirm_booking.php">
    <input type="hidden" name="from_city" value="<?php echo $from; ?>">
    <input type="hidden" name="to_city" value="<?php echo $to; ?>">
    <input type="hidden" name="trip_date" value="<?php echo $date; ?>">

   <div class="bus-container">
      <?php
      $seatNumber = 1;
      for ($row = 1; $row <= 10; $row++) {
          echo "<div class='row'>";
          // Left 2 seats
          for ($i = 0; $i < 2; $i++) {
              if (in_array($seatNumber, $bookedSeats)) {
                  echo "<div class='seat booked'>$seatNumber</div>";
              } else {
                  echo "<label>
                          <input type='radio' name='seat_number' value='$seatNumber' hidden>
                          <div class='seat available'>$seatNumber</div>
                        </label>";
              }
              $seatNumber++;
          }
          // aisle
          echo "<div class='aisle'></div>";
          // Right 2 seats
          for ($i = 0; $i < 2; $i++) {
              if (in_array($seatNumber, $bookedSeats)) {
                  echo "<div class='seat booked'>$seatNumber</div>";
              } else {
                  echo "<label>
                          <input type='radio' name='seat_number' value='$seatNumber' hidden>
                          <div class='seat available'>$seatNumber</div>
                        </label>";
              }
              $seatNumber++;
          }
          echo "</div>";
      }
      ?>
    </div>

   <div class="booking-form">
  <input type="text" name="passenger_name" placeholder="Your Name" required>
  <input type="email" name="passenger_email" placeholder="Your Email" required>
  <br>

  <!-- Payment + Booking -->
  <button type="button" id="payBtn" class="btn btn-warning">Pay Now</button>
  <button type="submit" id="confirmBtn" class="btn btn-success" disabled> Confirm Booking</button>
</div>

<div class="legend">
  <div><div class="box" style="background:#28a745;"></div> Available</div>
  <div><div class="box" style="background:#dc3545;"></div> Booked</div>
  <div><div class="box" style="background:#ffc107;"></div> Selected</div>
</div>

  <script>
    // seat click highlight
    document.querySelectorAll("label").forEach(label => {
      label.addEventListener("click", () => {
        document.querySelectorAll(".seat").forEach(seat => seat.classList.remove("selected"));
        label.querySelector(".seat").classList.add("selected");
      });
    });
  </script>
  <script>
  const payBtn = document.getElementById("payBtn");
  const confirmBtn = document.getElementById("confirmBtn");

  // Simulate payment process
  payBtn.addEventListener("click", function() {
    // Here you can integrate real payment API (e.g., PayPal, Stripe, Mpesa, etc.)
    // For now, simulate success with confirm popup
    let payment = confirm("Proceed with payment?");
    if(payment) {
      alert(" Payment Successful!");
      confirmBtn.disabled = false; // Enable confirm button
      payBtn.disabled = true; // Disable pay button to avoid duplicate
      payBtn.innerText = "Payment Completed";
    } else {
      alert(" Payment was not completed. Please try again.");
    }
  });
</script>

</body>
</html>
