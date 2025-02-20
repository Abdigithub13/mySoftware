<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$error = ""; // Variable to hold error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['flight_id'])) {
        die("Invalid flight selection.");
    }

    $flight_id = $_POST['flight_id'];

    // Fetch flight details
    $stmt = $pdo->prepare("SELECT * FROM flights WHERE id = :flight_id");
    $stmt->execute(['flight_id' => $flight_id]);
    $flight = $stmt->fetch();

    if (!$flight) {
        die("Flight not found.");
    }

    // Process form submission
    if (isset($_POST['name'], $_POST['gender'], $_POST['age'], $_POST['address'])) {
        $name = htmlspecialchars($_POST['name']);
        $gender = htmlspecialchars($_POST['gender']);
        $age = htmlspecialchars($_POST['age']);
        $address = htmlspecialchars($_POST['address']);

        // Validate name and address
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $error = "Name can only contain letters and spaces.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $address)) {
            $error = "Address can only contain letters and spaces.";
        } else {
            // Fetch user_id of the logged-in user based on email
            $user_email = $_SESSION['email'];
            $user_stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $user_stmt->execute(['email' => $user_email]);
            $user = $user_stmt->fetch();

            if (!$user) {
                die("User not found.");
            }

            $user_id = $user['id'];

            // Insert passenger details into the database
            $stmt = $pdo->prepare("
                INSERT INTO passenger (user_id, username, gender, age, address) 
                VALUES (:user_id, :username, :gender, :age, :address)
            ");
            $stmt->execute([
                'user_id' => $user_id,
                'username' => $name, // Using the username entered on the form
                'gender' => $gender,
                'age' => $age,
                'address' => $address,
            ]);

            // Redirect to the seat selection page
            $_SESSION['passenger_name'] = $name;
            header("Location: seat_selection.php?flight_id=$flight_id");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Flight</title>
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
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        .form-container h3 {
            margin-bottom: 15px;
            color: #004080;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-container button {
            background-color: #004080;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #003366;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
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
            <a href="booking_history.php">View Booking History</a>
            <a href="../index.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Book Flight</h2>
        <h3>Flight Details</h3>
        <p>Flight Model: <?php echo htmlspecialchars($flight['flight_model']); ?></p>
        <p>Name: <?php echo htmlspecialchars($flight['name']); ?></p>
        <p>Price: <?php echo htmlspecialchars($flight['price']); ?></p>

        <div class="form-container">
            <h3>Passenger Details</h3>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">

                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="male" <?php echo (isset($gender) && $gender === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo (isset($gender) && $gender === 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo (isset($gender) && $gender === 'other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="age">Age:</label>
                <input type="number" name="age" value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>" required>

                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>" required>

                <button type="submit">Next</button>
            </form>
        </div>
    </div>
</body>
</html>
