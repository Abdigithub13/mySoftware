<?php
session_start();
require '../db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Retrieve payment details from the session
if (isset($_SESSION['payment_details'])) {
    $payment_details = $_SESSION['payment_details'];

    $flight_id = $payment_details['flight_id'];
    $seat_number = $payment_details['seat_number'];
    $payment_method = $payment_details['payment_method'];
    $bank_account = $payment_details['bank_account'];
    $price = $payment_details['price'];

    // Fetch flight details to show in confirmation
    $stmt = $pdo->prepare("SELECT name FROM flights WHERE id = :flight_id");
    $stmt->execute(['flight_id' => $flight_id]);
    $flight = $stmt->fetch();

    if ($flight) {
        $flight_name = $flight['name'];
    } else {
        die("Flight not found.");
    }

    // Handle payment confirmation on form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Save payment transaction to database or process the payment here
        // You can update the booking table and refund table as needed

        // Simulate successful payment processing
        echo "<p>Payment successfully processed for flight: " . htmlspecialchars($flight_name) . "</p>";
        echo "<p>Seat Number: " . htmlspecialchars($seat_number) . "</p>";
        echo "<p>Amount Paid: " . htmlspecialchars($price) . "</p>";

        // Redirect to booking success page or dashboard
        unset($_SESSION['payment_details']);
        header("Location: payment_success.php");
        exit;
    }
} else {
    die("No payment details found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
</head>
<body>

<h2>Confirm Payment Details</h2>

<p>Flight: <?php echo htmlspecialchars($flight_name); ?></p>
<p>Seat Number: <?php echo htmlspecialchars($seat_number); ?></p>
<p>Payment Method: <?php echo htmlspecialchars($payment_method); ?></p>
<p>Bank Account Number: <?php echo htmlspecialchars($bank_account); ?></p>
<p>Price: <?php echo htmlspecialchars($price); ?></p>

<form method="POST" action="">
    <button type="submit">Confirm Payment</button>
</form>

</body>
</html>
