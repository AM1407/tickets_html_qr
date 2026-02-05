<?php
// 1. Include dependencies
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the register method (handles sanitization and hashing internally)
    $result = $userObj->register($name, $email, $password);

    if ($result) {
        $message = "New user created successfully!";
        
        // Log them in automatically by setting session variables
        $_SESSION['user_id'] = mysqli_insert_id($db);
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        
        // Optional: Trigger the toast message
        $_SESSION['toast_msg'] = "Welcome, $name!";
    } else {
        // If it fails, we show the database error for debugging
        $message = "Registration Error: " . mysqli_error($db);
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

    </div>
</div>

</body>
</html>