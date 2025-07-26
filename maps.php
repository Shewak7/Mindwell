<?php
include "connection.php";

$query = "SELECT * FROM mental_health_centers";
$stmt = $pdo->prepare($query);
$stmt->execute();
$centers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Mental Health Centers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: calc(100vh - 200px);
        }
        .leaflet-popup-content-wrapper {
            background: transparent;
            border: none;
            box-shadow: none;
        }
        .leaflet-popup-tip-container {
            display: none;
        }
        .leaflet-marker-icon {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white p-6 text-center">
        <h1 class="text-4xl font-bold">MindWell</h1>
        <nav class="mt-4">
            <ul class="flex justify-center space-x-8">
                <li><a href="home.php" class="hover:text-yellow-300">Home</a></li>
                <li><a href="profile.php" class="hover:text-yellow-300">My Profile</a></li>
                <li><span class="text-blue-300">Mental Health Centers</span></li>
                <li><a href="about.php" class="hover:text-yellow-300">About Us</a></li>
                <li><a href="login.php" class="hover:text-yellow-300">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="my-6 text-center">
        <button onclick="navigateToNearestCenter()" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-green-700">
            Navigate to Nearest Center
        </button>
    </div>

    <div id="map" class="m-6 rounded shadow-lg"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map').setView([13.0827, 80.2707], 12); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var centers = <?php echo json_encode($centers); ?>;

        var userMarker = null;
        var routeControl;

        centers.forEach(center => {
            L.marker([center.latitude, center.longitude])
                .addTo(map)
                .bindPopup(`<b>${center.name}</b><br>${center.address}`)
                .openPopup();
        });

        map.on('click', function(e) {
            if (userMarker) {
                map.removeLayer(userMarker);
            }

            userMarker = L.marker(e.latlng, { 
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                }), 
                draggable: true 
            })
            .addTo(map)
            .bindPopup('Your chosen location')
            .openPopup();

            userMarker.on('dragend', function(event) {
                userMarker.setLatLng(event.target.getLatLng());
            });
        });

        function navigateToNearestCenter() {
            if (userMarker) {
                var userCoordinates = [userMarker.getLatLng().lat, userMarker.getLatLng().lng];
                var nearestCenter = findNearestCenter(userCoordinates);

                if (nearestCenter) {
                    var nearestCoordinates = [nearestCenter.latitude, nearestCenter.longitude];

                    if (routeControl) {
                        map.removeControl(routeControl);
                    }

                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(userCoordinates),
                            L.latLng(nearestCoordinates)
                        ],
                        routeWhileDragging: true
                    }).addTo(map);

                    map.setView(userCoordinates, 13);

                    L.marker(userCoordinates, { icon: redIcon }).addTo(map).bindPopup('Your current location');
                } else {
                    alert('No mental health centers found.');
                }
            } else {
                alert('Please click on a location on the map first.');
            }
        }

        function findNearestCenter(userCoordinates) {
            var nearestCenter = null;
            var minDistance = Number.MAX_VALUE;

            centers.forEach(center => {
                var centerCoordinates = [center.latitude, center.longitude];
                var distance = calculateDistance(userCoordinates[0], userCoordinates[1], centerCoordinates[0], centerCoordinates[1]);
                if (distance < minDistance) {
                    minDistance = distance;
                    nearestCenter = center;
                }
            });

            return nearestCenter;
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            var R = 6371; 
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a = 
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; 
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    </script>
    <footer class="bg-blue-600 text-white text-center p-4">
        <p>&copy; 2024 MindWell. All rights reserved.</p>
    </footer>
</body>
</html>
