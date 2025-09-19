<style>
/* General form styling */
form {
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    background: #f7f9fc;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Section headers */
form h4 {
    margin-bottom: 10px;
    color: #333;
    border-bottom: 2px solid #00aaff;
    padding-bottom: 5px;
    font-size: 18px;
}

/* Input fields */
form input[type="text"],
form input[type="number"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0 20px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    transition: 0.3s;
}

form input[type="text"]:focus,
form input[type="number"]:focus {
    border-color: #00aaff;
    box-shadow: 0 0 8px rgba(0, 170, 255, 0.3);
    outline: none;
}

/* Submit button */
form button {
    width: 100%;
    background: #00aaff;
    color: #fff;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}

form button:hover {
    background: #0088cc;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 600px) {
    form {
        padding: 20px;
    }
    form h4 {
        font-size: 16px;
    }
    form button {
        font-size: 16px;
        padding: 12px;
    }
}
</style>

<form action="cargo_payment.php" method="post">
  <input type="hidden" name="tracking_no" value="<?php echo $tracking_no; ?>">

  <h4>Sender Info</h4>
  <input type="text" name="sender_name" placeholder="Sender Name" required>
  <input type="text" name="sender_phone" placeholder="Sender Phone" required>

  <h4>Receiver Info</h4>
  <input type="text" name="receiver_name" placeholder="Receiver Name" required>
  <input type="text" name="receiver_phone" placeholder="Receiver Phone" required>

  <h4>Payment</h4>
  <input type="number" name="amount" placeholder="Enter payment amount in TSH" required>

  <button type="submit">Confirm Payment & Booking</button>
</form>
