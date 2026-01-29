<?php
include 'includes/header.php'; // Added missing semicolon
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <h1 class="mb-4">Account Overview</h1>
                    
                    <?php if (isset($_SESSION['email'])): ?>
                        <div class="mb-4">
                            <div class="display-6 mb-2">👋</div>
                            <p class="lead">Welcome back,</p>
                            <h4 class="text-primary font-monospace"><?= htmlspecialchars($_SESSION['email']) ?></h4>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-grid gap-2">
                            <a href="dashboard.php" class="btn btn-outline-secondary">Go to Dashboard</a>
                            <a href="logout.php" class="btn btn-danger">Log Out</a>
                        </div>
                    <?php else: ?>
                        <div class="py-4">
                            <p class="text-muted">You are not currently logged in.</p>
                            <a href="index.php" class="btn btn-primary">Return to Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>