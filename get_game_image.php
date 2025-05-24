<?php
if (isset($_GET['id'])) {
    $gameId = (int) $_GET['id'];

    $host = "localhost";
    $dbname = "gamming_01";
    $user = "pooladmin";
    $pass = "123456";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT picture FROM games WHERE id = ?");
        $stmt->execute([$gameId]);
        $game = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($game) {
            echo json_encode($game);
        } else {
            echo json_encode(['error' => 'Game not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
