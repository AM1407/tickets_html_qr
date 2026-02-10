<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// 1. MUST BE THE VERY FIRST LINE - No spaces above this!
session_start(); 

require_once 'classes/Database.php';
require_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();
$userObj = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = $userObj->login($email, $password);

    if ($userData) {
        // 2. Set Session Variables
        $_SESSION['user_id']   = $userData['id'];
        $_SESSION['email']     = $userData['email'];
        $_SESSION['name']      = $userData['name'];
        $_SESSION['user_role'] = $userData['role']; 
        
        // 3. Direct Redirect
        header("Location: index.php");
        exit(); // CRITICAL: Stops script execution immediately
    } else {
        header("Location: login.php?error=wrongpassword");
        exit();
    }
}

// 4. ONLY INCLUDE THE HEADER AFTER THE LOGIC BLOCK
include 'header.php'; 
?>