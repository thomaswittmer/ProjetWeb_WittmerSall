<?php

// db.php
$host = 'localhost';
$dbname = 'projetWeb';
$user = 'postgres';
$password = 'Thomas 66430';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

if (isset($pdo)) {
    // Fetch top players
    $stmt = $pdo->query('SELECT pseudo, score FROM player ORDER BY score DESC LIMIT 10');

    if ($stmt) {
        $topPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Erreur lors de l'exécution de la requête SQL.");
    }

    // Fetch user data
    $sqlUser = "SELECT score FROM player WHERE pseudo = :pseudo";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
    $stmtUser->execute();

    $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);


    // Récupération du score de l'utilisateur
    $userScore = $userData['score'];

    // Calculate user rank manually
    $userRank = 1;
    foreach ($topPlayers as $player) {
        if ($userScore > $player['score']) {
            $userRank++;
        } else {
            break;
        }
    }

} else {
    die("Erreur: La connexion à la base de données n'est pas établie.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logoF1.png">
    <title>Fin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0 auto; /* Set margin to 0 and auto to center the body horizontally */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 170vh;
            max-width: 100%;
        }

        .podium-container {
            order:0;
            background-image: url('images/podium.jpeg');
            background-size: cover;
            background-position: center;
            height: 90vh;
            width: 100%;
            overflow: hidden; /* Empêche le défilement de cette section */
        }

        #top10-container {
            order: 1;
            background-color: rgba(255, 255, 255, 1);
            padding: 60px;
            height: 80vh; /* La hauteur totale moins la hauteur de la première section */
            width: 100%;
            text-align: center;
            overflow-y: auto;
            
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="podium-container"></div>
    
    <div id="top10-container">
        <h2>Top 10 Joueurs</h2>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Pseudo</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topPlayers as $index => $player): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $player['pseudo'] ?></td>
                        <td><?= $player['score'] ?> points</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
        <h3>Pseudo : <?php echo $_SESSION['pseudo']; ?></h3>
        <h3>Score : <?php echo $userScore; ?> points</h3>

    </div>
</body>
</html>
