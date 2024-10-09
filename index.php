<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil: Location de voitures</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
<?php
include('includes/includes_header.php');
?>
</header>
<body>
    <h1>Bienvenue sur le site de location de voitures</h1>
    <p>Nous offrons une large sélection de véhicules pour répondre à vos besoins.</p>
    <div class="search-bar-container">
        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Rechercher une voiture " class="search-input">
            <button type="submit" class="search-button">Rechercher</button>
        </form>
    </div>
</body>
</html>
