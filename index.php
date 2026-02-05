<?php
include 'includes/header.php';
require 'includes/conn.php';

// --- TEACHER'S LOGIC START ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Hash the password - teacher's key requirement
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $profile_pic_path = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        // Ensure directory exists
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "pdf" ) {
            $message = "Sorry, only JPG & PDF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic_path = $target_file;
            }
        }
    }

    $sql_insert = "INSERT INTO users (name, email, password, profile_pic) VALUES ('$name', '$email', '$hashed_password', '$profile_pic_path')";
    
    if (mysqli_query($conn, $sql_insert)) {
        $message = "New user created successfully!";
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch Users for the display list
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
// --- TEACHER'S LOGIC END ---
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

                <div class="card shadow-sm border-0">
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
                                <label class="form-label fw-semibold">Profile Picture (JPG/PDF)</label>
                                <input type="file" class="form-control" name="profile_pic" accept=".jpg,.jpeg,.pdf">
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" name="register" class="btn btn-primary btn-lg">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3 small">Already have an account? <a href="login.php" class="fw-bold text-decoration-none">Login</a></p>

                <div class="mt-5 p-3 bg-light rounded shadow-sm">
                    <h5 class="fw-bold">Existing Users:</h5>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <ul class="list-group list-group-flush">
                        <?php while ($assoc = mysqli_fetch_assoc($result)): ?>
                            <li class="list-group-item bg-transparent d-flex align-items-center">
                                <?php if (!empty($assoc['profile_pic'])): ?>
                                    <img src="<?= $assoc['profile_pic'] ?>" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                <?php endif; ?>
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($assoc['name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($assoc['email']) ?></div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">No users found.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>