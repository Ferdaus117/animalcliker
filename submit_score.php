<?php
include 'db.php';  // Include database connection

header('Content-Type: application/json'); // Ensure the response is in JSON format

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required POST parameters are set
    if (isset($_POST['user_id']) && isset($_POST['level']) && isset($_POST['time'])) {
        $userId = $_POST['user_id'];
        $level = $_POST['level'];
        $time = $_POST['time'];

        // Prepare and insert the score into the game_scores table
        $query = "INSERT INTO scoreboard (user_id, level, time) VALUES (:user_id, :level, :time)";
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute(['user_id' => $userId, 'level' => $level, 'time' => $time]);
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    }
}
?>
