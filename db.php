<?php
$host = 'sql12.freesqldatabase.com';
$dbname = 'sql12758286';
$user = 'sql12758286';
$password = 'nZIhDvvjQ8';
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
