-- Create Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Encrypted password
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Flights table
CREATE TABLE flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_model VARCHAR(100) NOT NULL,
    name VARCHAR(150) NOT NULL,
    total_seats INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    departure_city VARCHAR(100) NOT NULL,
    destination_city VARCHAR(100) NOT NULL,
    departure_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    seat_number VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    age INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    payment_status ENUM('pending', 'completed') DEFAULT 'pending',
    payment_method VARCHAR(50),
    payment_amount DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE,
    UNIQUE (flight_id, seat_number) -- Ensures a seat can only be booked once
);

-- Create Seats table (Tracks available and reserved seats for each flight)
CREATE TABLE seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_id INT NOT NULL,
    seat_number VARCHAR(10) NOT NULL,
    is_reserved BOOLEAN DEFAULT FALSE,
    reserved_by INT,
    FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE,
    FOREIGN KEY (reserved_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE (flight_id, seat_number) -- Ensures no duplicate seat numbers for a flight
);

-- Insert Admin User
INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@gmail.com', SHA2('Admin@123', 256), 'admin');