<?php
// 1. Establish the connection
require 'conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Capture and sanitize the form data
    $new_user = $_POST['username'] ?? '';
    $new_email = $_POST['email'] ?? '';
    $password_raw = $_POST['password'] ?? '';

    // 3. Hash the password for safety
    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

    try {
        // 4. Prepare the SQL INSERT statement
        // Assuming your table is named 'users' with columns: name, email, password
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);

        // 5. Execute the query
        $stmt->execute([
            'name'     => $new_user,
            'email'    => $new_email,
            'password' => $hashed_password
        ]);

        echo "User registered successfully! Refresh TablePlus to see them.";

    } catch (PDOException $e) {
        // Check if the email already exists (Duplicate entry error)
        if ($e->getCode() == 23000) {
            echo "Error: That email is already registered.";
        } else {
            echo "Registration failed: " . $e->getMessage();
        }
    }
}