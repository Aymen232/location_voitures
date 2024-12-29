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
        <form action="process/process_annonce.php" method="POST" enctype="multipart/form-data">
            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" required>
            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" required>
            <label for="prix_par_jour">Prix par jour (€) :</label>
            <input type="number" id="prix_par_jour" name="prix_par_jour" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <label for="location">Lieu de location :</label>
            <input type="text" id="location" name="location" required>
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" required>
            <label for="heure_debut">Heure de début :</label>
            <input type="time" id="heure_debut" name="heure_debut" required>
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" required>
            <label for="heure_fin">Heure de fin :</label>
            <input type="time" id="heure_fin" name="heure_fin" required>
            <label for="photo">Photo de la voiture :</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
            <button type="submit">Déposer l'annonce</button>
        </form>
    </div>
</body>
</html>
