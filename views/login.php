<?php
// login.php

//Connexion à la bdd.
$host = 'localhost';
$dbname = 'projetWeb';
$user = 'postgres';
$password = 'Thomas 66430';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// On initialise les fichiers d'erreurs (très utiles)
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le pseudo depuis le formulaire
    $nickname = $_POST['nickname'];

    // Vérifier si le joueur existe déjà, on ne peut ici pas créer de doublon. 
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM player WHERE pseudo = :pseudo');
    if (!$stmt) {
        error_log('Error preparing SELECT query: ' . print_r($pdo->errorInfo(), true));
        die('Error preparing SELECT query');
    }
    $stmt->execute(['pseudo' => $nickname]);
    if (!$stmt) {
        error_log('Error executing SELECT query: ' . print_r($stmt->errorInfo(), true));
        die('Error executing SELECT query');
    }

    $count = $stmt->fetchColumn();


    if ($count == 0) {
        // Ajouter un nouveau joueur avec un score de 0
        $stmt = $pdo->prepare('INSERT INTO player (pseudo, score) VALUES (:pseudo, 0)');
        if (!$stmt) {
            error_log('Error preparing INSERT query: ' . print_r($pdo->errorInfo(), true));
            die('Error preparing INSERT query');
        }

        $stmt->execute(['pseudo' => $nickname]);
        if (!$stmt) {
            error_log('Error executing INSERT query: ' . print_r($stmt->errorInfo(), true));
            die('Error executing INSERT query');
        }

        echo 'Bienvenue ' . $nickname . ' !';
        // Ajoute le pseudo à la session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['pseudo'] = $nickname;
    }
}
?>
