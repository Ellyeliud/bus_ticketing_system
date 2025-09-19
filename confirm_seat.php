<?php
include 'db_connect.php';

if (isset($_POST['seat_number'])) {
    $from  = $_POST['from_city'];
    $to    = $_POST['to_city'];
    $date  = $_POST['trip_date'];
    $seat  = $_POST['seat_number'];
    $name  = $_POST['passenger_name'];
    $email = $_POST['passenger_email'];

    // check if seat already booked
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE from_city=? AND to_city=? AND trip_date=? AND seat_number=?");
    $stmt->bind_param("sssi", $from, $to, $date, $seat);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo " Seat $seat already booked for $date!";
        exit;
    }

    // save booking
    $stmt = $conn->prepare("INSERT INTO bookings (from_city, to_city, trip_date, seat_number, passenger_name, passenger_email) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("sssiss", $from, $to, $date, $seat, $name, $email);

    if ($stmt->execute()) {
        echo " Booking confirmed! Seat $seat reserved for $name";
    } else {
        echo " Booking failed!";
    }
}
?>
