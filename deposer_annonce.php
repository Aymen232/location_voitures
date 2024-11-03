<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déposer une annonce - Location de Voitures</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?php include('includes/includes_header.php'); ?>
</header>

<main>
    <h1>Déposer une nouvelle annonce</h1>

    <form action="process_annonce.php" method="POST">
        <div class="form-group">
            <label for="marque">Marque de la voiture :</label>
            <input type="text" id="marque" name="marque" required>
        </div>
        <div class="form-group">
            <label for="modele">Modèle de la voiture :</label>
            <input type="text" id="modele" name="modele" required>
        </div>
        <div class="form-group">
            <label for="prix">Prix par jour (€) :</label>
            <input type="number" id="prix" name="prix" required>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="1" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-deposer-annonce">Déposer l'annonce</button>
        </div>
    </form>

</main>

<footer>
    <?php include('includes/includes_footer.php'); ?>
</footer>

</body>
</html>
