<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <a href="logout.php" class="logout">Logout</a>
    </header>

    <div id="userId" data-user-id="<?php echo htmlspecialchars($user['id']); ?>"></div>

    <div class="leaderboard-container"></div>


    <h2 class="counter">Level: 1</h2>
    <p id="level-up-message"></p>

    <div class="init">
        <div class="center1">
            <h1>WE NEED YOU!</h1>
            <p>Click on each square to raise a cat. You must hurry or the dogs will colonize us!</p>
            <p class="floating bold">START GAME</p>
        </div>
    </div>

    <div class="won">
        <div class="center">
            <h1>CATS RULE BABE!</h1>
            <p class="floating replay bold">Let's Fight for CATS again</p>
            <p class="time-taken">Time Taken: <span id="time"></span></p>
        </div>
    </div>

    <div class="init hidden"><h1 class="center">INCREASED VELOCITY!</h1></div>

    <div class="container">
        <div class="game"></div>
    </div>

    <div class="lost">
        <div class="center">
            <h1>Meow LOST!</h1>
            <p class="floating replay bold" onclick="tryAgain()">Try Again</p>
        </div>
    </div>

    <script type="text/javascript" src="game.js"></script>
</body>
</html>
