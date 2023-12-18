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

// Récupérer la liste des pilotes
$sql = "SELECT * FROM drivers";
$resultPilotes = $pdo->query($sql);

// Vérifier si l'ID du pilote existe dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID du pilote à partir de l'URL
    $piloteId = $_GET['id'];

    // Requête pour obtenir les détails du pilote
    $sql = "SELECT * FROM drivers WHERE id = $piloteId";
    $result = $pdo->query($sql);

    // Vérifier si le pilote a été trouvé
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $piloteNom = $row['nom'];
        $pilotePhoto = $row['photo'];
        $piloteTeam = $row['team'];
        $piloteNum = $row['num'];
        $piloteVideo = $row['video'];
    } else {
        // Le pilote n'a pas été trouvé
        echo "Pilote non trouvé.";
    }

    // Fermer la connexion à la base de données après avoir terminé les opérations
    $pdo = null;
} else {
    // L'ID du pilote n'est pas présent dans l'URL
    echo "ID du pilote non spécifié.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logoF1.png">
    <title>Pilote</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background-color: #282c35;
            color: white;
            margin: 0;
        }

        #driver-info-container {
            background-color: #ecf0f1; /* Couleur de fond pour les informations du pilote */
            color: #333333; /* Couleur du texte pour les informations du pilote */
            padding: 20px;
            border-radius: 8px;
        }

        #infos {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            color: #black;
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
        }

        .back-button, .next-button {
            display: inline-block;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
            color: white;
            width: 150px;
        }

        .back-button {
            background-color: #e74c3c;
            border: 2px solid #c0392b;
            margin-right: 10px;
        }

        .next-button {
            background-color: #2ecc71;
            border: 2px solid #27ae60;
        }

        .back-button:hover, .next-button:hover {
            opacity: 0.8;
        }

        #infos, #boutons {
            margin-bottom: 20px;
        }

        #boutons {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        #infos video {
            width: 100%;
            height: 300px; /* Nouvelle taille de la vidéo */
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div id="driver-info-container">
    <div id="infos">
        <?php
        if (isset($piloteNom) && isset($pilotePhoto)) {
            // Afficher le nom du pilote
            echo "<h2>$piloteNom</h2>";
            // Afficher la photo en petite
            echo "<img src='$pilotePhoto' alt='Photo du pilote'>";
            echo "<h3>$piloteTeam</h3><h3>$piloteNum</h3>";
            
            // Embed the video using an iframe
            echo "<iframe width='59%' height='200px' src='$piloteVideo' frameborder='0' allowfullscreen></iframe>";
        } else {
            // Le pilote n'a pas été trouvé.
            echo "Pilote non trouvé.";
        }
        ?>
    </div>
    <div id='boutons'>
        <a href="/driver" class="back-button">Retour</a>
        <a href="/game" class="next-button">Confirmer</a>
    </div>
</div>




</body>
</html>
