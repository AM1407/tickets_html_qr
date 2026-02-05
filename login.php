<?php
// Include the header which starts the session and provides HTML structure
include 'includes/header.php';
// Include the database connection file
require 'includes/conn.php';

// Initialize message variable
$message = "";

// Check if the form is submitted via POST (Teacher's logic)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Raw password for verification

    // Prepare SQL query to fetch the user with the given email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if a user with that email exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct! Store user details in SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];

            // Redirect to home page
            header("Location: index.php");
            exit(); 
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
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

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger shadow-sm py-2 text-center">
                    <?php 
                        if ($_GET['error'] == 'wrongpassword') echo "Invalid password. Please try again.";
                        if ($_GET['error'] == 'notfound') echo "No account found with that email.";
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success shadow-sm py-2 text-center">
                    Registration successful! Please login.
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