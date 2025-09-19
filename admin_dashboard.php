<?php
include 'db_connect.php';

// Fetch passenger bookings
$passengers = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
if(!$passengers){
    die("Error fetching passenger bookings: " . $conn->error);
}

// Fetch cargo bookings
$cargo = $conn->query("SELECT * FROM cargo_bookings ORDER BY id DESC");
if(!$cargo){
    die("Error fetching cargo bookings: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - ELLYPROExpress</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
}
.navbar {
    background-color: #0d6efd;
}
.navbar-brand, .nav-link {
    color: white !important;
    font-weight: bold;
}
.dashboard-header {
    text-align: center;
    padding: 30px 0;
    color: #0d6efd;
}
.card {
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.card h5 {
    font-weight: bold;
}
.table thead {
    background-color: #0d6efd;
    color: white;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ELLYPROExpress Admin</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<div class="dashboard-header mt-5 pt-5">
    <h1>Welcome, Admin</h1>
    <p>Manage passengers and cargo bookings</p>
</div>

<div class="container mt-4">

    <!-- Passengers Table -->
    <div class="card p-4">
        <h5 class="mb-3">Passenger Bookings</h5>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Seat Number</th>
                    <th>Booking Time</th>
                </tr>
            </thead>
            <tbody>
            <?php if($passengers && $passengers->num_rows > 0): ?>
                <?php while($row = $passengers->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?? '' ?></td>
                    <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['from_city'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['to_city'] ?? '') ?></td>
                    <td><?= $row['trip_date'] ?? '' ?></td>
                    <td><?= $row['seat_number'] ?? '' ?></td>
                    <td><?= $row['created_at'] ?? '' ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No passenger bookings found</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Cargo Table -->
    <div class="card p-4">
        <h5 class="mb-3">Cargo Bookings</h5>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tracking No</th>
                    <th>Pickup</th>
                    <th>Delivery</th>
                    <th>Goods</th>
                    <th>Weight (kg)</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Amount Paid (TSH)</th>
                    <th>Booking Time</th>
                </tr>
            </thead>
            <tbody>
            <?php if($cargo && $cargo->num_rows > 0): ?>
                <?php while($row = $cargo->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?? '' ?></td>
                    <td><?= htmlspecialchars($row['tracking_no'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['pickup'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['delivery'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['goods'] ?? '') ?></td>
                    <td><?= $row['weight'] ?? '' ?></td>
                    <td><?= htmlspecialchars($row['sender_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['receiver_name'] ?? '') ?></td>
                    <td><?= isset($row['amount_paid']) ? number_format($row['amount_paid'],2) : '' ?></td>
                    <td><?= $row['created_at'] ?? '' ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="10" class="text-center">No cargo bookings found</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
