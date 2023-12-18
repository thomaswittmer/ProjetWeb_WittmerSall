<?php
// updateScore.php

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

//Affichage clair de $_POST dans le fichier d'erreur.
error_log(print_r($_POST, true)); 

//Lorsque le joueur trouve le trophée et fini la partie un score lui est attribué
//On l'insère alors dans la bdd grâce à la ligne crée précédemment dans le fichier login.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score']) && isset($_POST['pseudo'])) {
    $score = $_POST['score'];
    $pseudo = $_POST['pseudo'];

    try {
        $stmt = $pdo->prepare('UPDATE player SET score = :score WHERE pseudo = :pseudo');
        $stmt->execute(['score' => $score, 'pseudo' => $pseudo]);

        echo 'Score mis à jour avec succès!';
    } catch (PDOException $e) {
        // Inscription de l'erreur dans le fichier.
        error_log('PDOException: ' . $e->getMessage());
        http_response_code(500); 
        echo 'Erreur lors de la mise à jour du score.';
    }
} else {
    http_response_code(400);  // On  intercepte une potentiel erreur non liée à la bdd.
    echo 'Erreur lors de la mise à jour du score.';
}
?>
