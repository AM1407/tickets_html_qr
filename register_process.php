<?php
require 'includes/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // We halen de ruwe data op (geen escape_string meer nodig hier)
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Wachtwoord veilig hashen voordat het de database in gaat
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'client';

    // 1. Bereid de mal voor met vraagtekens voor de 4 kolommen
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");

    // 2. Koppel de variabelen aan de mal
    // "ssss" betekent: 4x een String (name, email, password, role)
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $role);

    // 3. Voer de opdracht uit
    if (mysqli_stmt_execute($stmt)) {
        // Succes: stuur de gebruiker naar de loginpagina
        header("Location: login.php?success=registered");
    } else {
        // Foutmelding als er iets misgaat (bijv. e-mail al in gebruik)
        echo "Fout bij registreren: " . mysqli_error($conn);
    }

    // 4. Sluit de instructie netjes af
    mysqli_stmt_close($stmt);
}
?>