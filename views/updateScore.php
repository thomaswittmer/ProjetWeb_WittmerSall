<?php
// updateScore.php
$host = 'localhost';
$dbname = 'projetWeb';
$user = 'postgres';
$password = 'Thomas 66430';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

error_log(print_r($_POST, true));  // Log received POST data

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['score']) && isset($_POST['pseudo'])) {
    $score = $_POST['score'];
    $pseudo = $_POST['pseudo'];

    try {
        $stmt = $pdo->prepare('UPDATE player SET score = :score WHERE pseudo = :pseudo');
        $stmt->execute(['score' => $score, 'pseudo' => $pseudo]);

        echo 'Score mis à jour avec succès!';
    } catch (PDOException $e) {
        // Log or handle the exception
        error_log('PDOException: ' . $e->getMessage());
        http_response_code(500);  // Internal Server Error
        echo 'Erreur lors de la mise à jour du score.';
    }
} else {
    http_response_code(400);  // Bad Request
    echo 'Erreur lors de la mise à jour du score.';
}
?>
