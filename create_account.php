<?php
require_once 'json_creator.php';
require_once 'drive.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $host = "localhost";
    $dbname = "gamming_01";
    $user = "pooladmin";
    $pass = "123456";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }

    $username  = htmlspecialchars(trim($_POST["username"] ?? ""));
    $email     = htmlspecialchars(trim($_POST["email"] ?? ""));
    $password  = trim($_POST["password"] ?? "");
    $birthdate = $_POST["birthdate"] ?? "";

    if (empty($username) || empty($email) || empty($password) || empty($birthdate)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email.");
    }

    if (!strtotime($birthdate) || strtotime($birthdate) > time()) {
        die("Invalid birthdate.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $defaultGameId = 4;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, birthdate, pref_game, highest_rank) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $birthdate, $defaultGameId, $defaultGameId]);

        echo "<h2>Account created successfully</h2>";
        echo "<p><strong>Username:</strong> $username</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Birthdate:</strong> $birthdate</p>";

        // Create JSON and upload to Drive
        $jsonFile = createUserJson($username, $email, $birthdate);
        $fileId = uploadFileToDrive($jsonFile);

        echo "<p>JSON uploaded to Google Drive (File ID: $fileId)</p>";

        // Send welcome email
        require 'gmailsend.php';
        sendWelcomeEmail($email, $username);

    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            echo "An account with this email or username already exists.";
        } else {
            echo "Error saving data: " . $e->getMessage();
        }
    }

} else {
    echo "Access denied.";
}
?>
