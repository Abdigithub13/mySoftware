<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../db_connection.php';
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* General Styles */
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
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Dashboard Content */
        .dashboard-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            text-align: center;
        }
        .dashboard-content h2 {
            color: #004080;
            font-size: 2rem;
        }
        .dashboard-content p {
            font-size: 1.2rem;
            color: #333;
        }

        /* Images Section */
        .image-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .image-section img {
            width: 400px;
            height: 250px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .image-section img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        /* Book Now Button */
        .book-now-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .book-now-btn:hover {
            background-color: #00cc66;
            transform: translateY(-2px);
        }

        /* Scrollable Page */
        html, body {
            height: 100%;
        }
        body {
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome, <?php echo htmlspecialchars($email); ?></h1>
        <nav>
            <a href="view_flights.php">View Available Flights</a>
            <a href="search_flights.php">Search Flights</a>
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="dashboard-content">
            <h2>User Dashboard</h2>
            <p>Select an option from the menu above to proceed.</p>

            <!-- Image Section -->
            <div class="image-section">
                <img src="first.jpeg" alt="Flight Image 1">
                <img src="third.jpeg" alt="Flight Image 2">
            </div>

            <!-- Book Now Button -->
            <a href="view_flights.php" class="book-now-btn">Book Now</a>
        </div>
    </div>
</body>
</html>
