<?php
session_start();
include 'database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Wrong password!";
        }
    } else {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Hotel Booking</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <h2>Login to Book Hotel</h2>
        <?php if($message) echo "<div class='message'>$message</div>"; ?>
        <form method="POST">
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>New user? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>