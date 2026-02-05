<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

// 1. Initialize DB and User Class
$database = new Database();
$db = $database->getConnection();
$userObj = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. Call the Register method from your class
    // This replaces the old mysqli_query() line
    $result = $userObj->register($name, $email, $password);

    if ($result) {
        // Success! Redirect to login with a success message
        header("Location: login.php?success=1");
        exit();
    } else {
        // Error!
        echo "<h1>Registration Failed</h1>";
        echo "Error details: " . mysqli_error($db);
        exit();
    }
}