<?php
include 'db.php';  // Include database connection

header('Content-Type: text/html; charset=UTF-8');  // Ensure the response is proper HTML

// Query the database to get the top 5 records with the lowest time
$query = "SELECT 
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

<style>
    /* Leaderboard Container */
    .leaderboard {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .leaderboard h2 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #4CAF50;
        color: white;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .leaderboard h2 {
            font-size: 20px;
        }

        table th, table td {
            font-size: 14px;
            padding: 8px;
        }

        table {
            font-size: 14px;
        }

        table thead {
            display: block;
            overflow-x: auto;
        }

        table tbody {
            display: block;
            max-height: 300px;
            overflow-y: auto;
        }

        table td, table th {
            display: block;
            text-align: right;
        }

        table td::before {
            content: attr(data-label);
            font-weight: bold;
            float: left;
            text-align: left;
        }

        table td {
            text-align: left;
            padding-left: 50%;
        }
    }

    @media (max-width: 480px) {
        .leaderboard {
            padding: 10px;
        }

        table th, table td {
            padding: 6px;
        }

        table td::before {
            font-size: 12px;
        }
    }
</style>
