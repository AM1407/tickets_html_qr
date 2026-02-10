<?php
// Standalone CSV export to avoid any HTML output.
// This script returns only CSV content and exits.

// Ensure a session exists so we can read the logged-in user
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to the database
require 'includes/conn.php';

// Read the current user ID from the session
$currentUserId = $_SESSION['user_id'];

// Fetch the user's role (admin/client) from the database
$roleResult = mysqli_query($conn, "SELECT role FROM users WHERE id = $currentUserId LIMIT 1");

// If the query succeeded, fetch the row and use its role value.
// If the row is missing, fall back to 'client'. If the query failed, also fall back to 'client'.
$currentRole = $roleResult ? mysqli_fetch_assoc($roleResult)['role'] ?? 'client' : 'client';

// Only admins may export users
if ($currentRole !== 'admin') {
    http_response_code(403);
    exit('Forbidden');
}

// Fetch users (simple fields only)
$users = [];
$result = mysqli_query($conn, "SELECT id, name, email, role FROM users ORDER BY id ASC");
if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Ensure no previous output breaks the CSV
if (ob_get_length()) {
    ob_clean();
}

// Set headers so the browser downloads the CSV file.
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=users.csv');

// Example from request: fputcsv with delimiter, enclosure, escape.
$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Name', 'Email', 'Role'], ',', '"', '\\');

foreach ($users as $user) { // e.g. $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    fputcsv($output, [$user['id'], $user['name'], $user['email'], $user['role']], ',', '"', '\\');
}
// The CSV is generated in-memory and streamed to the response at fopen('php://output', 'w')
// and the fputcsv(...) loop. There’s no physical file created on disk.
fclose($output);
exit;
