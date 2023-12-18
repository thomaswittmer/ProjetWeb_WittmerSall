<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regles</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 80%;
            margin: 0;
            background-image: url('images/welcome.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        #regles {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
            text-align: center;
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

<div id="regles">
    <h2>Règles du Jeu</h2>
    <ul>
        <li>Une page d'accueil se présente à vous. Vous devez alors indiquer votre pseudo, cliquer sur Valider, puis sur Suite. Ensuite, sélectionnez le pilote de votre choix.</li>
        <br>
        <li>Vous arrivez premièrement à l'aéroport de CDG pour prendre votre jet privé. Pour cela, vous devrez trouver votre billet d'avion au Terminal 1 (indice dans le popup du jet privé). Une fois le billet récupéré, cliquez sur votre avion qui, à l'aide d'une animation de décollage et d'atterrissage, vous mènera à l'aéroport de Londres Stansted. Là, un véhicule VIP vous attend sur le parking. Cliquez dessus pour vous rendre au circuit de Silverstone.</li>
        <br>
        <li>Vous êtes désormais arrivé au circuit de Silverstone. La première étape consiste à vous rendre dans le paddock, mais celui-ci est bloqué par un code. Ce dernier est dans votre chambre d'hôtel au Silverstone Golf Resort, au Nord-Est du circuit. Mais, il vous faut la clef de la chambre pour l'ouvrir, et celle-ci se trouve à côté de la voiture VIP. Récupérez-la, puis rendez-vous à nouveau à l'hôtel où votre chambre s'ouvre et laisse découvrir le code d'accès au paddock. Retournez au paddock et entrez ce code (2008).</li>
        <br>
        <li>À présent, votre voiture apparaît et indique qu'il vous manque les pneus. Elle vous redirige vers la conférence de presse qui vous indiquera le type de pneus à utiliser pour la course (les pneus Medium, c'est-à-dire les pneus jaunes). On vous indique où les trouver (au Nord-Ouest, à l'entrepôt du constructeur : Pirelli).</li>
        <br>
        <li>Dans l'entrepôt, sélectionnez un train de pneus. Un malus est attribué si vous ne prenez pas les pneus indiqués en conférence de presse. Revenez à la voiture en ayant le train de pneus Medium dans l'inventaire.</li>
        <br>
        <li>Vous avez désormais les bons pneus et la victoire est assurée. Le trophée apparaît et sa récupération marque la fin du jeu.</li>
    </ul>
    <div id='boutons'>
        <a href="/" class="back-button">Retour</a>
    </div>
</div>



</body>
</html>
