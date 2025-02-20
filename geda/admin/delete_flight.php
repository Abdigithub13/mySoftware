<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';

$success = null; // To store success messages
$error = null; // To store errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle flight deletion
    $flight_id = $_POST['flight_id'];
    $stmt = $pdo->prepare("DELETE FROM flights WHERE id = :flight_id"); // Use 'id' instead of 'flight_id'
    $stmt->execute(['flight_id' => $flight_id]);

    if ($stmt->rowCount() > 0) {
        $success = "Flight with ID '$flight_id' has been successfully deleted.";
    } else {
        $error = "Failed to delete flight with ID '$flight_id'. It may not exist.";
    }
}

// Fetch all flights
$stmt = $pdo->prepare("SELECT * FROM flights ORDER BY departure_date ASC"); // Use 'departure_date' instead of 'date'
$stmt->execute();
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Flights</title>
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
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            color: #004080;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #004080;
            color: white;
        }
        .delete-btn {
            padding: 5px 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #ff1a1a;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .back-button {
            text-align: center;
            margin: 20px 0;
        }
        .back-button a {
            text-decoration: none;
            color: #004080;
            font-size: 1rem;
            padding: 10px 20px;
            border: 1px solid #004080;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #004080;
            color: white;
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
    <div class="container">
        <h1>Delete Flights</h1>

        <!-- Display success or error messages -->
        <?php if ($success): ?>
            <p class="message success"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Flights Table -->
        <table>
            <thead>
                <tr>
                    <th>Flight ID</th>
                    <th>Model</th>
                    <th>Name</th>
                    <th>Seats</th>
                    <th>Price</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </ <tbody>
                <?php if (count($flights) > 0): ?>
                    <?php foreach ($flights as $flight): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flight['id']); ?></td>
                            <td><?php echo htmlspecialchars($flight['flight_model']); ?></td>
                            <td><?php echo htmlspecialchars($flight['name']); ?></td>
                            <td><?php echo htmlspecialchars($flight['total_seats']); ?></td>
                            <td><?php echo htmlspecialchars($flight['price']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_city']); ?></td>
                            <td><?php echo htmlspecialchars($flight['destination_city']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_date']); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No flights found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Back to Dashboard Button -->
        <div class="back-button">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>