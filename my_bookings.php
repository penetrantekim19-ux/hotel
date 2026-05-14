<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.reservation_id, rm.room_number, rm.room_type, r.check_in_date, 
               r.check_out_date, r.total_price, r.status, p.payment_status
        FROM reservations r
        JOIN rooms rm ON r.room_id = rm.room_id
        LEFT JOIN payments p ON r.reservation_id = p.reservation_id
        WHERE r.user_id = $user_id
        ORDER BY r.booking_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings - Hotel Booking</title>
    <link rel="stylesheet" href="assets/css/my_bookings.css">
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="dashboard.php"><button>Back to Rooms</button></a>
            <a href="logout.php"><button>Logout</button></a>
        </div>
        
        <h2>My Booking History</h2>
        
        <table>
            <tr>
                <th>Room</th>
                <th>Type</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['room_number']; ?></td>
                <td><?php echo $row['room_type']; ?></td>
                <td><?php echo $row['check_in_date']; ?></td>
                <td><?php echo $row['check_out_date']; ?></td>
                <td>$<?php echo $row['total_price']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>