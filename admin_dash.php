<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

?>



<?php
require 'includes/conn.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TicketSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: rgba(255,255,255,.75); border-radius: 5px; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,.1); }
        .card { border: none; border-radius: 10px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <h4 class="text-center mb-4">Ticket Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Manage Users</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-ticket-perforated me-2"></i> Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                <hr>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary px-3 mx-3">Export Report</button>
                    <a type="button" class="btn btn-sn btn-outline-danger" href="index.php">Home</a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 bg-primary text-white">
                        <h5>Total Users</h5>
                        <h2>1,250</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 bg-success text-white">
                        <h5>Tickets Sold</h5>
                        <h2>842</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 bg-warning text-dark">
                        <h5>Revenue</h5>
                        <h2>$12,450</h2>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Registrations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td><span class="badge bg-info">Client</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>