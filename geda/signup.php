<?php
require 'db_connection.php'; // Include your database connection

function isValidName($name) {
    // Check if the name contains only alphabetic letters and spaces
    return preg_match('/^[a-zA-Z\s]+$/', $name);
}

function isValidPassword($password) {
    // Check if the password meets the criteria
    return preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!isValidName($name)) {
        $error = "Name must contain only alphabetic letters and spaces.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!isValidPassword($password)) {
        $error = "Password must be at least 8 characters long and include letters, numbers, and special characters.";
    } else {
        // Check if the email already exists in the users table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $email_exists = $stmt->fetchColumn();

        if ($email_exists) {
            $error = "You already have an account. Please <a href='login.php'>login</a>.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
            try {
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashed_password]);
                $success = "Account created successfully. Please <a href='login.php'>login</a>.";
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .signup-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .signup-container h1 {
            text-align: center;
            color: #004080;
        }
        .signup-container form {
            display: flex;
            flex-direction: column;
        }
        .signup-container input {
            margin: 10px 0;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
        }
        .signup-container button {
            padding: 10px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }
        .signup-container button:hover {
            background-color: #00509e;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
