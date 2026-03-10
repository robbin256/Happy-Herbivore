<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idle Page - Happy Herbivore</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1920px;
            overflow: hidden;
            background-color: #000;
            font-family: sans-serif;
        }

        #bg-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 1080px;
            height: 1920px;
            z-index: 1;
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

        #logo-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            width: 800px;
        }

        #logo-container img {
            max-width: 550px;
            height: auto;
            filter: drop-shadow(0px 10px 20px rgba(0, 0, 0, 0.6));
            margin-bottom: 50px;
            animation: float 5s ease-in-out infinite;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            margin-top: 40px;
            animation: float 5s ease-in-out infinite 0.3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .btn {
            width: 550px;
            padding: 45px 20px;
            font-size: 52px;
            font-weight: 800;
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 5px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: all 0.6s;
        }

        .btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.8);
            transform: scale(1.03) translateY(-5px);
            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.5),
                0 0 25px rgba(255, 255, 255, 0.2);
            letter-spacing: 7px;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <?php
    $img_dir = 'assets/img/';
    $images = glob($img_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    if ($images === false || empty($images)) {
        // Fallback for systems without GLOB_BRACE support
        $images = array_merge(
            (array) glob($img_dir . '*.jpg'),
            (array) glob($img_dir . '*.jpeg'),
            (array) glob($img_dir . '*.png'),
            (array) glob($img_dir . '*.gif')
        );
    }
    // Remove empty values and reindex
    $images = array_values(array_filter($images));
    $images_json = json_encode($images);
    ?>

    <div id="bg-container">
        <!-- Background images will be injected here via JavaScript -->
    </div>

    <div id="logo-container">
        <img src="assets/logo%27s/logo-happy.png" alt="Happy Herbivore Logo">
        <div class="button-container">
            <a href="productPage.html" class="btn" id="eat-here">hier opeten</a>
            <a href="productPage.html" class="btn" id="takeaway">afhalen</a>
        </div>
    </div>

    <script>
        const images = <?php echo $images_json; ?>;
        const bgContainer = document.getElementById('bg-container');
        let currentIndex = 0;

        if (images && images.length > 0) {
            // Create div for each image sequence
            images.forEach((src, index) => {
                const div = document.createElement('div');
                div.className = 'bg-image';
                if (index === 0) div.classList.add('active');

                // Escape single quotes for background-image URL
                const escapedSrc = src.replace(/'/g, "%27");
                div.style.backgroundImage = `url('${escapedSrc}')`;

                bgContainer.appendChild(div);
            });

            // Rotate images every 5 seconds
            setInterval(() => {
                const bgElements = document.querySelectorAll('.bg-image');
                if (bgElements.length > 1) {
                    bgElements[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % images.length;
                    bgElements[currentIndex].classList.add('active');
                }
            }, 3000);
        }
    </script>
</body>

</html>