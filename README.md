
# Escape-Game Géographique
  Dans le cadre de notre deuxième année au sein de l'ENSG, nous vous proposons
  ici la création d'une page web interactive basée sur le principe de l'escape-game.
  
  ## Thème Choisi
  Nous avons choisi le thème de la Formule 1 pour ce projet, vous devrez donc réaliser une série d'actions pour remporter le Grand-Prix de Silverstone et ce, le plus rapidement possible et en évitant les malus !

  ## Installations Requises 
  - Version de **Java**: jdk-11.0.20
  - Version de **Geoserver**: 2.24.0
  - Serveur **Apache** avec PHP: 8.2.0
  - Version de **PostgreSQL**: 14.0

  ## Ports Utilisés
  - **PostgreSQL :** 5432
  - **MAMP :** 8888
  - **Geoserver :** 8080

  ## Déroulement du jeu 
- Une page d'acceuil se présente à vous. Vous devez alors indiquer votre pseudo cliquer sur Valider puis sur Suite. Ensuite, sélectionnez le pilote de votre choix.
- Vous arrivez premièrement à l'aéroport de CDG pour prendre votre jet privé. Pour cela vous devrez trouver
votre billet d'avion au Terminal 1 (indice dans le popup du jet privé). Une fois le billet récupéré, cliquez sur votre avion qui, à l'aide d'une animation de décollage et d'aterrissage, vous mènera à l'aéroport de Londres Stansted. Là, un véhicule VIP vous attend sur le parking. Cliquez dessus pour vous rendre au circuit de Silverstone.
- Vous êtes désormais arrivé au circuit de Silverstone. La première étape consiste à vous rendre dans le paddock mais celui-ci est bloqué par un code. Ce dernier est dans votre chambre d'hôtel au Silverstone Golf Resort, au Nord-Est du circuit. Mais, il vous faut la clef de la chambre pour l'ouvrir et celle-ci se trouve à côté de la voiture VIP. Récupérez-là puis rendez-vous à nouveau à l'hôtel où votre chambre s'ouvre et laisse découvrir le code d'accès au paddock. Retournez au paddock et entrez ce code (2008).
- A présent, votre voiture apparaît et indique qu'il vous manque les pneus. Elle vous redirige vers la conférence de presse qui vous indiquera le type de pneus à utiliser pour la course (les pneus Medium, ie les pneus jaunes). On vous indique où les trouver (au Nord-Ouest, à l'entrepôt du constructeur : Pirelli).
- Dans l'entrepôt, selectionnez un train de pneus. Un malus est attribué si vous ne prenez pas les pneus indiqués en conférence de presse. Revenez à la voiture en ayant le train de pneus Medium dans l'inventaire.
- Vous avez désormais les bons pneus et la victoire est assurée. Le trophée apparaît et sa récupération marque la fin du jeu.

## Informations Pratiques
- En haut à droite de la carte, se trouve le bouton pour le mode triche.
- En bas à droite de la carte, se trouve le bouton pour terminer le jeu. Ne cliquer dessus qu'à la fin du jeu, lorsque l'alerte indique votre score.


## Problèmes Eventuels
- Si certaines videos des pilotes ne se chargent pas, c'est normal car par souci d'espace de stockage, uniquement les videos de Charles Leclerc et Lewis Hamilton sont dans le dossier. Choisir l'un de ces deux pilotes est donc préférable pour l'expérience utilisateur.
- Si une erreur similaire à "Trop de connexions à la base de données" survient, fermer PgAdmin.

