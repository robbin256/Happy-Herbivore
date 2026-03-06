<?php
if(isset($_POST['start'])){
    header("Location: bestellen.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Happy Herbivore - Start</title>

<style>
body {
    margin: 0;
    background: #111;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: Arial, sans-serif;
}

/* Zuil formaat */
.screen {
    width: 1080px;
    height: 1920px;
    background: linear-gradient(180deg, #1c1c1c, #0f0f0f);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 100px 60px;
    box-sizing: border-box;
}

/* Bovenste logo */
.logo-top img {
    width: 400px;
}

/* Midden logo groot */
.logo-main img {
    width: 650px;
}

/* Onderste knop */
.start-section {
    width: 100%;
    text-align: center;
}

.start-button {
    width: 100%;
    padding: 60px;
    font-size: 60px;
    font-weight: bold;
    background-color: #00c853;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: 0.2s;
}

.start-button:active {
    transform: scale(0.97);
    background-color: #00b248;
}

/* Kleine subtitel */
.subtitle {
    margin-top: 30px;
    font-size: 32px;
    opacity: 0.7;
}
</style>
</head>

<body>

<div class="screen">

    <!-- Boven -->
    <div class="logo-top">
        <img src="logo1.png" alt="Logo">
    </div>

    <!-- Midden -->
    <div class="logo-main">
        <img src="logo2.png" alt="Logo">
    </div>

    <!-- Onder -->
    <div class="start-section">
        <form method="post">
            <button class="start-button" name="start">
                Bestelling starten
            </button>
        </form>
        <div class="subtitle">
            Tik op het scherm om te beginnen
        </div>
    </div>

</div>

</body>
</html>
