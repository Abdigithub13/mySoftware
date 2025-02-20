<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

require '../db_connection.php';

// Fetch unique departure and destination cities for dropdown
$sqlFrom = "SELECT DISTINCT departure_city FROM flights";
$sqlTo = "SELECT DISTINCT destination_city FROM flights";
$fromCities = $pdo->query($sqlFrom)->fetchAll(PDO::FETCH_ASSOC);
$toCities = $pdo->query($sqlTo)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Flights</title>
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
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 70px); /* Adjust height to exclude header height */
            padding-top: 70px; /* Prevent overlap with header */
        }
        .container {
            width: 100%;
            max-width: 400px; /* Minimized container width */
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #004080;
            color: white;
            cursor: pointer;
        }
        button:hover {
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
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="main-container">
        <div class="container">
            <h2>Select Flight</h2>
            <form action="view_flights.php" method="POST">
                <div class="form-group">
                    <label for="from">From</label>
                    <select name="from" id="from" required>
                        <option value="" disabled selected>Select Departure City</option>
                        <?php foreach ($fromCities as $city): ?>
                            <option value="<?php echo htmlspecialchars($city['departure_city']); ?>">
                                <?php echo htmlspecialchars($city['departure_city']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="to">To</label>
                    <select name="to" id="to" required>
                        <option value="" disabled selected>Select Destination City</option>
                        <?php foreach ($toCities as $city): ?>
                            <option value="<?php echo htmlspecialchars($city['destination_city']); ?>">
                                <?php echo htmlspecialchars($city['destination_city']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="book_now">Book Now</button>
            </form>
        </div>
    </div>
</body>
</html>
