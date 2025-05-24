<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($username === "" || $password === "") {
        header("Location: main2.php?error=empty_fields");
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, username, email, password, birthdate, created_at, pref_game, highest_rank 
                           FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData || !password_verify($password, $userData['password'])) {
        header("Location: main2.php?error=invalid_credentials");
        exit;
    }


    $_SESSION['id'] = $userData['id'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['pref_game'] = $userData['pref_game']; 
    $_SESSION['highest_rank'] = $userData['highest_rank']; 

    header("Location: main4.php");
    exit;
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
