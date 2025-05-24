<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);


    $userId = $data['userId'];
    $prefGameId = $data['prefGameId']; 
    $highestRankId = $data['highestRankId']; 


    if (!is_numeric($userId) || !is_numeric($prefGameId) || !is_numeric($highestRankId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }


    $host = "localhost";
    $dbname = "gamming_01";
    $user = "pooladmin";
    $pass = "123456";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $pdo->prepare("UPDATE users SET pref_game = ?, highest_rank = ? WHERE id = ?");
        $stmt->execute([$prefGameId, $highestRankId, $userId]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
