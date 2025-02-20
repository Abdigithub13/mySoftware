<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethiopian Airline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        /* Header Section */
        .header {
            background-color: #004080;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header img {
            width: 50px;
        }

        .header nav {
            display: flex;
        }

        .header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .header nav a:hover {
            color: #ffd700;
        }

        /* Welcome Section */
        .welcome-section {
            padding: 40px 20px;
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            color: #004080;
        }

        .welcome-section img {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            display: block;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .about-section {
        padding: 40px 20px;
        text-align: center;
    }

    .about-section p {
        margin-bottom: 20px;
    }

    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        justify-items: center;
    }

    .image-item img {
        width: 400px;
        height: 400px;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .image-item img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
        /* Contact Us Section */
        .contact-section {
            padding: 40px 20px;
            background-color: #f9f9f9;
            overflow-y: auto;
            max-height: 300px;
        }

        .contact-section h2 {
            font-size: 2rem;
            color: #004080;
            margin-bottom: 20px;
        }

        .contact-section form {
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }

        .contact-section label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-section input,
        .contact-section textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .contact-section button {
            background-color: #004080;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .contact-section button:hover {
            background-color: #ffd700;
            color: #004080;
        }

        footer {
            background-color: #004080;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="logo.jpeg" style="width : 100px; height:40px;" alt="Ethiopian Airline Logo">
        <nav>
            <a href="#home">Home</a>
            <a href="#about">About Us</a>
            <a href="#contact">Contact Us</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <div id="home" class="welcome-section">
        <h1>Welcome to Ethiopian Airline</h1>
        <img src="first.jpeg" alt="Ethiopian Airline">
        <p>Experience the comfort and reliability of Ethiopian Airlines.</p>
    </div>

    <div id="about" class="about-section">
    <h2>About Us</h2>
    <p>We provide the best airline services with exceptional customer care. Discover new destinations with us.</p>
    <div class="image-grid">
        <div class="image-item">
            <img src="fourth.jpeg" alt="Flight 1">
        </div>
        <div class="image-item">
            <img src="second.jpeg" alt="Flight 2">
        </div>
        <div class="image-item">
            <img src="third.jpeg" alt="Flight 3">
        </div>
    </div>
</div>


    <div id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <form action="contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <footer>
        &copy; 2025 Ethiopian Airline. All Rights Reserved.
    </footer>
</body>
</html>
