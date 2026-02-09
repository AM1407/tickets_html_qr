<?php
include 'includes/header.php';
?>

<?php
// 1. Initial variables
$message_sent = false;
$error_message = "";

// 2. Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capture the form data
    $customer_name    = $_POST['name']    ?? 'Valued Customer';
    $customer_email   = $_POST['email']   ?? '';
    $customer_message = $_POST['message'] ?? '';

    // 3. Reuse your existing PHPMailer logic
    // We wrap this in a try-catch to handle errors gracefully
    try {
        // We "import" your existing PHPMailer setup here
        // Make sure the path to send_ticket.php is correct!
        require 'send_contact.php'; 

        sendContactEmail($customer_name, $customer_email, $customer_message);
        
        $message_sent = true;
    } catch (Exception $e) {
        $error_message = "Logic Error: " . $e->getMessage();
    }
}
?>

<?php if ($message_sent): ?>
    <div class="success">
        <strong>Sent!</strong> Your message has been sent successfully. We will get back to you shortly.
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h1 class="fw-bold">Contact Us</h1>
                <p class="text-muted">Have a question or need help? Send us a message.</p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="send_contact.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                   value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" 
                                   placeholder="name@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" name="subject" id="subject" required>
                                <option value="" selected disabled>Choose a reason...</option>
                                <option value="support">Technical Support</option>
                                <option value="billing">Billing Inquiry</option>
                                <option value="feedback">General Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="bi bi-send-fill"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <p class="small text-muted mb-0">Typical response time is within 24 hours.</p>
                <p class="small text-muted">support@yourdomain.com</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>