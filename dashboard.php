<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$rooms_sql = "SELECT * FROM rooms WHERE status = 'available'";
$rooms_result = mysqli_query($conn, $rooms_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Hotel Booking</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <div class="container">
        <div class="nav">
            <span>Welcome, <?php echo $_SESSION['fullname']; ?>!</span>
            <a href="my_bookings.php"><button style="margin-left: 10px;">My Bookings</button></a>
            <a href="logout.php"><button class="logout">Logout</button></a>
        </div>
        
        <h2>Available Rooms</h2>
        
        <?php while($room = mysqli_fetch_assoc($rooms_result)) { ?>
        <div class="room-card">
            <h3>Room <?php echo $room['room_number']; ?></h3>
            <p>Type: <?php echo $room['room_type']; ?></p>
            <p>Price: PHP<?php echo $room['price_per_night']; ?> / night</p>
            <p>Max: <?php echo $room['max_people']; ?> people</p>
            <a href="room_booking.php?room_id=<?php echo $room['room_id']; ?>">
                <button>Book Now</button>
            </a>
        </div>
        <?php } ?>
    </div>
</body>
</html>