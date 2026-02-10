<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "playground_db";

if (!($conn = mysqli_connect($servername, $username, $password, $dbname))) {
    die("Connection failed: " . mysqli_connect_error());
}