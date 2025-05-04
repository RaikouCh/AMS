<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('image/462569797_2056616284786278_3431511704346069351_n.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f9f9f9;
            padding: 20px;
        }

        /* Improved Header */
        .header {
            width: 100%;
            max-width: 650px;
            background-color: rgba(0, 0, 0, 0.8); /* Darker blue with slight opacity */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.8);
        }

        .header h1 {
            font-size: 26px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 20px;
            font-weight: normal;
            margin-top: 5px;
        }

        /* Improved Confirmation Section */
        .confirmation {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.6s ease-in-out;
        }

        .confirmation h2 {
            font-size: 24px;
            color: #0047AB;
            margin-bottom: 10px;
        }

        .confirmation p {
            font-size: 18px;
            color: #333;
            margin-top: 10px;
        }

        /* Button Styling */
        .button-container {
            margin-top: 20px;
        }

        button {
            width: 120px;
            height: 40px;
            border: none;
            background-color:rgb(0, 0, 0);
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        button:hover {
            background: rgba(89, 90, 90, 0.7);
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Fix */
        @media (max-width: 600px) {
            .header, .confirmation {
                width: 95%;
            }
            .header h1 {
                font-size: 22px;
            }
            .confirmation h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Payment Confirmation</h1>
        <h2>DM4J's Apartment</h2>
    </header>

    <section class="confirmation">
        <h2>Thank You for Your Reservation!</h2>
        <p>Your payment has been successfully recorded.</p>

        <?php
        // Get first name and last name from URL
        $firstname = isset($_GET['firstname']) ? htmlspecialchars($_GET['firstname']) : "Guest";
        $lastname = isset($_GET['lastname']) ? htmlspecialchars($_GET['lastname']) : "";

        echo "<p><strong>Client Name:</strong> $firstname $lastname</p>";
        ?>

        <div class="button-container">
            <button onclick="redirect()">Return</button>
        </div>
    </section>

    <script>
        function redirect() {
            window.location.href = "login1.php"; // Redirects back to login page
        }
    </script>

</body>
</html>
