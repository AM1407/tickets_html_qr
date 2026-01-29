<?php
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php if (isset($_SESSION['email'])): ?>
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h1 class="text-center mb-4">Place Order</h1>
                        <p class="text-center text-muted">Hello, <span class="fw-bold"><?= htmlspecialchars($_SESSION['email']) ?></span></p>
                        
                        <div class="alert alert-info text-center py-3">
                            <h4 class="mb-0">Price: <span class="fw-bold">45 EUR</span> <small class="text-muted">/ ticket</small></h4>
                        </div>

                        <form action="orderprocess.php" method="post" class="mt-4">
                            <div class="mb-3">
                                <label for="amount" class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control form-control-lg" name="amount" id="amount" value="1" required>
                            </div>

                            <p class="small text-muted italic">
                                <span class="text-danger fw-bold">Note:</span> Tickets are <span class="text-danger">not refundable</span>. Please use common sense and do not resell them.
                            </p>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Confirm Order</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <div class="card border-danger shadow-sm mt-5">
                    <div class="card-body text-center p-5">
                        <h2 class="text-danger fw-bold">Access Denied</h2>
                        <p class="lead">You must be logged in to order tickets.</p>
                        <hr>
                        <a href="login.php" class="btn btn-outline-primary">Go to Login</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>