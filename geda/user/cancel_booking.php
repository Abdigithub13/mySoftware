<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../db_connection.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: booking_history.php');
    exit;
}

// Ensure the booking ID is provided
if (!isset($_POST['booking_id'])) {
    die("Invalid request. Booking ID is required.");
}

$booking_id = $_POST['booking_id'];

// Fetch the user_id using the logged-in user's email from the "users" table
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$_SESSION['email']]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

$user_id = $user['id'];

// Validate that the booking belongs to the logged-in user
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Invalid booking or you do not have permission to cancel this booking.");
}

// Check if a matching entry exists in the passenger table for this user_id
$stmt = $pdo->prepare("SELECT * FROM passenger WHERE user_id = ?");
$stmt->execute([$user_id]);
$passenger = $stmt->fetch();

if ($passenger) {
    // Proceed to delete the passenger record
    $stmt = $pdo->prepare("DELETE FROM passenger WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $passenger_deleted = true;
} else {
    $passenger_deleted = false;
}

// Delete the booking record
$stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->execute([$booking_id]);

// Set success message for display
$success_message = "Booking canceled successfully.";

if ($passenger_deleted) {
    $success_message .= " The passenger record has also been deleted.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
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
        .success {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .button {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #003366;
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
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Cancel Booking</h2>
        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
            <a href="booking_history.php" class="button">Back to Booking History</a>
        <?php else: ?>
            <p>Something went wrong. Please try again later.</p>
            <a href="booking_history.php" class="button">Back to Booking History</a>
        <?php endif; ?>
    </div>
</body>
</html>
