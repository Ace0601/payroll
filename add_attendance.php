<?php include 'db_connect.php' ?>

<!-- ADD ATTENDANCE USING QR CODE SCANNING -->
<head>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
</head>

    <form action="" method="POST">
    <h3 class="container d-flex justify-content-center">Scan QR Code for Attendance</h3>
    <video id="video" width="400" height="300" autoplay></video>
    <canvas id="canvas" style="display:none;"></canvas>
    <div id="result"></div>

    <script>
        // Get access to the camera and video element
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(function(stream) {
                var video = document.getElementById("video");
                video.srcObject = stream;
                video.play();
            })
            .catch(function(error) {
                console.log("Error accessing the camera: " + error);
            });

        // Start scanning the QR code
        function scanQRCode() {
            var video = document.getElementById("video");
            var canvas = document.getElementById("canvas");
            var context = canvas.getContext("2d");

            // Draw the video frame on the canvas
            context.drawImage(video, 0, 0, 200, 200);

            // Get the QR code data from the canvas
            var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height);

            // Display the result if a QR code is found
            if (code) {
                document.getElementById("result").innerHTML = "QR Code Data: " + code.data;
            }

            // Repeat the scanning process
            requestAnimationFrame(scanQRCode);
        }

        // Start scanning when the page loads
        window.onload = function() {
            scanQRCode();
        };
    </script>
    </form


<?php
    // This PHP code can be used to process the scanned QR code data if required
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST['data']; // Retrieve the QR code data from the POST request
    }
?>


