<?php
session_start();
include 'database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        $message = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (fullname, email, password, phone) 
                VALUES ('$fullname', '$email', '$hashed_password', '$phone')"; 
        
        if (mysqli_query($conn, $sql)) {
            $message = "Registration successful! Please login.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Hotel Booking</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php if($message) echo "<div class='message'>$message</div>"; ?>
        <form method="POST">
            Full Name: <input type="text" name="fullname" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            Phone: <input type="text" name="phone"><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>