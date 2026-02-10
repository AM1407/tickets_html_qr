<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            margin: 0;
        }

        .navbar {
            background: rgba(33, 37, 41, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 3px solid #764ba2;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: 0.3s;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: scale(1.02);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .smooth-entrance {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-5">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-ticket-detailed-fill me-2"></i>TICKET.SYS
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto"> 
                <a class="nav-link px-3" href="index.php">Home</a>
                <a class="nav-link px-3" href="about.php">About</a>
                <a class="nav-link px-3" href="order.php">Order</a>
                <a class="nav-link px-3" href="contact.php">Contact</a>
                <a class="nav-link px-3" href="upload.php">Upload</a>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a class="nav-link px-3" href="admin_dash.php">Admin</a>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['email'])): ?>
                    <div class="ms-lg-3">
                        <a class="btn btn-outline-danger btn-sm fw-bold px-3" href="logout.php">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const toastEl = document.getElementById('liveToast');
    const toastMessage = document.getElementById('toastMessage');
    
    // Initialiseer de Bootstrap toast
    const toastTrigger = new bootstrap.Toast(toastEl);

    let message = "";
    let bgColor = "bg-danger"; // Standaard rood voor fouten

    // Check voor Errors
    if (urlParams.has('error')) {
        const error = urlParams.get('error');
        if (error === 'wrongpassword') message = "Oei! Dat wachtwoord klopt niet.";
        if (error === 'notfound') message = "Gebruiker niet gevonden.";
        if (error === 'order_failed') message = "Er ging iets mis met je bestelling.";
        if (error === 'invalid_amount') message = "Je moet wel minstens 1 ticket bestellen, slimmerik!"; 
        bgColor = "bg-danger";
    } 
    // Check voor Succes
    else if (urlParams.has('success')) {
        const success = urlParams.get('success');
        if (success === 'registered') {
            message = "Gelukt! Je kunt nu inloggen.";
            bgColor = "bg-success";
        }
        if (success === 'order_placed') {
            message = "Tickets besteld! Check je mail.";
            bgColor = "bg-primary";
        }
    }

    if (message !== "") {
        toastEl.classList.add(bgColor);
        toastMessage.textContent = message;
        toastTrigger.show();
    }
});
</script>


    

    
