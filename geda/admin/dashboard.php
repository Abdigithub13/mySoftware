<?php 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        .header {
            background-color: #004080;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        .header nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #004080;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .about-company {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .about-company img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .about-company p {
            color: #333;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            line-height: 1.6;
        }
        .footer {
            background-color: #004080;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
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
        <h2>Welcome, Admin (<?php echo htmlspecialchars($email); ?>)</h2>
        <p>Select an option from the menu above to manage flights and bookings.</p>

        <!-- About Company Section -->
        <div class="about-company">
            <img src="company_logo.jpg" alt="Company Logo"> <!-- Replace with actual image -->
            <h3>About Our Company</h3>
            <p>Welcome to our travel booking platform! We strive to offer the best flight booking experience to our users,
              offering an easy-to-use interface for selecting flights, managing bookings, and more.</p>
            <p>We are committed to providing excellent customer service and ensuring a smooth and enjoyable booking process for all our clients. 
              Our team works tirelessly to bring you the latest deals and flight options.</p>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Travel Agency. All Rights Reserved.</p>
    </footer>
</body>
</html>
