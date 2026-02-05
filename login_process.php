<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();
$userObj = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 3. Call the Login method from your class
    $userData = $userObj->login($email, $password);

    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['name'] = $userData['name'];
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php?error=wrongpassword");
        exit();
    }
}