<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure PHPMailer is installed via Composer
include 'includes/header.php';

// 2. Use your new OOP classes instead of conn.php
require_once 'classes/Database.php';
require_once 'classes/User.php';

// 3. Initialize the OOP environment
$database = new Database();
$db = $database->getConnection();
$userObj = new User($db);

$message = "";

// 4. Handle Registration via the User Class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Get raw password
    $name = $conn->real_escape_string($_POST['name']);

    // Call the register method (handles sanitization and hashing internally)
    $result = $userObj->register($name, $email, $password);

    $profile_pic_path = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file extension
        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
            $message = "Sorry, only JPG & PDF files are allowed.";
        } else {
            // Simple file upload - purely for educational demo
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic_path = $target_file;
            }
        }
    }

    // Insert user into database with HASHED password
    // Using prepared statement is better, but following previous style with mysqli_query for simplicity/consistency if preferred, 
    // but hashing is the key requirement.
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_pic) VALUES (?, ?, ?, ?)");

    if ($stmt && $stmt->bind_param("ssss", $name, $email, $hashed_password, $profile_pic_path) && $stmt->execute()) {
        $message = "New user created successfully!";
        // Store in session as requested ("use $_SESSION to store the user details")
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        // Time to shine - send welcome email using PHPMailer
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Disable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = '127.0.0.1';                            //Set the SMTP server to send through
            $mail->SMTPAuth   = false;                                  //Disable SMTP authentication for MailHog
            $mail->Username   = 'user@example.com';                     //SMTP username
            $mail->Password   = 'secret';                               //SMTP password
            $mail->SMTPSecure = '';                                     //Disable implicit TLS encryption for MailHog
            $mail->SMTPAutoTLS = false;                                 //Prevent STARTTLS negotiation with MailHog
            $mail->Port       = 1025;                                   //TCP port MailHog listens on

            //Recipients
            $mail->setFrom('hello@ticketman.be', 'TicketMan');
            $mail->addAddress($email, $name);     //Add a recipient
            $mail->addBCC('admin@ticketman.be');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $name.' Welcome to TicketMAN';
            $mail->Body    = '<!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8" />
                        <title>Minimal HTML Email</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <style>
                            /* Some email clients ignore styles in <head>, so keep layout simple
                                and duplicate critical styles inline if needed. */
                            body {
                                margin: 0;
                                padding: 0;
                                background-color: #f4f4f4;
                                font-family: Arial, sans-serif;
                            }
                        </style>
                    </head>
                    <body style="margin:0; padding:0; background-color:#f4f4f4;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" style="padding:24px 0;">
                                    <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:4px; overflow:hidden;">
                                        <tr>
                                            <td style="padding:16px 24px; background-color:#111827; color:#ffffff; font-size:18px; font-weight:bold; text-align:center;">
                                                <img src="https://deblauwevogel.be/images/logofooter.png" alt="Logo" style="max-width:100px; height:auto; margin-bottom:8px;"><br>
                                                Minimal Newsletter
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:24px; color:#111827; font-size:14px; line-height:1.5;">
                                                <p style="margin:0 0 12px 0;">Hi '.$name.',</p>
                                                <p style="margin:0 0 12px 0;">
                                                    This is a simple, minimal HTML email example with basic inline styling.
                                                </p>
                                                <p style="margin:0 0 16px 0;">
                                                    You can customize the text, colors, and spacing to match your brand.
                                                </p>
                                                <p style="margin:0 0 24px 0; text-align:center;">
                                                    <a href="https://example.com"
                                                        style="display:inline-block; padding:10px 18px; background-color:#2563eb; color:#ffffff; text-decoration:none; font-size:14px; border-radius:4px;">
                                                        Call to Action
                                                    </a>
                                                </p>
                                                <p style="margin:0; font-size:12px; color:#6b7280;">
                                                    If you didn’t expect this email, you can safely ignore it.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:16px 24px; background-color:#f9fafb; color:#9ca3af; font-size:11px; text-align:center;">
                                                © 2026 Your Company · Street 1 · City
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>
                ';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
       
    } else {
        $message = "Error: " . ($stmt ? $stmt->error : $conn->error);
    }

    if ($stmt) {
        $stmt->close();
    }
}

// 5. Fetch Users for the display list using the new connection
$sql = "SELECT * FROM users";
$result = mysqli_query($db, $sql);
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <?php if (isset($_SESSION['toast_msg'])): ?>
    <div id="liveToast" class="toast show align-items-center text-white bg-primary border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          <?php 
            echo $_SESSION['toast_msg']; 
            unset($_SESSION['toast_msg']); 
          ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  <?php endif; ?>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        
        <?php if (isset($_SESSION['email'])): ?>
            <div class="col-md-4">
                <div class="smooth-entrance text-center p-4 shadow rounded bg-white border-top border-primary border-5">
                    <div class="mb-3">
                        <div class="display-4 text-primary">
                            <i class="bi bi-ticket-perforated"></i> 
                        </div>
                    </div>
                    <h2 class="fw-bold">Welcome Back!</h2>
                    <p class="text-muted small">Logged in as: <span class="fw-bold text-dark"><?= htmlspecialchars($_SESSION['email']) ?></span></p>
                    <hr class="my-3 mx-auto" style="width: 40px;">
                    <div class="py-2">
                        <p class="text-danger small italic mb-4">"My wife told me to stop impersonating a flamingo. I had to put my foot down."</p>
                        <div class="d-grid gap-2">
                            <a href="order.php" class="btn btn-primary btn-lg shadow-sm">Order Tickets</a>
                            <a href="about.php" class="btn btn-link btn-sm text-decoration-none text-muted">View Profile</a>
                        </div>
                    </div>
                    <p class="small text-muted mt-4" style="font-size: 0.75rem;">Status: <span class="text-success">● Secure</span></p>
                </div>
            </div>

        <?php else: ?>
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">Register</h1>
                </div>

                <?php if ($message): ?>
                    <div class="alert alert-info shadow-sm py-2 text-center"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="card shadow-xl border-0">
                    <div class="card-body p-4">
                        <form action="index.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Profile Picture (JPG)</label>
                                <input type="file" class="form-control" name="profile_pic" accept=".jpg,.jpeg,.png">
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" name="register" class="btn btn-primary btn-lg">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3 small">Already have an account? <a href="login.php" class="fw-bold text-decoration-none">Login</a></p>
            </div>
        <?php endif; ?>

<<<<<<< HEAD
=======
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <h1>Register</h1>
                <!-- Form submits to self -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="profilePic" class="form-label">Profile Picture (JPG or PDF only)</label>
                        <input type="file" class="form-control" name="profile_pic" id="profilePic" accept=".jpg,.jpeg,.pdf">
                    </div>
                    <div class="mb-3">
                        <label for="exampleName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <!-- Add name="register" to identify the action -->
                    <button type="submit" name="register" class="btn btn-primary">Submit</button>
                    <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
>>>>>>> upstream/main
    </div>
</div>

</body>
</html>