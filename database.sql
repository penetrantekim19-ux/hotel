CREATE DATABASE hotel_booking_system;
USE hotel_booking_system;


CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    PRIMARY KEY (user_id)
);


CREATE TABLE rooms (
    room_id INT NOT NULL AUTO_INCREMENT,
    room_number VARCHAR(10) NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    price_per_night DECIMAL(10,2) NOT NULL,
    max_people INT NOT NULL,
    status VARCHAR(20) DEFAULT 'available',
    PRIMARY KEY (room_id)
);


CREATE TABLE reservations (
    reservation_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    total_price DECIMAL(10,2),
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'confirmed',
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);


CREATE TABLE payments (
    payment_id INT NOT NULL AUTO_INCREMENT,
    reservation_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_status VARCHAR(20) DEFAULT 'pending',
    PRIMARY KEY (payment_id),
    FOREIGN KEY (reservation_id) REFERENCES reservations(reservation_id)
);


INSERT INTO rooms (room_number, room_type, price_per_night, max_people) VALUES
('101', 'Standard', 350.00, 2),
('102', 'Standard', 350.00, 2),
('103', 'Standard', 350.00, 2),
('104', 'Standard', 350.00, 2),
('105', 'Standard', 350.00, 2),
('106', 'Standard', 350.00, 2),
('107', 'Standard', 350.00, 2),
('108', 'Standard', 350.00, 2),
('109', 'Standard', 350.00, 2),
('110', 'Standard', 350.00, 2),
('201', 'Deluxe', 480.00, 3),
('202', 'Deluxe', 480.00, 3),
('203', 'Deluxe', 480.00, 3),
('204', 'Deluxe', 480.00, 3),
('205', 'Deluxe', 480.00, 3),
('206', 'Deluxe', 480.00, 3),
('207', 'Deluxe', 480.00, 3),
('208', 'Deluxe', 480.00, 3),
('209', 'Deluxe', 480.00, 3),
('210', 'Deluxe', 480.00, 3),
('301', 'Suite', 1500.00, 4),
('302', 'Suite', 1500.00, 4),
('303', 'Suite', 1500.00, 4),
('304', 'Suite', 1500.00, 4),
('305', 'Suite', 1500.00, 4),
('306', 'Suite', 1500.00, 4),
('307', 'Suite', 1500.00, 4),
('308', 'Suite', 1500.00, 4),
('309', 'Suite', 1500.00, 4),
('310', 'Suite', 1500.00, 4);