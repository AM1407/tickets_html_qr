<?php
// 1. Include the header
include 'includes/header.php';

// 2. Include your new classes
require_once 'classes/Database.php';
require_once 'classes/User.php';

// 3. Initialize the OOP environment
$database = new Database();
$dbConn = $database->getConnection();
$userObj = new User($dbConn);

$message = "";

// 4. Handle the login logic via the User class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the check routine inside the class
    $userData = $userObj->login($email, $password);

    if ($userData) {
        // Success: the class returned user data
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['name'] = $userData['name'];

        header("Location: index.php");
        exit(); 
    } else {
        // Failure: class returned false
        $message = "Invalid email or password.";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h1 class="fw-bold">Login</h1>
                <p class="text-muted">Welcome back! Please enter your details.</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-danger shadow-sm py-2 text-center">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="••••••••" required>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-3">
                Don't have an account? <a href="index.php" class="fw-bold text-decoration-none">Register here</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>