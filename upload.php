<?php
include 'includes/header.php';
require 'includes/conn.php';
?>

<div class="container mt-5"> <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4 text-center">Verification info</h2>
                    <form action="upload_process.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Select PDF file</label>
                            <input type="file" class="form-control" name="identity_pdf" accept=".pdf" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Upload Document</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 small text-muted">Accepted formats: PDF. Max size: 25MB.</p>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>