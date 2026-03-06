<?php
// Hier kun je later PHP functionaliteit toevoegen
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Happy Herbivore</title>
<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="screen">
    <div class="overlay"></div>

    <form method="post">
        <button class="start-button" name="start">
            START
        </button>
    </form>
</div>

<?php
if(isset($_POST['start'])){
    echo "<script>alert('Welkom bij Happy Herbivore! 🌱');</script>";
}
?>

</body>
</html>
