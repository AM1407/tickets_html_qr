<?php
include 'includes/header.php';
?>

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