<?php
include 'db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    try {
        // Query database for the user by username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Check if user data was fetched
        if ($user) {
        } else {
            echo "<p>Debug: No user found with the username: $username</p>";
        }

        // Debug: Verifying the password hash
        $passVerify = password_verify($password, $user['password']);
        // Verify the password
        if ($user && $passVerify) {
            // Password is correct; set session and redirect
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            $message = 'Invalid username or password.';
        }
    } catch (PDOException $e) {
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
