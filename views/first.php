<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-image: url('images/welcome.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        #rules {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: -150px; /* Ajustement pour centrer le formulaire */
        }

        h2 {
            color: #333333;
        }

        #welcome-message {
            margin-top: 20px;
            color: #45a049;
        }

        #boutons {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
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
    </style>
</head>
<body>

<div id="rules">
    <h2>Regles du Jeu</h2>
    <div id='boutons'>
        <a href="/welcome" class="next-button">Suite</a>
        <a href="/rules" class="back-button">Voir les regles</a>
    </div>
</div>


</body>
</html>
