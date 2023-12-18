<?php
// db.php
// Connexion à la base de données
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
$sql = "SELECT id, nom FROM drivers";
$resultPilotes = $pdo->query($sql);

// Fermer la connexion à la base de données après avoir récupéré la liste des pilotes
$pdo = null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logoF1.png">
    <title>Choose Your Driver</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('images/allDrivers.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
        }

        #driver-selection-container {
            text-align: center;
            background-color: #ffffff;
            padding-left: 45px;
            padding: 20px;
            width: 326px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: -130px;
        }

        h2 {
            color: #333333;
        }

        video {
            width: 95%;
        }

        #driver-dropdown {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .back-button {
            display: inline-block;
            text-decoration: none;
            color: #333;
            border: 1px solid #333;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .back-button:hover {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>


<div id="driver-selection-container">
    <h2>Choisissez un pilote</h2>
    <label for="driver-dropdown">Sélectionnez un pilote</label>
    <form action="/selected-driver" method="get">
        <select id="driver-dropdown" name="id">
            <?php
            // Afficher la liste des pilotes, sous forme de menu déroulant
            while ($row = $resultPilotes->fetch(PDO::FETCH_ASSOC)) {
                $piloteId = $row['id'];
                $piloteNom = $row['nom'];
                echo "<option value='$piloteId'>$piloteNom</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Voir les détails du pilote">
    </form>
    <video width="300" height=auto controls>
        <source src="images/pilots.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge la balise vidéo.
    </video>
</div>
</div>

</body>
</html>
