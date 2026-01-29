<?php
require 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Securely hash the password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'client')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?success=registered");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>