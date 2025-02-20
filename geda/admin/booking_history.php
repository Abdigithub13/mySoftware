<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';

// Get all booking history
$stmt = $pdo->prepare('SELECT b.id AS booking_id, f.flight_model, f.name AS flight_name, b.created_at AS booking_date, u.name AS username, b.seat_number 
FROM bookings b 
JOIN users u ON b.user_id = u.id
JOIN flights f ON b.flight_id = f.id');
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Booking History</title>
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
        button {
            background-color: #004080;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #004080;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #004080;
            padding: 5px;
        }
    </style>
    <script>
        function confirmCancel(bookingId) {
            // Display confirmation dialog
            if (confirm("Are you sure you want to cancel this booking?")) {
                window.location.href = 'booking_history.php?cancel_booking=' + bookingId;
            }
        }
    </script>
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
        <!-- Back Button to Admin Dashboard -->
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>

        <h2>manage passenger History</h2>
        
        <?php
        // Handle the cancel booking action
        if (isset($_GET['cancel_booking'])) {
            $booking_id = $_GET['cancel_booking'];

            try {
                // Begin transaction
                $pdo->beginTransaction();

                // Get the booking details to find the seat number and flight ID
                $stmt = $pdo->prepare('SELECT seat_number, flight_id FROM bookings WHERE id = ?');
                $stmt->execute([$booking_id]);
                $booking = $stmt->fetch();

                if ($booking) {
                    $seat_number = $booking['seat_number'];
                    $flight_id = $booking['flight_id'];

                    // Cancel the booking by deleting the record from the bookings table
                    $deleteStmt = $pdo->prepare('DELETE FROM bookings WHERE id = ?');
                    $deleteStmt->execute([$booking_id]);

                    // Mark the seat as available in the seats table
                    $updateSeatStmt = $pdo->prepare('UPDATE seats SET is_reserved = FALSE, reserved_by = NULL WHERE flight_id = ? AND seat_number = ?');
                    $updateSeatStmt->execute([$flight_id, $seat_number]);

                    // Commit the transaction
                    $pdo->commit();

                    // Redirect back to booking history page with success message
                    header('Location: booking_history.php?status=success');
                    exit;
                } else {
                    // If no booking found
                    header('Location: booking_history.php?status=error');
                    exit;
                }
            } catch (Exception $e) {
                // Rollback in case of error
                $pdo->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }

        // Display success or error messages
        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'success') {
                echo '<p style="color: green;">Booking has been successfully canceled.</p>';
            } elseif ($_GET['status'] === 'error') {
                echo '<p style="color: red;">There was an error processing your cancellation. Please try again.</p>';
            }
        }

        // Display booking history
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo '<table>';
            echo '<tr><th>Flight Model</th><th>Flight Name</th><th>Booking Date</th><th>Username</th><th>Seat Number</th><th>Actions</th></tr>';
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['flight_model']) . '</td>';
                echo '<td>' . htmlspecialchars($row['flight_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['booking_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                echo '<td>' . htmlspecialchars($row['seat_number']) . '</td>';
                echo '<td>
                        <button onclick="confirmCancel(' . $row['booking_id'] . ')">Cancel</button>
                    </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No bookings found.';
        }
        ?>
    </div>
</body>
</html>
