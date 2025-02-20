<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';

$flight = null; // To store flight details for editing
$error = null; // To store errors during flight search or update
$success = null; // To store success messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_flight'])) {
        // Search for the flight by id
        $flight_id = $_POST['flight_id'];
        $stmt = $pdo->prepare("SELECT * FROM flights WHERE id = :flight_id"); // Use 'id' instead of 'flight_id'
        $stmt->execute(['flight_id' => $flight_id]);
        $flight = $stmt->fetch();
        
        if (!$flight) {
            $error = "Flight with ID '$flight_id' not found.";
        }
    } elseif (isset($_POST['update_flight'])) {
        // Update flight details
        $flight_id = $_POST['flight_id'];
        $model = $_POST['model'];
        $name = $_POST['name'];
        $seats = $_POST['seats'];
        $price = $_POST['price'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $date = $_POST['date'];

        $stmt = $pdo->prepare("
            UPDATE flights 
            SET flight_model = :model, name = :name, total_seats = :seats, price = :price, 
                departure_city = :from, destination_city = :to, departure_date = :date 
            WHERE id = :flight_id
        "); // Correct SQL statement without comments
        $stmt->execute([
            'model' => $model,
            'name' => $name,
            'seats' => $seats,
            'price' => $price,
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'flight_id' => $flight_id,
        ]);

        $success = "Flight with ID '$flight_id' updated successfully.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Flight</title>
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
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            color: #004080;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input, .form-container button {
            margin: 10px 0;
            padding: 10px;
            font-size: 1rem;
        }
        .form-container button {
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #00509e;
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
        }
        .back-button a {
            text-decoration: none;
            color: #004080;
            font-size: 1rem;
        }
        .back-button a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header class="header">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="add_flight.php">Add Flight</a>
            <a href="update_flight.php">Update Flight</a>
            <a href="delete_flight.php">Delete Flight</a>
            <a href="booking_history.php">Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>
    


    <div class="form-container">
        <h1>Update Flight</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Search Flight Form -->
        <form method="POST">
            <input type="text" name="flight_id" placeholder="Enter Flight ID" required>
            <button type="submit" name="search_flight">Search Flight</button>
        </form>

        <?php if ($flight): ?>
            <!-- Update Flight Form -->
            <form method="POST">
                <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>" readonly>
                <input type="text" name="model" placeholder="Flight Model" value="<?php echo $flight['flight_model']; ?>" required>
                <input type="text" name="name" placeholder="Flight Name" value="<?php echo $flight['name']; ?>" required>
                <input type="number" name="seats" placeholder="Total Seats" value="<?php echo $flight['total_seats']; ?>" required>
                <input type="number" name="price" placeholder="Price" value="<?php echo $flight['price']; ?>" required>
                <input type="text" name="from" placeholder="Departure City" value="<?php echo $flight['departure_city']; ?>" required>
                <input type="text" name="to" placeholder="Destination City" value="<?php echo $flight['destination_city']; ?>" required>
                <input type="date" name="date" placeholder="Departure Date" value="<?php echo $flight['departure_date']; ?>" required>
                <button type="submit" name="update_flight">Update Flight</button>
            </form>
        <?php endif; ?>

        <div class="back-button">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>