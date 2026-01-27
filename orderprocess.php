<?php
include 'includes/header.php';
$amount = $_POST['amount'];
$email = $_SESSION['email'];
$total = $amount * 45;
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Thank you for your order</h2>
             <p>You need to pay <?php echo $total ?> EUR<p>
            <p>An email with your ticket will be sent to your email adress: <?php echo $email ?></p>
        </div>
    </div>
</div>