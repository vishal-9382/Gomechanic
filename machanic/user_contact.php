<?php
include('../database.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $query = "INSERT INTO contact_queries (name, email, message, user_type) VALUES ('$name', '$email', '$message', 'User')";
    
    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Query sent successfully!'); window.location='user_contact.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Contact Us</title>
</head>
<body>
    <h2>Contact Admin (User)</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
