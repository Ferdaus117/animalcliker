<?php
include 'db.php';  // Include your database connection

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];  // User ID from session
    $level = $_POST['level'];     // Current game level
    $time = $_POST['time'];       // Time taken to complete the level

    try {
        // Insert game data into the database
        $stmt = $conn->prepare("INSERT INTO scoreboard (user_id, level, time) VALUES (:user_id, :level, :time)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        echo 'Game data saved successfully!';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request method.';
}
?>
