<?php
session_start();
require '../db_connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit;
}

// Ensure flight ID and seat number are passed
if (!isset($_GET['flight_id']) || !isset($_GET['seat_number'])) {
    die("Invalid access. Flight ID or Seat Number missing.");
}

$flight_id = $_GET['flight_id'];
$seat_number = $_GET['seat_number'];

// Validate the seat is reserved for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE flight_id = :flight_id AND seat_number = :seat_number AND user_id = :user_id");
$stmt->execute([
    'flight_id' => $flight_id,
    'seat_number' => $seat_number,
    'user_id' => $_SESSION['user_id']
]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Invalid booking. Seat not reserved.");
}

$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture payment details
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $bank_number = htmlspecialchars($_POST['bank_number']);
    $payment_amount = htmlspecialchars($_POST['payment_amount']);

    // Fetch the user_id based on the logged-in user's email from the users table
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION['email']]);
    $user = $stmt->fetch();

    if (!$user) {
        die("User not found.");
    }

    // Now fetch the passenger details using the user_id
    $stmt = $pdo->prepare("SELECT username, gender, age, address FROM passenger WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user['id']]);
    $passenger = $stmt->fetch();

    if (!$passenger) {
        die("Passenger details not found.");
    }

    // Check if this booking already exists in the 'bookings' table (same flight_id and seat_number)
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE flight_id = :flight_id AND seat_number = :seat_number");
    $stmt->execute(['flight_id' => $flight_id, 'seat_number' => $seat_number]);
    $existing_booking = $stmt->fetch();

    if ($existing_booking) {
        // If the booking already exists, update the existing record
        $stmt = $pdo->prepare("
            UPDATE bookings SET 
                payment_method = :payment_method,
                payment_amount = :payment_amount,
                payment_status = 'completed',
                name = :name,
                gender = :gender,
                age = :age,
                address = :address
            WHERE flight_id = :flight_id AND seat_number = :seat_number
        ");
        $stmt->execute([
            'payment_method' => $payment_method,
            'payment_amount' => $payment_amount,
            'flight_id' => $flight_id,
            'seat_number' => $seat_number,
            'name' => $passenger['username'],
            'gender' => $passenger['gender'],
            'age' => $passenger['age'],
            'address' => $passenger['address']
        ]);
        $success_message = "Payment successful! Your seat has been reserved (existing booking updated).";
    } else {
        // Insert new booking if no existing record found
        $stmt = $pdo->prepare("
            INSERT INTO bookings (user_id, flight_id, seat_number, name, gender, age, address, payment_method, payment_amount, payment_status)
            VALUES (:user_id, :flight_id, :seat_number, :name, :gender, :age, :address, :payment_method, :payment_amount, 'completed')
        ");
        $stmt->execute([
            'user_id' => $user['id'],
            'flight_id' => $flight_id,
            'seat_number' => $seat_number,
            'name' => $passenger['username'],
            'gender' => $passenger['gender'],
            'age' => $passenger['age'],
            'address' => $passenger['address'],
            'payment_method' => $payment_method,
            'payment_amount' => $payment_amount
        ]);
        $success_message = "Payment successful! Your seat has been reserved.";
    }

    // Redirect after successful booking or update
    header("refresh:5;url=dashboard.php"); // Redirect after 5 seconds
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            background-color: #004080;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .button {
            display: inline-block;
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #003366;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="view_flights.php">View Available Flights</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1>Payment for Your Booking</h1>
        <p>Flight ID: <?php echo htmlspecialchars($flight_id); ?></p>
        <p>Seat Number: <?php echo htmlspecialchars($seat_number); ?></p>
        <p>Passenger: <?php echo htmlspecialchars($_SESSION['passenger_name']); ?></p>

        <?php if ($success_message): ?>
            <div class="success"><?php echo $success_message; ?></div>
            <p>You will be redirected to the dashboard shortly...</p>
        <?php else: ?>
            <form method="POST" action="">
                <label for="payment_method">Select Payment Method</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="CBE BANK">CBE BANK</option>
                    <option value="AWASH BANK">AWASH BANK</option>
                    <option value="OROMIA BANK">OROMIA BANK</option>
                </select><br><br>

                <label for="bank_number">Bank Number</label>
                <input type="text" name="bank_number" id="bank_number" required><br><br>

                <label for="payment_amount">Payment Amount</label>
                <input type="number" name="payment_amount" id="payment_amount" value="1000" readonly><br><br>

                <button type="submit" class="button">Complete Payment</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
