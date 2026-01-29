<?php
session_start(); // Start de sessie om te controleren wie er is ingelogd
require 'includes/conn.php'; // Maak verbinding met de database

// Controleer of de gebruiker is ingelogd en of de data via POST komt
if (isset($_SESSION['email']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Gegevens ophalen uit de sessie en het formulier
    $email = $_SESSION['email'];
    $amount = (int)$_POST['amount']; // Forceer een integer voor extra veiligheid
    if ($amount <= 0) {
        // Stuur de gebruiker terug met een specifieke error-code
        header("Location: order.php?error=invalid_amount");
        exit(); // Stop de rest van het script!
    }
    $status = 'paid'; // Standaard status voor een nieuwe bestelling

    // 1. Bereid de SQL-opdracht voor met vraagtekens als veilige placeholders
    // Gebaseerd op jouw database kolommen: email, amount en status
    $sql = "INSERT INTO orders (email, amount, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // 2. Koppel de variabelen aan de placeholders
        // "sis" = string (email), integer (amount), string (status)
        mysqli_stmt_bind_param($stmt, "sis", $email, $amount, $status);

        // 3. Voer de opdracht uit in de database
        if (mysqli_stmt_execute($stmt)) {
            // Succes: stuur naar homepage met succes-melding voor de Toast
            header("Location: index.php?success=order_placed");
            exit();
        } else {
            // Database fout: stuur terug met foutmelding
            header("Location: order.php?error=order_failed");
            exit();
        }

        // Sluit de statement netjes af
        mysqli_stmt_close($stmt);
    } else {
        // Fout bij het voorbereiden van de query
        header("Location: order.php?error=order_failed");
        exit();
    }
} else {
    // Gebruiker is niet ingelogd of probeert de pagina direct te bezoeken
    header("Location: login.php");
    exit();
}
?>