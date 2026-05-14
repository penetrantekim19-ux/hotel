<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$room_id = $_GET['room_id'];
$error = "";


$room_query = "SELECT * FROM rooms WHERE room_id = $room_id";
$room_result = mysqli_query($conn, $room_query);
$room = mysqli_fetch_assoc($room_result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    
   
    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $nights = $date1->diff($date2)->days;
    $total = $nights * $room['price_per_night'];
    
    
    $sql = "INSERT INTO reservations (user_id, room_id, check_in_date, check_out_date, total_price) 
            VALUES ('$user_id', '$room_id', '$check_in', '$check_out', '$total')";
    
    if (mysqli_query($conn, $sql)) {
        $reservation_id = mysqli_insert_id($conn);
        
        
        $payment_sql = "INSERT INTO payments (reservation_id, amount, payment_status) 
                        VALUES ('$reservation_id', '$total', 'pending')";
        mysqli_query($conn, $payment_sql);
        
        
        $update_room = "UPDATE rooms SET status = 'booked' WHERE room_id = $room_id";
        mysqli_query($conn, $update_room);
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Booking failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Room - Hotel Booking</title>
    <link rel="stylesheet" href="assets/css/room_booking.css">
</head>
<body>
    <div class="container">
        <h2>Book Room <?php echo $room['room_number']; ?></h2>
        <p>Type: <?php echo $room['room_type']; ?></p>
        <p>Price: PHP<?php echo $room['price_per_night']; ?> per night</p>
        
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        
        <form method="POST">
            Check-in Date: 
            <input type="date" name="check_in" required><br>
            
            Check-out Date: 
            <input type="date" name="check_out" required><br>
            
            <button type="submit">Confirm Booking</button>
        </form>
        <a href="dashboard.php">Back to Rooms</a>
    </div>
</body>
</html>