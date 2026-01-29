<?php
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h1 class="fw-bold">Login</h1>
                <p class="text-muted">Welcome back! Please enter your details.</p>
            </div>

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
                    <form action="login_process.php" method="post">
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