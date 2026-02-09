<?php
// Standalone CSV export to avoid any HTML output.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'includes/conn.php';

// Basic access check (only logged-in admins)
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Forbidden');
}

$currentUserId = (int)$_SESSION['user_id'];
$roleResult = mysqli_query($conn, "SELECT role FROM users WHERE id = $currentUserId LIMIT 1");
$currentRole = $roleResult ? mysqli_fetch_assoc($roleResult)['role'] ?? 'client' : 'client';

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

fclose($output);
exit;
