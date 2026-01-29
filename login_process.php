<?php
// We starten de "portier" die onthoudt wie je bent terwijl je door de site surft.
session_start(); 

// We halen de "sleutel" van de database op zodat we naar binnen kunnen.
require 'includes/conn.php'; 

// We controleren of iemand echt op de 'Submit' knop heeft gedrukt.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // We pakken de gegevens aan die de gebruiker in de tekstvakken heeft getypt.
    $email = $_POST['email'];
    $password = $_POST['password'];

    // STAP 1: We maken een veilige 'mal' van de zoekopdracht. 
    // Het vraagteken is een tijdelijke plekhouder zodat hackers geen eigen code kunnen injecteren.
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");

    // STAP 2: We vullen het vraagteken in met de echte e-mail. 
    // De "s" vertelt de database: "Dit is een String (tekst), geen commando."
    mysqli_stmt_bind_param($stmt, "s", $email);

    // STAP 3: We sturen de beveiligde envelop naar de database om de zoektocht te starten.
    mysqli_stmt_execute($stmt);

    // STAP 4: We vangen het resultaat op dat de database heeft gevonden.
    $result = mysqli_stmt_get_result($stmt);

    // We kijken of er een rij (gebruiker) in de database staat met dit e-mailadres.
    if ($row = mysqli_fetch_assoc($result)) {

        // We vergelijken het getypte wachtwoord met de versleutelde versie in de database.
        if (password_verify($password, $row['password'])) {
            
            // Wachtwoord klopt! We slaan je gegevens op in de sessie-map.
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            
            // We sturen je door naar de startpagina.
            header("Location: index.php");
        } else {
            // Wachtwoord was fout, stuur de gebruiker terug met een foutmelding.
            header("Location: login.php?error=wrongpassword");
        }
    } else {
        // De e-mail staat niet in ons systeem.
        header("Location: login.php?error=notfound");
    }

    // We ruimen de tijdelijke mal op om geheugen vrij te maken.
    mysqli_stmt_close($stmt);
}
?>