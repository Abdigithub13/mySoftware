<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../db_connection.php';

// Fetch user information based on logged-in email
$user_email = $_SESSION['email'];
$sql_user = "SELECT id FROM users WHERE email = :email";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->execute(['email' => $user_email]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_id = $user['id'];

    // Check if user already has an active booking
    $sql_booking = "SELECT * FROM bookings WHERE user_id = :user_id";
    $stmt_booking = $pdo->prepare($sql_booking);
    $stmt_booking->execute(['user_id' => $user_id]);
    $existing_booking = $stmt_booking->fetch(PDO::FETCH_ASSOC);

    if ($existing_booking) {
        $error_message = "You can't book two flights at once.";
    }
}

$sql = "SELECT * FROM flights";
$stmt = $pdo->query($sql);
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
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
        .flight-list {
            margin-top: 20px;
        }
        .flight-item {
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .flight-item h3 {
            margin: 0;
        }
        .button {
            background-color: #004080;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #003366;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Available Flights</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="flight-list">
            <?php foreach ($flights as $flight): ?>
                <div class="flight-item">
                    <div>
                        <h3><?php echo htmlspecialchars($flight['name']); ?> (<?php echo htmlspecialchars($flight['flight_model']); ?>)</h3>
                        <p>Departure: <?php echo htmlspecialchars($flight['departure_city']); ?> to <?php echo htmlspecialchars($flight['destination_city']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($flight['departure_date']); ?></p>
                    </div>
                    <form method="POST" action="book_flight.php">
                        <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">
                        <?php if (!isset($error_message)): ?>
                            <button type="submit" class="button">Book Now</button>
                        <?php else: ?>
                            <button type="button" class="button" disabled>Cannot Book</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
