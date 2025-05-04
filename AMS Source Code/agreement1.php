<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Skyline Spinner</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1e1e2e;
            overflow: hidden;
        }

        .spinner-container {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 10px;
        }

        .cityscape {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            animation: changeTime 6s infinite linear;
            z-index: 0; /* Ensures the city is below the sun/moon */
        }

        .sun-moon {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: yellow;
            animation: sunMoonCycle 6s infinite linear;
            transform: translate(-50%, -50%);
            z-index: 1; /* Keeps sun/moon on top */
        }

        @keyframes changeTime {
            0%, 100% { background-image: url('morning.jpg'); }
            25% { background-image: url('noon.jpg'); }
            50% { background-image: url('evening.jpg'); }
            75% { background-image: url('night.jpg'); }
        }

        @keyframes sunMoonCycle {
            0%, 100% {
                background-color: yellow;
                transform: translate(-50%, -80px);
            }
            50% {
                background-color: white;
                transform: translate(-50%, 80px);
            }
        }
    </style>
</head>
<body>
    <div class="spinner-container">
        <div class="cityscape"></div>
        <div class="sun-moon"></div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = 'payment.php';
        }, 8000);
    </script>
</body>
</html>
