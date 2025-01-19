<?php
include 'db.php';  // Include database connection

header('Content-Type: text/html; charset=UTF-8');  // Ensure the response is proper HTML

// Query the database to get the top 5 records with the lowest time
$query = "    SELECT 
        users.username,
        MAX(scoreboard.level) AS level,
        SUM(scoreboard.time) AS time
    FROM scoreboard
    JOIN users ON scoreboard.user_id = users.id
    GROUP BY scoreboard.user_id, users.username
    ORDER BY level DESC
    LIMIT 5";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

?>

<!-- Leaderboard HTML -->
<div class="leaderboard">
    <h2>Leaderboard</h2>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Level</th>
                <th>Time (seconds)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($leaderboard)) { ?>
                <tr>
                    <td colspan="4">No leaderboard data available.</td>
                </tr>
            <?php } else {
                $rank = 1;
                foreach ($leaderboard as $record) { ?>
                    <tr>
                        <td><?php echo $rank++; ?></td>
                        <td><?php echo htmlspecialchars($record['username']); ?></td>
                        <td><?php echo $record['level']; ?></td>
                        <td><?php echo $record['time']; ?> seconds</td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
