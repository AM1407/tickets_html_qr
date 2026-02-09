<?php
// Enable error reporting so you see errors instead of a white screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the data from your form names
    $customer_name    = $_POST['name']    ?? 'Guest';
    $customer_email   = $_POST['email']   ?? '';
    $customer_message = $_POST['message'] ?? '';
    $customer_subject = $_POST['subject'] ?? 'Contact Form';

    $mail = new PHPMailer(true);

    try {
        // --- MailHog Settings ---
        $mail->isSMTP();
        $mail->Host       = '127.0.0.1'; // Ensure no http:// here
        $mail->SMTPAuth   = false;       // MailHog doesn't need a password
        $mail->Port       = 1025;        // SMTP port from your terminal

        // --- Email Headers ---
        $mail->setFrom('system@ticketsite.test', 'Ticket System');
        $mail->addAddress('admin@ticketsite.test'); 
        
        // VALIDATION: Only add Reply-To if email isn't empty
        if (!empty($customer_email)) {
            $mail->addReplyTo($customer_email, $customer_name);
        }

        // --- Content ---
        $mail->isHTML(true);
        $mail->Subject = "New Ticket Inquiry: " . $customer_subject;
        $mail->Body    = "<b>Name:</b> $customer_name <br> <b>Message:</b><br>" . nl2br(htmlspecialchars($customer_message));

        $mail->send();
        
        // SUCCESS: Redirect back to contact page
        header("Location: contact.php?sent=1");
        exit();

    } catch (Exception $e) {
        // This will print the error if MailHog is unreachable
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Please submit the form first.";
}