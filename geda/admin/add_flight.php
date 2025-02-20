<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Remove flight_id as it does not exist in the schema
    $model = $_POST['model'];
    $name = $_POST['name'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

    // Correct the SQL statement to match the schema
    $stmt = $pdo->prepare("INSERT INTO flights (flight_model, name, total_seats, price, departure_city, destination_city, departure_date) 
                           VALUES (:model, :name, :seats, :price, :from, :to, :date)");
    $stmt->execute([
        'model' => $model,
        'name' => $name,
        'seats' => $seats,
        'price' => $price,
        'from' => $from,
        'to' => $to,
        'date' => $date,
    ]);

    $success = "Flight added successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
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
        .form-container input {
            margin: 10px 0;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
        }
        .form-container button {
            padding: 10px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #00509e;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #004080;
            text-decoration: none;
        }
        .back-link a:hover {
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
    <button onclick="window.location.href='dashboard.php'">Back</button>
        <h1>Add Flight</h1>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="model" placeholder="Flight Model" required>
            <input type="text" name="name" placeholder="Flight Name" required>
            <input type="number" name="seats" placeholder="Number of Seats" required>
            <input type="number" name="price" placeholder="Price" required>
            <input type="text" name="from" placeholder="From (City)" required>
            <input type="text" name="to" placeholder="To (City)" required>
            <input type="date" name="date" required>
            <button type="submit">Add Flight</button>
        </form>
        <?php if (isset($success)): ?>
            <div class="back-link">
                <p><a href="dashboard.php">Back to Dashboard</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>