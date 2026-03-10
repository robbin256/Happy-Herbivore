<!DOCTYPE html>
<html lang="nl">

<?php
$img_dir = 'assets/img/';
$images = glob($img_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
if ($images === false || empty($images)) {
    $images = array_merge(
        (array) glob($img_dir . '*.jpg'),
        (array) glob($img_dir . '*.jpeg'),
        (array) glob($img_dir . '*.png'),
        (array) glob($img_dir . '*.gif')
    );
}
$images = array_values(array_filter($images));
$images_json = json_encode($images);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedankt voor je bestelling - Happy Herbivore</title>
    <link rel="icon" type="image/png" href="assets/logo's/logo-happy.png">
    <style>
        @font-face {
            font-family: 'RenosRough';
            src: url('../fonts/Renos-Rough.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * {
            font-family: 'RenosRough';
        }


        body,
        html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1920px;
            overflow: hidden;
            background-color: #000;
            font-family: 'Outfit', 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        #bg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 1080px;
            height: 1920px;
            z-index: 0;
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }

        .bg-image.active {
            opacity: 1;
        }

        #bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 900px;
            animation: fadeIn 1.2s ease-out;
        }

        .logo-container img {
            max-width: 600px;
            height: auto;
            filter: drop-shadow(0px 15px 30px rgba(0, 0, 0, 0.5));
            margin-bottom: 80px;
            animation: float 4s ease-in-out infinite;
        }

        .message-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 80px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        h1 {
            font-size: 72px;
            font-weight: 800;
            margin: 0 0 30px 0;
            background: linear-gradient(135deg, #2ed573, #7bed9f);
            /* -webkit-background-clip: text; */
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            font-size: 38px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.4;
            margin: 0;
            font-weight: 300;
        }

        .check-icon {
            font-size: 120px;
            color: #2ed573;
            margin-bottom: 40px;
            display: inline-block;
            animation: scaleIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.5s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Auto redirect visual indicator */
        .timer-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 8px;
            background: #2ed573;
            border-radius: 0 4px 4px 0;
            animation: shrink 10s linear forwards;
        }

        @keyframes shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>
</head>

<body>
    <div id="bg-container"></div>
    <div id="bg-overlay"></div>

    <div class="container">
        <div class="logo-container">
            <img src="assets/logo%27s/logo-happy.png" alt="Happy Herbivore Logo">
        </div>

        <div class="message-box">
            <div class="check-icon">✓</div>
            <h1>Bedankt!</h1>
            <p>Eet smakelijk, je bestelling<br>wordt nu klaargemaakt.</p>
        </div>
    </div>

    <div class="timer-bar"></div>

    <script>
        const images = <?php echo $images_json; ?>;
        const bgContainer = document.getElementById('bg-container');
        let currentIndex = 0;

        if (images && images.length > 0) {
            images.forEach((src, index) => {
                const div = document.createElement('div');
                div.className = 'bg-image';
                if (index === 0) div.classList.add('active');
                const escapedSrc = src.replace(/'/g, "%27");
                div.style.backgroundImage = `url('${escapedSrc}')`;
                bgContainer.appendChild(div);
            });

            setInterval(() => {
                const bgElements = document.querySelectorAll('.bg-image');
                if (bgElements.length > 1) {
                    bgElements[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % images.length;
                    bgElements[currentIndex].classList.add('active');
                }
            }, 5000);
        }

        // Automatisch terug naar de idle page na 10 seconden
        setTimeout(() => {
            window.location.href = 'idlepage.php';
        }, 10000);
    </script>
</body>

</html>