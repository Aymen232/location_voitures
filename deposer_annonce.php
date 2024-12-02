<?php
// Démarrer la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déposer une annonce</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <?php include("includes/includes_header.php"); ?>
</header>
<body>
    <div class="form-container">
        <h2>Déposer une annonce</h2>
        <form action="process/process_annonce.php" method="POST">
            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" required>
            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" required>
            <label for="prix">Prix par jour (€) :</label>
            <input type="number" id="prix" name="prix" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <label for="location">Lieu de location :</label>
            <input type="text" id="location" name="location" required>
            <label for="start_date">Date de début :</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">Date de fin :</label>
            <input type="date" id="end_date" name="end_date" required>
            <button type="submit">Déposer l'annonce</button>
        </form>
    </div>
</body>
</html>
