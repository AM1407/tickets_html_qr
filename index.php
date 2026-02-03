<?php
include 'includes/header.php';
require 'includes/conn.php';
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <?php if (isset($_SESSION['toast_msg'])): ?>
    <div id="liveToast" class="toast show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?php 
            echo $_SESSION['toast_msg']; 
            unset($_SESSION['toast_msg']); // Clear it so it doesn't show again on refresh
          ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            
<?php if (isset($_SESSION['email'])): ?>
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
<?php else: ?>
    <div class="text-center mb-4">
        <h1 class="fw-bold">Register</h1>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="register_process.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                </div>
            </form>
        </div>
    </div>
    <p class="text-center mt-3 small">Already have an account? <a href="login.php" class="fw-bold text-decoration-none">Login</a></p>
<?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>