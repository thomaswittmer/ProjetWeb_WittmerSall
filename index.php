<?php

session_start();

require 'flight/Flight.php';

Flight::route('/', function(){
    Flight::render('first');
});

Flight::route('/welcome', function(){
    Flight::render('welcome');
});

Flight::route('/rules', function(){
    Flight::render('rules');
});

Flight::route('/driver', function(){
    Flight::render('driver');
});

Flight::route('/selected-driver', function(){
    Flight::render('selected-driver'); 
});

Flight::route('/login', function(){
    Flight::render('login'); 
});

Flight::route('/updateScore', function(){
    Flight::render('updateScore'); 
});

Flight::route('/db', function(){
    Flight::render('db'); 
});

Flight::route('/game', function(){
    Flight::render('game'); 
});

Flight::route('/end', function(){
    Flight::render('end'); 
});

require_once 'views/db.php';

Flight::route('GET /api/drivers', function () use ($pdo) {
    try {
        // Execute SQL query to retrieve all information about drivers
        $query = $pdo->prepare('SELECT * FROM drivers');
        $query->execute();
        $drivers = $query->fetchAll(PDO::FETCH_ASSOC);

        // Create an array to store drivers info
        $driversInfos = [];

        foreach ($drivers as $driver) {
            $driverInfo = [
                'id' => $driver['id'],
                'nom' => $driver['nom'],
                'num' => $driver['num'],
                'photo' => $driver['photo'],
                'video' => $driver['video'],
                'team' => $driver['team'],
            ];

            $driversInfos[] = $driverInfo;
        }

        // Return JSON response with drivers information
        Flight::json(['success' => true, 'driversInfos' => $driversInfos]);
    } catch (PDOException $e) {
        // Handle database errors
        Flight::json(['success' => false, 'message' => $e->getMessage()]);
    }
});

Flight::route('GET /api/marker', function () use ($pdo) {
    try {
        // Execute SQL query to retrieve all information about objects
        $query = $pdo->prepare('SELECT id, nom, ST_AsGeoJSON(coords) AS coords, icon, ix, iy FROM objets as o');

        $query->execute();
        $objects = $query->fetchAll(PDO::FETCH_ASSOC);

        // Create an array to store markers
        $markers = [];

        // Iterate through objects and add them to the markers array
        foreach ($objects as $object) {
            $marker = [
                'id' => $object['id'],
                'nom' => $object['nom'],
                'coords' => $object['coords'],
                'icon' => $object['icon'],
                'ix' => $object['ix'],
                'iy' => $object['iy'],
            ];
            $markers[] = $marker;
        }

        // Return JSON response with markers
        Flight::json(['success' => true, 'markers' => $markers]);
    } catch (PDOException $e) {
        // Handle database errors
        Flight::json(['success' => false, 'message' => $e->getMessage()]);
    }
});


Flight::route('GET /end', function () {
    // Render your end.php page or perform any other actions
    Flight::render('end');
});


Flight::start();
?>