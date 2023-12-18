const myMap = L.map('map').setView([49.007643, 2.549616], 12);
//Code javaScript pour la gestion de l'interaction entre l'utilisateur et nos objets présents sur la carte Leaflet.

//On initialise la carte Leaflet au niveau de CDG.
const mapp = new Vue({
    data() {
        return {
            //On initialise toute les variables, essentiellements des booléens pour la gestion de l'avancement 
            //dans le jeu.
            featureG: L.featureGroup(),
            hasBilletAvion: false,
            inventoryList: [],
            accessCodeInput: '',

            //Conteneurs pour les objets de l'inventaire
            tempsEcoule: 0,
            isZeroSecond: false,

            //On initialise un chronomètre lorsque le joueur arrive sur la map. Les événements se passant avant 
            //ne comptent pas pour le score
            currentPlayer: currentPlayer,
            startTime: new Date(),
            score:0,

            map: myMap,

            markers: {},

            isBilletAvionClicked: false,
            isPlaneTaken: false,
            isPaddockClicked: false,
            isHardTyreClicked: false,
            isMediumTyreClicked: false,
            isSoftTyreClicked: false,
            isKeyClicked: false,
            isPressClicked: false,
            isTrophyClicked: false,
            isF1Clicked: false,
            isPaddockOpened: false,
            isHotelOpened: false,
            isF1Ready: false,
            billetAvionMarker: null,
            privateJetMarker: null,
            hardTyreMarker: null,
            mediumTyreMarker: null,
            softTyreMarker: null,
            carVipMarker: null,
            carVipMarker2: null,
            silverstoneMarker: null,
            trophyMarker: null,
            hotelMarker: null,
            keyHotelMarker: null,
            paddockMarker: null,
            pressMarker: null,
            passwordMarker: null,
            pirelliMarker: null,
            isAnimationOver: null,

            selectedItem: null,

            planeMarker: null,
            planeMarker2: null,
            planePath: null,
            planePath2:null,
            centerCoordinates1: [49.007643, 2.549616],
            centerCoordinates2: [51.88341279546903, 0.2527398636636726],

            tileLayer1: null,
            tileLayer2: null,
            mywms: null

        };
    },
    mounted() {
        this.updateChronometre();
    
        this.map = L.map('map').setView([49.007643, 2.549616], 12);

         //Tuiles de la carte avec le niveau de zoom le plus faible. Vue satellite ESRI.
        this.tileLayer1 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(this.map);

        //Tuiles de la carte la plus détaillée. Données OpenStreetMap.
        this.tileLayer2 = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 28,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });
        
        //Création de la varibale contenant la couche WMS du géoserver pour la heatmap.
        this.mywms = L.tileLayer.wms("http://localhost:8080/geoserver/Formule1/wms", {
            layers: 'Formule1:objets',
            format: 'image/png',
            transparent: true,
            version: '1.1.0',
            attribution: "Heatmap Layer"
        });


        
        
        //Nous ajoutons les deux couches de tuiles à la carte en fonction du niveau de zoom.
        this.map.whenReady(() => {
            this.map.on('zoomend', () => {
                if (this.map.getZoom() >= 18) {
                    this.map.removeLayer(this.tileLayer1);
                    this.map.addLayer(this.tileLayer2);
                } else {
                    this.map.removeLayer(this.tileLayer2);
                    this.map.addLayer(this.tileLayer1);
                }
            });
        });


        this.initializeMap();

        //On crée un control pour la heatmap. 
        var HeatmapControl = L.Control.extend({
            //On crée un bouton qui permet d'activer ou de désactiver la heatmap.
            options: {
                position: 'topright'
            },
        
            initialize: function (mywms) {
                this.mywms = mywms;
            },
        
            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'heatmap-control');
                var button = L.DomUtil.create('button', '', container);
                button.textContent = 'Heatmap';
            
                L.DomEvent.on(button, 'click', () => {
                    if (this.mywms && map) {
                        if (map.hasLayer(this.mywms)) {
                            map.removeLayer(this.mywms);
                        } else {
                            this.mywms.addTo(map);
                            console.log("heatmap added");
                        }
                    } else {
                        console.error("La carte ou la couche WMS n'est pas correctement définie.");
                    }
                });
            
                return container;
            }
            
            
        });

        //On ajoute le control à la carte.
        var heatmapControl = new HeatmapControl(this.mywms);
        this.map.addControl(heatmapControl);
    },
    
    //On crée un fonction pour accéder aux minutes et secondes du chronomètre, ainsi que leurs convertions en chaîne de caractères.
    computed: {
        formattedTime() {
            const minutes = Math.floor(this.tempsEcoule / 60);
            const seconds = this.tempsEcoule % 60;

            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');

            return `${formattedMinutes}:${formattedSeconds}`;
        }
    },

    methods: {
        initializeMap() {
            
            try {
              this.map.whenReady(() => {
                console.log('Map is ready!');
                
                
                if (this.map) {

                    //Initialisation de la map ainsi que de la featureGroup qui contiendra les marqueurs ou tout autre attribut de la carte
                    console.log('Map is ope!');
                    this.map.on('zoomend', async () => {
                    console.log('Zoom level:', this.map.getZoom());
                    const currentZoom = this.map.getZoom();
                    this.featureG.addTo(this.map);
                    this.featureG.clearLayers();
                    
                  
                    
                    try {
                        //Initialisation de la requête API pour récupérer les marqueurs de la base de données.
                        const response = await fetch('/api/marker');
                        const data = await response.json();
                      
                
                      // On regarde si la requête a été un succès
                      if (data.success) {
                        const markers = data.markers;
                
                        markers.forEach(markerInfo => {                                    
                            const { id, nom, coords, popup, icon, ix, iy } = markerInfo;
                            console.log(`Marker: ${nom}, ix: ${ix}, iy: ${iy}`);

                            //On récupère les coordonnées des marqueurs dans un format objet pour pouvoir les exploiter.
                            const [lng, lat] = JSON.parse(coords).coordinates;

                            

                          // Ajouter les conditions pour chaque niveau de zoom
                          if (currentZoom >= 18 && nom === 'billetAvion') {

                            //On ajoute les premiers marqueurs (Le billet et l'avion).
                        
                            this.billetAvionMarker = L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.billetAvionMarker);
                        
                            this.billetAvionMarker.on('click', () => {
                                //Lorsque le billet est cliqué on retire le marqueur et on place le billet dans l'inventaire.
                                //NB: on utilise le même principe pour de nombreux objects par la suite. 

                                this.isBilletAvionClicked = true;
                                this.featureG.removeLayer(this.billetAvionMarker);
                                this.addToInventory({
                                    name: 'Billet Avion',
                                    img: '<img src="images/billetAvion.png" alt="Billet Avion" style="height:40px; width:auto;">',
                                });
                                
                            });
                        }
                        
                        if (this.isBilletAvionClicked) {
                            // Si le billet d'avion a été cliqué, retirer le marqueur
                            this.featureG.removeLayer(this.billetAvionMarker);
                        }
                        
                        if (nom === 'privateJet') {
                            //On ajoute le marqueur du jet privé et on lui ajoute une popup qui présente le lieu. 
                            this.privateJetMarker = L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.privateJetMarker.bindPopup("<center>Bienvenue à l'aéroport de Roissy Charles-De-Gaulle. Vous êtes attendus à l'enregistrement au Terminal 1 pour récupérer votre billet. <img src='images/terminal1.png' style='width: 300px; height: auto;'></img></center>");
                            this.featureG.addLayer(this.privateJetMarker);
                        
                            this.privateJetMarker.on('click', () => {
                        
                                if (this.isBilletAvionClicked) {
                                    // Si le jet est cliqué on lance un animation basé sur une interpolation linéaire entre deux points
                                    //(Le début et la fin de la piste de décollage)
                                    this.isPlaneTaken = true;

                                    if (this.isPlaneTaken){
                                        this.featureG.removeLayer(this.privateJetMarker);
                                    }
                                    this.map.setView(this.centerCoordinates1, 13);
                        
                                    var planeIcon = new L.Icon({
                                        iconUrl: 'images/privateJet.png',
                                        iconSize: [92, 51]
                                    });
                        
                                    this.planeMarker = L.marker([48.995934417764644, 2.556754512248214], { icon: planeIcon }).addTo(this.map);
                                    this.planeMarker2 = L.marker([51.878243831927364, 0.22446811073705714], { icon: planeIcon }).addTo(this.map).bindPopup("<center>" + "Vous venez d'atterir à l'aéroport de Londres Stansted où vous attend un véhicule VIP. Il attend sur le parking.</center>");
                        
                                    this.planePath = [
                                        [48.995934417764644, 2.556754512248214],
                                        [48.998233354591406, 2.5998151977371853]
                                    ];
                                    this.planePath2 = [
                                        [51.878243831927364, 0.22446811073705714],
                                        [51.893350413816414, 0.2472677973644732]
                                    ];
                                    //On lance l'animation
                                    this.startAnimations();
                                }
                        
                            });
                        }
                        if (this.isPlaneTaken) {
                            this.featureG.removeLayer(this.privateJetMarker);
                        }
                        

                          if (currentZoom >= 8 && nom === 'silverstone' ) {
                            //En arrivant à silverstone on ajoute les marqueurs correspondant à la zone (l'hotel, le paddock la voiture VIP et le circuit).
                            this.silverstoneMarker = L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [135, 70] }) });
                            this.silverstoneMarker.bindPopup("<center>" + "Bienvenue à Silverstone, circuit mythique et iconique du Royaume-Uni. Votre chauffeur vous a déposé à l'entrée du circuit. C'est l'heure d'entrer dans le Paddock, vous êtes attendu !</center>");
                            this.featureG.addLayer(this.silverstoneMarker);
                          } 
                          if (this.keyHotelMarker) {
                            this.featureG.removeLayer(this.silverstoneMarker);
                        }

                          if (currentZoom >= 14 && nom === 'paddock') {
                            this.paddockMarker = L.marker([lat,lng], { icon: L.icon({ iconUrl: icon, iconSize: [120, 120] }) });
                            this.featureG.addLayer(this.paddockMarker);
                            
                            this.paddockMarker.on('click', () => {
                                this.isPaddockClicked = true;
                                
                        
                                // Le paddock est pour l'instant bloqué. Il faut entrer le code se touvant à l'hôtel pourt y accéder.
                                const popupContent = `
                                    <h3 id="title">Entrez le code d'accès au Paddock :</h3>
                                    <form id="paddockForm">
                                        <label for="code">Le code d'accès se trouve dans votre chambre d'hôtel au Silverstone Golf Resort.</label>
                                        <input type="text" id="code" name="code" maxlength="4" required>
                                        <br>
                                        <input type="submit" value="Valider">
                                    </form>
                                `;
                        
                                // Ajout du popup
                                this.paddockMarker.bindPopup(popupContent).openPopup();
                        
                                // On ajoute un listener pour les soumissions du code.
                                document.getElementById('paddockForm').addEventListener('submit', (event) => {
                                    event.preventDefault();
                                    const enteredCode = document.getElementById('code').value;
                        
                                    // Si le code est correct.
                                    if (enteredCode === '2008') {
                                        alert('Code correct. Accès au paddock autorisé !');
                                        this.isPaddockOpened = true;
                                    } else {
                                        alert('Code incorrect. Accès au paddock refusé.');
                                    }
                        
                                    // Lorsque le code est entré, on ferme le popup.
                                    this.map.closePopup();
                                });
                            });
                        }
                        if (this.isF1Clicked) {
                            this.featureG.removeLayer(this.paddockMarker);
                        }
                        
                        

                          if (currentZoom >= 14 && nom === 'hotel' && this.isPaddockClicked) {
                            //La chambre de l'hôtel est bloquée également. Il faut récupérer la clef sur le parking.
                            this.hotelMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: "images/hotel.png", iconSize: [ix, iy] }) });
                            this.hotelMarker.bindPopup("<center>La chambre est fermée, il vous faut la clef ! Vous avez du la faire tomber à proximité de votre voiture sur le parking... <img src='images/hotelDoor.webp' style='width:300px; height:auto;'></center>");
                            this.featureG.addLayer(this.hotelMarker);
                            this.hotelMarker.on('click', () => { 
                                if (this.isKeyClicked){
                                    //On ouvre l'hôtel si la clef est selectionnée et on ajoute celle-ci dans l'inventaire. (à la ligne 362) 
                                    this.isHotelOpened = true;
                                    this.featureG.removeLayer(this.hotelMarker);
                                }
                            });
                          } 
                          if (this.isHotelOpened){
                            this.featureG.removeLayer(this.hotelMarker);
                          }

                          if (currentZoom >= 19 && nom === 'hotelKey') {
                            this.keyHotelMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.keyHotelMarker);
                            this.keyHotelMarker.on('click', () => {
                                this.isKeyClicked = true;
                                this.featureG.removeLayer(this.keyHotelMarker);
                                this.addToInventory({
                                    name: 'Clef Hotel',
                                    img: '<img src="images/keyHotel.png" alt="Billet Avion" style="height:40px; width:auto;">',
                                });
                            });
                          } 
                          if (this.isKeyClicked) {
                            //On supprime la clef après l'avoir récupérée.
                            this.featureG.removeLayer(this.keyHotelMarker);
                        }

                          if (currentZoom >= 12 && nom === 'password' && this.isHotelOpened) {
                            //L'accès à l'hôtel procure le code d'accès au paddock.
                            this.passwordMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: "images/password.png", iconSize: [ix, iy] }) });
                            this.passwordMarker.bindPopup("<center>Le code d'accès au paddock est 2008<img src='images/hotelInterieur.jpeg' style='width:300px; height:auto;'></center>");
                            this.featureG.addLayer(this.passwordMarker);
                          } 
                          if (this.isPaddockOpened) {
                            this.featureG.removeLayer(this.passwordMarker);
                        }

                          

                          if (currentZoom >= 14 && nom === 'f1' && this.isPaddockOpened) {
                            //Lors de l'accès au paddock on passe par une conférence de presse proposant les pneus à utiliser lors de la course.
                           
                            this.f1Marker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.f1Marker.bindPopup("<center>Votre voiture est quasiment finalisée. Il ne reste plus qu’à chausser un train de pneus de la spécification recommandée par le constructeur. Rendez-vous en conférence de presse pour le savoir ! <img src='images/pneus.jpeg' width='300px' height='auto'/></center>");
                            this.featureG.addLayer(this.f1Marker);
                            this.f1Marker.on('click', () => {
                                this.isF1Clicked = true;
                                if (this.isMediumTyreClicked){
                                     //Son obtention permet de débloquer le trophée.
                                    this.isF1Ready = true;
                                    this.featureG.removeLayer(pirelliMarker);
                                }
                            });
                          } 
                         

                          if (currentZoom >= 14 && nom === 'press' && this.isF1Clicked) {
                            //Création du marqueur de la conférence de presse ainsi que son pop-up.
                            this.pressMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.pressMarker.bindPopup("<center>Pirelli : \"D'après nos caluls, les pneus Medium (Jaunes) seront les plus efficaces durant cette course.\" Nous rappelons que tous les trains de pneus sont disponibles à l'entrepot Pirelli au Nord-Ouest du circuit. <img src='images/pressConf.jpeg' style='width:300px; height:auto;'></center>");
                            this.featureG.addLayer(this.pressMarker);
                            this.pressMarker.on('click', () => {
                                this.isPressClicked = true;
                            });
                          } 
                          if (this.isMediumTyreClicked) {
                            this.featureG.removeLayer(this.pressMarker);
                        }


                        if (currentZoom <= 18 && nom==='pirelli' && this.isPressClicked) {
                            this.pirelliMarker = L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.pirelliMarker);
                        }

                        //Gestions des marqueurs des pneus, avec un malus si le mauvais pneus est cliqué.
                        if (this.isMediumTyreClicked) {
                            this.featureG.removeLayer(this.pirelliMarker);
                        }
                          


                          if (currentZoom >= 19 && nom === 'hardTyre') {
                            this.hardTyreMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.hardTyreMarker);
                            this.hardTyreMarker.on('click', () => {
                                alert("Dommage, mauvais pneus ! Malus de 300 points")
                                this.isHardTyreClicked = true;
                            });
                          } 
                          if (currentZoom >= 19 && nom === 'mediumTyre' ) {
                            this.mediumTyreMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.mediumTyreMarker);
                            this.mediumTyreMarker.on('click', () => {
                                this.isMediumTyreClicked = true;
                                this.featureG.removeLayer(this.mediumTyreMarker);
                                this.addToInventory({
                                    name: 'Pneu Medium',
                                    img: '<img src="images/mediumTyre.png" alt="Billet Avion" style="height:60px; width:auto;">',
                                });
                            });
                          } 
                          
                          if (currentZoom >= 19 && nom === 'softTyre') {
                            this.softTyreMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.softTyreMarker);
                            this.softTyreMarker.on('click', () => {
                                alert("Dommage, mauvais pneus ! Malus de 300 points")
                                this.softTyreMarker = true;
                            });
                          } 
                    

                         
                          //Gestion du marqueur de la voiture VIP. S'il est cliqué il vous transporte de l'aéroport à Silverstone.
                          if (currentZoom >= 8 && nom === 'carVip' ) {
                            this.carVipMarker= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.carVipMarker);
                            this.carVipMarker.on('click', () => {
                                var centerCoordinates3 = [52.0716145149471, -1.013988566118743];
                                this.map.setView(centerCoordinates3, 15);
                            });

                          }
                          //On ajoute une voiture à l'arrivée au parking de Silverstone pour plus de cohérence. Elle n'a pas de fonction autre que décorative.
                          if (currentZoom >= 11 && nom === 'carVip2') {
                            this.carVipMarker2= L.marker([lat, lng], { icon: L.icon({ iconUrl: icon, iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.carVipMarker2);
                          }  
                          if (this.isPaddockOpened) {
                            this.featureG.removeLayer(this.carVipMarker2);
                        }
                        //Gestion du marqueur du trophée. Il est débloqué lorsque le joueur a récupéré les bons pneus.
                          
                          if (currentZoom >= 9 && nom === 'trophy' && this.isF1Ready) {
                            this.trophyMarker = L.marker([lat, lng], { icon: L.icon({ iconUrl: 'images/trophy.png', iconSize: [ix, iy] }) });
                            this.featureG.addLayer(this.trophyMarker);
                        
                            this.trophyMarker.on('click', () => {
                                this.isTrophyClicked = true;
                                this.featureG.removeLayer(this.trophyMarker);
                                
                                // Ajouter le trophée à l'inventaire
                                this.addToInventory({
                                    name: 'Trophée',
                                    img: '<img src="images/trophy.png" alt="Trophée" style="height:60px; width:auto;">',
                                });
                        
                                this.handleTrophyClick(); // Appelle la fonction qui gère le clic sur le trophée. (Pour la fin du jeu: score et page end.php).
                                
                            });
                        }
                        if (this.isTrophyClicked) {
                            // Si le trophée a été cliqué, retirer le marqueur
                            this.featureG.removeLayer(this.trophyMarker);
                        }
                        
                          
                          


                        });
                      } else {
                        console.error('API request failed:', data.message);
                      }
                    } catch (error) {
                      console.error('Error fetching markers:', error);
                    }
                  });
                }
              });
            } catch (error) {
              console.error('Error initializing map:', error);
            }

        },

        


        handleInventoryClick(event) {
            if (event.target.tagName === 'IMG') {
              event.target.classList.toggle('selected');
            }
          },


       
        updateChronometre() {
            //On met à jour le chrono durant la partie, on l'arrête lorsque le trophée est récupéré.
            const chronometerInterval = setInterval(() => {
                this.tempsEcoule++;
                this.isZeroSecond = this.tempsEcoule % 10 === 0;
                this.$forceUpdate(); // Forcer la mise à jour du DOM
            }, 1000);
    
            document.addEventListener('trophyCollected', () => {
                clearInterval(chronometerInterval);
            });
        },
        
        handleTrophyClick() {
            //Lorsque le trophée est récupéré on calcule un score en fonction du temps passé sur la carte et des possibles malus.
            const trophyCollectedTime = new Date();
            const totalTime = trophyCollectedTime - this.startTime;
            const totalSeconds = totalTime / 1000;
            const scoreBeforeMalus = Math.floor((1 / totalSeconds) * 1000000);
            let score ;

            if(this.isHardTyreClicked){
                score = scoreBeforeMalus - 300;
            }else{
                score= scoreBeforeMalus;
            }
            
            //Une fois le calcul réalisé on ajoute le score à la base de données grâce à une fonction tierce.
            this.updateScoreInDatabase(score, this.currentPlayer);
        
            alert(`Félicitations ! Vous avez trouvé le trophée.\nTemps de jeu : ${totalSeconds} secondes\nVotre score avant les malus : ${scoreBeforeMalus}\nVotre score définitif : ${score}`);
            document.dispatchEvent(new Event('trophyCollected'));
        },
       
        
        
        updateScoreInDatabase(score, currentPlayer) {
            // Utilisation de jQuery pour la requête AJAX
            $.ajax({
                type: 'POST',
                url: 'updateScore',
                data: { score: score, pseudo: currentPlayer },  //On s'assure que le pseudo est le même que celui défini dans le code php.
                contentType: 'application/x-www-form-urlencoded', // On indique au serveur que les données sont encodées par paires (clé/valeur).
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });    
        },

        


        
       
          
        addToInventory(item) {
            // Ajouter l'élément à l'inventaire
            this.inventoryList.push(item);
          },
          
          

          toggleSelectedItem(item) {
            console.log('Toggle selected item called with item:', item);
            
            // Toggle l'élément actuellement sélectionné
            this.selectedItem = (this.selectedItem === item) ? null : item;
            
            console.log('After toggling, this.selectedItem is now:', this.selectedItem);
            // Vérifie si l'élément sélectionné est "mediumTyre"
            if (this.selectedItem && this.selectedItem.name === 'mediumTyre') {
                // Met fin au jeu ici si le (bon) pneu est sélectionné.
                this.map.removeLayer(this.f1Marker);  // Supprime f1Marker de la carte
                console.log("ça marche");
            }
        },
        
        
        
        
        
        
   
          
          
          
          
        
        
    
          







        /**
         * Fonction permettant l'animation de l'avion entre deux points.
         * @param {number} timestamp - Le timestamp actuel.
         * @param {number} startTime - Le timestamp de début de l'animation.
         * @param {number} totalTime - Le temps total de l'animation.
         * @param {Array} path - Le chemin contenant les points de l'animation.
         * @param {Object} marker - Le marqueur de l'avion.
         * @param {Function} resolve - La fonction de résolution de la promesse.
         * @param {Function} onFirstAnimationComplete - La fonction à appeler lorsque la première animation est terminée.
         */
        animate(timestamp, startTime, totalTime, path, marker, resolve, onFirstAnimationComplete) {
            console.log('Animating...', timestamp, startTime, totalTime);
            if (!startTime) startTime = timestamp;
            const elapsedTime = timestamp - startTime;
            const progress = Math.min(elapsedTime / totalTime, 1);
        
            const currentPointIndex = Math.floor(progress * (path.length - 1));
            const nextPointIndex = Math.min(currentPointIndex + 1, path.length - 1);
        
            const lat = path[currentPointIndex][0] + (path[nextPointIndex][0] - path[currentPointIndex][0]) * progress;
            const lng = path[currentPointIndex][1] + (path[nextPointIndex][1] - path[currentPointIndex][1]) * progress;
        
            if (marker && marker.setLatLng) {
                try {
                    marker.setLatLng([lat, lng]);
                } catch (error) {
                    console.error('Error setting efmarker LatLng:', error);
                }
            }
            
        
            if (progress < 1) {
                // L'animation n'est pas terminée, on continue
                requestAnimationFrame((timestamp) => this.animate(timestamp, startTime, totalTime, path, marker, resolve, onFirstAnimationComplete));
            } else {
                if (onFirstAnimationComplete) {
                    onFirstAnimationComplete(); 
                }
                resolve();
            }

            this.planeMarker2.on('click', () => {
                this.isAnimationOver = true;
                //On retire le marqueur de l'avion une fois l'animation terminée, lorsque le joueur est arrivé à destination.
            });

        },
        
        /**
         * Méthode apppelant la fonction pour annimer l'avion.
         * @param {Marker} marker - Le marqueur de l'avion.
         * @param {Array} path - La route de l'avion
         * @param {number} totalTime - Durée totale de l'animation en millisecondes.
         * @param {Function} onFirstAnimationComplete - La fonction à appeler lorsque la première animation est terminée.
         * @returns {Promise} - Une promesse qui sera résolue lorsque l'animation est terminée pour réguler le code asynchrone.
         */
        movePlane(marker, path, totalTime, onFirstAnimationComplete) {
            return new Promise((resolve) => {
                let startTime = null;
                console.log('Moving plane...');
                this.animate(null, startTime, totalTime, path, marker, resolve, onFirstAnimationComplete);
            });
        },
        

        startAnimations() {
            try {
                // Utilise this.planeMarker pour accéder aux données du composant
                this.movePlane(this.planeMarker, this.planePath, 5000, () => {
                    //Lorsque l'annimation est terminée on change le centre de la carte pour suivre l'avion. On arrive donc Outre-Manche.
                    this.map.setView(this.centerCoordinates2, 14);
                })
                .then(() => {
                    return this.movePlane(this.planeMarker2, this.planePath2, 5000);
                })
                .catch(error => {
                    console.error('Error in startAnimations:', error);
                });
        
            } catch (error) {
                console.error('Error in startAnimations:', error);
            }
        }
        
          
    }

});

mapp.$mount('#appli');
window.app = mapp;


