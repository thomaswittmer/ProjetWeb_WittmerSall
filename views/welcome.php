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

// Vous pouvez également définir cette variable en dehors du bloc try-catch
$topPlayers = [];

if (isset($pdo)) {
    $stmt = $pdo->query('SELECT pseudo, score FROM player ORDER BY score DESC LIMIT 10');

    if ($stmt) {
        $topPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Erreur lors de l'exécution de la requête SQL.");
    }

    // Fermez la connexion à la base de données après avoir récupéré les données nécessaires
    $pdo = null;
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
    <title>Login</title>
    <style>
          body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            margin: 0;
            background-image: url('images/welcome.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .together{
            display : flex;
            justify-content : space-around;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 300px; /* Ajustez la largeur selon vos besoins */
        }

        h2 {
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555555;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .buttons {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        button {
            padding: 12px;
            cursor: pointer;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        #welcome-message {
            margin-top: 20px;
            color: #45a049;
            font-weight: bold;
        }

        .back-button {
            display: inline-block;
            background-color: #e74c3c;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            border: 2px solid #c0392b;            
            padding: 10px 20px;
            border-radius: 4px;
            bottom: 10px;
            left: 90%;
            transition: background-color 0.3s, color 0.3s;
        }


        #top10-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Ajustez la largeur selon vos besoins */
        }

        #top10 h2 {
            color: #333333;
            margin-bottom: 10px;
        }

        #top10 ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #top10 li {
            margin-bottom: 8px;
            color: #555555;
        }

        #top-players-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s;
        }

        #top-players-link:hover {
            color: #45a049;
        }

        #top10-container table td {
            padding-right: 20px; /* Ajuste selon tes besoins */
        }
    </style>
</head>
<body>


<div id="together">
    <div class="container" id="login-container">
        <h2>Escape Game Formule 1</h2>
        <form id="login-form" action="login" method="post">
            <label for="nickname-input">Entrez un pseudo :</label>
            <input type="text" id="nickname-input" name="nickname" placeholder="Your nickname">
            <br>
            <div id = buttons>
                <button type="submit">Valider</button>    
                <a href="/driver" class="back-button">Suite</a>
            </div>
            
        </form>

        <p id="welcome-message"></p>
        
    </div>

    <div class="container" id="top10-container">
        <h2>Top 10 Joueurs</h2>
        <table>
            <tbody>
                <?php foreach ($topPlayers as $index => $player): ?>
                    <tr>
                        <td><?= $player['pseudo'] ?></td>
                        <td><?= $player['score']." points" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>




</div>




<script>
    let currentPlayer = ''; // Variable pour stocker le pseudo du joueur
    document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche l'envoi du formulaire par défaut

    const nickname = document.getElementById('nickname-input').value;

    // Créez un objet FormData pour envoyer les données du formulaire
    const formData = new FormData();
    formData.append('nickname', nickname);

    // Envoi du pseudo à login.php
    fetch('/login', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        // Mettez à jour le message de bienvenue ou gérez les erreurs
        document.getElementById('welcome-message').textContent = data;

        // Si l'inscription est réussie, mettez à jour la variable currentPlayer
        if (data.includes('Bienvenue')) {
            currentPlayer = nickname;
        }
    });
});
</script>

       

        

</body>
</html>
