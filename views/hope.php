<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape Game</title>
    <link rel="icon" type="image/png" href="images/logoF1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


    <link rel="stylesheet" href="assets/stylesMap.css">
    <link rel="stylesheet" href="assets/style.css">



</head>

<body>
    <div id="appli" style="display: flex;">
        <div id="ranking"></div>
        <div id="map"> 
        </div>
        <div id="inventory">
            <div id="inventaire">
                <h2>Inventaire</h2>
                <ul id="inventory-list" class="draggable">
                <li v-for="(item, index) in inventoryList" :key="index" @click="toggleSelectedItem(item)">
                    <strong>{{ item.name }}</strong><br>
                    <div :class="{ 'selected': item === selectedItem }" v-html="item.img"></div>
                </li>
                </ul>
                <div id="inventory-image"></div>
            <div>
            <div id="heureContainer" v-if="formattedTime !== undefined">
                Temps écoulé : <span>{{ formattedTime }}</span>
                <span id="currentplayer">{{ currentPlayer }}</span>
            </div>
        </div>
    </div>

<script>
    const currentPlayer = <?php echo json_encode($_SESSION['pseudo']); ?>;
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/vue@2"></script>
<script src ="assets/mapVue2.js"></script>
        
</body>

</html>
