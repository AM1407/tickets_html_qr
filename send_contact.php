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
        $mail->Host       = '127.0.0.1';
        $mail->SMTPAuth   = false;      
        $mail->Port       = 1025;       

        // --- Email Headers ---
        $mail->setFrom('system@ticketsite.test', 'Ticket System');
        $mail->addAddress('admin@ticketsite.test'); 
        
        if (!empty($customer_email)) {
            $mail->addReplyTo($customer_email, $customer_name);
        }

        // --- Load and Prepare Template ---
        // 1. Fetch the HTML file content
        $email_body = file_get_contents('email_template.html'); 

        // 2. Replace placeholders (Check your DBV.html for these names)
        // This assumes you used {{name}}, {{message}}, etc. in your HTML file
        $email_body = str_replace('{{name}}', htmlspecialchars($customer_name), $email_body);
        $email_body = str_replace('{{email}}', htmlspecialchars($customer_email), $email_body);
        $email_body = str_replace('{{subject}}', htmlspecialchars($customer_subject), $email_body);
        $email_body = str_replace('{{message}}', nl2br(htmlspecialchars($customer_message)), $email_body);

        // --- Content ---
        $mail->isHTML(true);
        $mail->Subject = "New Ticket Inquiry: " . $customer_subject;
        $mail->Body    = $email_body;
        
        // Plain text version for security/compatibility
        $mail->AltBody = strip_tags($customer_message); 

        $mail->send();
        
        header("Location: contact.php?sent=1");
        exit();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Please submit the form first.";
}