🎫 Ticket System Project
Dit project is een veilig en modern ticketsysteem, gebouwd met PHP, MySQL en Bootstrap. Hieronder volgt een overzicht van de belangrijkste verbeteringen en beveiligingsmaatregelen die zijn toegepast.

🛡️ Beveiliging & Database
Prepared Statements: Ik heb alle directe SQL-query's vervangen door Prepared Statements. Dit voorkomt SQL-injectie, omdat gebruikersinvoer nu strikt als data wordt behandeld en niet als uitvoerbare code.

Password Hashing: Wachtwoorden worden niet langer in platte tekst opgeslagen. Ik gebruik password_hash() bij registratie en password_verify() bij het inloggen. Hierdoor zijn gebruikersgegevens veilig, zelfs als de database op straat zou komen te liggen.

Input Validatie: Er is server-side controle toegevoegd om ongeldige bestellingen (zoals 0 of negatieve tickets) te blokkeren voordat ze de database bereiken.

💻 User Experience (UX)
Dynamische Homepage: De homepage past zich aan op basis van de login-status. Ingelogde gebruikers zien een welkomsscherm met animaties, terwijl gasten het registratieformulier zien.

Bootstrap Toasts: In plaats van ouderwetse pop-ups of tekstblokken, gebruikt het systeem nu Toasts. Deze subtiele meldingen geven direct feedback bij succesvolle acties (zoals bestellen) of fouten (zoals een verkeerd wachtwoord).

Glassmorphism Navbar: Een moderne, semi-transparante navigatiebalk met hover-effecten die meekleurt met de branding van het systeem.

📊 Database Structuur
Orders Tabel: Er is een relationele koppeling gemaakt tussen gebruikers en hun aankopen via een nieuw aangemaakte orders tabel, waarin e-mail, aantal en status worden bijgehouden.