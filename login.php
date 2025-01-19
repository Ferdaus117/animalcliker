<?php
include 'db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    try {
        // Debug: Input data before database query
        echo "<p>Debug: Username entered: $username</p>";

        // Query database for the user by username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        // Debug: After database query
        echo "<p>Debug: Query executed successfully.</p>";

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Check if user data was fetched
        if ($user) {
            echo "<p>Debug: User record found. Username: {$user['username']}</p>";
            echo "<p>Debug: Stored hashed password: {$user['password']}</p>";
        } else {
            echo "<p>Debug: No user found with the username: $username</p>";
        }

        // Debug: Verifying the password hash
        $passVerify = password_verify($password, $user['password']);
        echo "<p>Debug: pass_verify result: $passVerify </p>";

        // Verify the password
        if ($user && $passVerify) {
            // Debug: Password verification success
            echo "<p>Debug: Password verified successfully.</p>";

            // Password is correct; set session and redirect
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            // Debug: Password verification failed
            echo "<p>Debug: Invalid username or password.</p>";
            $message = 'Invalid username or password.';
        }
    } catch (PDOException $e) {
        // Debug: Database error
        echo "<p>Debug: Database error: " . $e->getMessage() . "</p>";

        // Log error and display a generic message
        error_log('Database Error: ' . $e->getMessage());
        $message = 'An error occurred. Please try again later.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
