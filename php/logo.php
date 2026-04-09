<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodnPals Logo</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .logo-container {
            position: relative;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .rotating-logo {
            width: 50px;
            height: 50px;
            animation: rotate 3s linear infinite;
            filter: drop-shadow(0 0 20px rgba(76, 187, 23, 0.5));
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Optional: Add a pulsing effect */
        .logo-container::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border: 2px solid rgba(76, 187, 23, 0.3);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 0.5;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .logo-container {
                width: 200px;
                height: 200px;
            }
            
            .rotating-logo {
                width: 150px;
                height: 150px;
            }
            
            .logo-container::before {
                width: 180px;
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            .logo-container {
                width: 150px;
                height: 150px;
            }
            
            .rotating-logo {
                width: 100px;
                height: 100px;
            }
            
            .logo-container::before {
                width: 130px;
                height: 130px;
            }
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="images/logo11.png" alt="FoodnPals Logo" class="rotating-logo">
    </div>
</body>
</html>
