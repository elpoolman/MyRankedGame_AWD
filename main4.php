
<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: main3.php");
    exit;
}

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

// Obtener lista de juegos para los selectores
$stmt = $pdo->query("SELECT id, name, picture FROM games");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los datos del usuario logueado
$userId = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT pref_game, highest_rank FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Selector</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .game-frame {
            width: 300px;
            height: 300px;
            background-size: cover;
            background-position: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container text-center">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <h4>Favourite Game</h4>
            <div id="favDisplay" class="game-frame" style="background-image: url('Pictures/<?= $games[$userData['pref_game']]['picture'] ?>');"></div>
            <select id="favGame" class="form-select">
                <option value="">Select a game...</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game['id'] ?>" <?= $game['id'] == $userData['pref_game'] ? 'selected' : '' ?> data-picture="<?= $game['picture'] ?>"><?= $game['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <h4>Best Game</h4>
            <div id="bestDisplay" class="game-frame" style="background-image: url('Pictures/<?= $games[$userData['highest_rank']]['picture'] ?>');"></div>
            <select id="bestGame" class="form-select">
                <option value="">Select a game...</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game['id'] ?>" <?= $game['id'] == $userData['highest_rank'] ? 'selected' : '' ?> data-picture="<?= $game['picture'] ?>"><?= $game['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <button id="updateGameBtn" class="btn btn-success">Update Games</button>
        <a href="main3.php" class="btn btn-info">Return</a>
    </div>
</div>

<script>

    function updateDisplay(selectorId, displayId) {
        const selector = document.getElementById(selectorId);
        const display = document.getElementById(displayId);

        selector.addEventListener('change', () => {
            const selectedOption = selector.selectedOptions[0];
            const imageUrl = selectedOption ? 'Pictures/' + selectedOption.getAttribute('data-picture') : '';

            display.style.backgroundImage = imageUrl ? `url('${imageUrl}')` : '';
        });
    }


    updateDisplay('favGame', 'favDisplay');
    updateDisplay('bestGame', 'bestDisplay');

    document.getElementById('updateGameBtn').addEventListener('click', async function() {
        const favGameId = document.getElementById('favGame').value;
        const bestGameId = document.getElementById('bestGame').value;

        if (favGameId && bestGameId) {
            const response = await fetch('update_games.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    userId: <?= $_SESSION['id'] ?>,
                    prefGameId: favGameId,
                    highestRankId: bestGameId
                })
            });

            const result = await response.json();
            if (result.success) {
                alert('Your game preferences have been updated!');
            } else {
                alert('Error updating preferences');
            }
        } else {
            alert('Please select both games');
        }
    });
</script>
</body>
</html>
