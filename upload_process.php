<?php

ini_set('upload_max_filesize', '25M');
ini_set('post_max_size', '30M');
ini_set('memory_limit', '64M');

session_start();
require 'includes/conn.php';

// 1. Initial validation: Check if file exists and there are no PHP upload errors
if (!isset($_FILES['identity_pdf']) || $_FILES['identity_pdf']['error'] !== UPLOAD_ERR_OK) {
    die("File upload error. Error code: " . ($_FILES['identity_pdf']['error'] ?? 'No file'));
}

$file = $_FILES['identity_pdf'];
$max_size = 25 * 1024 * 1024; // 25MB

// 2. Size Validation
if ($file['size'] > $max_size) {
    die("File size exceeds the 25MB limit.");
}

// 3. MIME Type Validation (More secure than just checking extension)
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($file['tmp_name']);
if ($mime_type !== 'application/pdf') {
    die("Invalid file type. Only PDF files are allowed.");
}

// 4. Extension Validation
$original_name = basename($file['name']);
$extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
if ($extension !== 'pdf') {
    die("Invalid file extension.");
}

// 5. Security check
if (!is_uploaded_file($file['tmp_name'])) {
    die("Possible file upload attack detected.");
}

// 6. Prepare Destination
$safe_name = preg_replace("/[^a-zA-Z0-9_-]/", "", pathinfo($original_name, PATHINFO_FILENAME));
$unique_name = uniqid('pdf_', true) . '_' . $safe_name . '.pdf';
$upload_dir = __DIR__ . '/uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$destination = $upload_dir . $unique_name;

// 7. Move file and save to Session
if (move_uploaded_file($file['tmp_name'], $destination)) {
    $_SESSION['identity_form'] = $unique_name;
    
    // Set a "flash" message for the toast
    $_SESSION['toast_msg'] = "File uploaded successfully!";
    $_SESSION['toast_type'] = "success";

    header("Location: index.php"); // Redirect to homepage
    exit();
    
} else {
    die("Failed to move uploaded file. Check folder permissions.");
}
?>