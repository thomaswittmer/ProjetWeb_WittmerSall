<?php
// db.php
/* 
// Ce fut un fichier de test pour la connexion à la base de données. On désirait un fichier de connexion unique
// pour l'ensemble des fichiers php. On a finalement opté pour une connexion dans chaque fichier php. Cela est plus 
// élégant, évite tous surplus de connexion et permet plus de sécurité.
*/
$host = 'localhost';
$dbname = 'projetWeb';
$user = 'postgres';
$password = 'Thomas 66430';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}


?>