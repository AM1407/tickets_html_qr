<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Order.php'; // ADD THIS LINE!

if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();
    
    // Now this line will work because you 'required' the class above
    $orderObj = new Order($db);

    $user_id = $_SESSION['user_id'];
    $quantity = (int)$_POST['amount'];

    if ($orderObj->createOrder($user_id, $quantity)) {
        header("Location: index.php?success=order_placed");
    } else {
        header("Location: order.php?error=order_failed");
    }
    exit();
}
?>