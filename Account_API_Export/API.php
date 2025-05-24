<?php
// ============================================
// USER REGISTRATION API
// ============================================
// This single-file API receives POST data, validates it,
// inserts a new user into the database, and creates a local JSON file.
// No email or external cloud storage integration included.
// ============================================

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Access denied. Only POST requests are allowed."]);
    exit;
}

// ========== [Insert database connection here] ==========
// Replace these credentials with your actual database connection
$host = "localhost"; //Host-name, example: 127.0.0.1
$dbname = "";   //Name of Database
$user = "your_user";    //User of the Database, (Grant option)
$pass = "your_password";    //Strong Passwd

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection error."]);
    exit;
}
// ============================================
// ============================================
// Sanitize and get POST input

$username  = htmlspecialchars(trim($_POST["username"] ?? ""));
$email     = htmlspecialchars(trim($_POST["email"] ?? ""));
$password  = trim($_POST["password"] ?? "");
$birthdate = $_POST["birthdate"] ?? "";

// Validate required fields
if (empty($username) || empty($email) || empty($password) || empty($birthdate)) {
    echo json_encode(["error" => "All fields are required."]);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email address."]);
    exit;
}

// Validate birthdate (must be a past date)
if (!strtotime($birthdate) || strtotime($birthdate) > time()) {
    echo json_encode(["error" => "Invalid birthdate."]);
    exit;
}

// Optional: enforce basic password strength
// =======[Strong Password]=========================
/*
if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
    echo json_encode([
        "error" => "Password must be at least 8 characters, include a number and an uppercase letter."
    ]);
    exit;
}
*/
// Hash password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$defaultGameId = 4; // Default game preference

try {
    // Insert user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, birthdate, pref_game, highest_rank) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword, $birthdate, $defaultGameId, $defaultGameId]);

    // Generate a JSON file with user info
    $jsonFilePath = createUserJson($username, $email, $birthdate);

    // Send JSON response
    echo json_encode([
        "status" => "success",
        "message" => "Account created successfully.",
        "username" => $username,
        "email" => $email,
        "birthdate" => $birthdate,
        "json_file" => basename($jsonFilePath)
    ]);

} catch (PDOException $e) {
    // Duplicate user/email handling
    if ($e->errorInfo[1] === 1062) {
        echo json_encode(["error" => "An account with this email or username already exists."]);
    } else {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

// ============================================
// Creates a JSON file with user data and returns the file path.
// ============================================
function createUserJson($username, $email, $birthdate) {
    $folderPath = __DIR__ . "/new_json";

    // Create directory if it doesn't exist
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Sanitize username for safe filename
    $safeUsername = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $username);
    $timestamp = date("Ymd_His");
    $filename = "new_ac_" . $safeUsername . "_" . $timestamp . ".json";
    $filePath = $folderPath . "/" . $filename;

    // Create JSON structure
    $data = [
        "username" => $username,
        "email" => $email,
        "birthdate" => $birthdate,
        "created_at" => date("Y-m-d H:i:s")
    ];

    // Write to JSON file
    if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT)) === false) {
        throw new RuntimeException("Failed to write JSON file: $filePath");
    }

    // Optional: restrict file permissions
    chmod($filePath, 0600);

    return $filePath;
}
?>
