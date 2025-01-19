<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Animcal Clciker</title>
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #333;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .button {
            padding: 15px 30px;
            font-size: 1.2em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.8em;
            }

            .button {
                width: 80%;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Welcome to Animal Clicker!</h1>

    <div class="button-container">
        <a href="login.php" class="button">Login</a>
        <a href="register.php" class="button">Registration</a>
    </div>
</body>
</html>
