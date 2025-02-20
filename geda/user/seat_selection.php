<?php 
session_start();
require '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['flight_id'])) {
    die("Invalid flight selection.");
}

$flight_id = $_GET['flight_id'];
$passenger_name = $_SESSION['passenger_name'];  // Get the name passed from the booking page

// Fetch flight details
$stmt = $pdo->prepare("SELECT total_seats FROM flights WHERE id = :flight_id");
$stmt->execute(['flight_id' => $flight_id]);
$flight = $stmt->fetch();

if (!$flight) {
    die("Flight not found.");
}

$total_seats = $flight['total_seats'];

// Fetch booked seat numbers from the bookings table
$stmt = $pdo->prepare("SELECT seat_number FROM bookings WHERE flight_id = :flight_id");
$stmt->execute(['flight_id' => $flight_id]);
$booked_seats = $stmt->fetchAll(PDO::FETCH_COLUMN);

$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve flight_id from POST request
    $flight_id = $_POST['flight_id'];
    $selected_seat = intval($_POST['selected_seat']);

    // Validate the seat number
    if ($selected_seat < 1 || $selected_seat > $total_seats) {
        $error_message = "Invalid seat number. Please enter a number between 1 and $total_seats.";
    } elseif (in_array($selected_seat, $booked_seats)) {
        $error_message = "Seat $selected_seat is already taken. Please choose another seat.";
    } else {
        // Reserve the seat for the user
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, flight_id, seat_number) VALUES (:user_id, :flight_id, :seat_number)");
        $stmt->execute([ 
            'user_id' => $_SESSION['user_id'],
            'flight_id' => $flight_id,
            'seat_number' => $selected_seat
        ]);

        // Redirect to payment page
        header("Location: payment.php?seat_number=$selected_seat&flight_id=$flight_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seat</title>
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
        }
        .button {
            display: inline-block;
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #003366;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($passenger_name); ?></h1>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="view_flights.php">View Available Flights</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Select Your Seat</h2>
        <p>Please enter a seat number between <strong>1</strong> and <strong><?php echo $total_seats; ?></strong>.</p>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <!-- Add hidden field for flight_id -->
            <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">

            <label for="selected_seat">Seat Number:</label>
            <input type="number" name="selected_seat" id="selected_seat" min="1" max="<?php echo $total_seats; ?>" required>
            <button type="submit" class="button">Continue to Pay</button>
        </form>
    </div>
</body>
</html>
