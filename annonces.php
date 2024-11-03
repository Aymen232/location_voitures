<?php
// Inclure la connexion à la base de données
include('db/db_connection.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces:Location de Voitures</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?php include('includes/includes_header.php'); ?>
</header>

<main>
    <h1>Nos Annonces de Voitures</h1>

    <!-- Bouton pour déposer une annonce -->
    <section id="deposer-annonce">
        <a href="deposer_annonce.php" class="btn-deposer-annonce">Déposer une annonce</a>
    </section>

    <!-- Section pour afficher les annonces -->
    <section id="annonces">
        <?php
        // Récupérer toutes les annonces (voitures disponibles) depuis la base de données
        $sql = "SELECT * FROM voiture WHERE disponible = 1";
        $result = mysqli_query($conn, $sql);

        // Vérifier s'il y a des résultats
        if (mysqli_num_rows($result) > 0) {
            // Boucle pour afficher chaque annonce
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='annonce'>";
                echo "<h2>" . $row['marque'] . " " . $row['modele'] . "</h2>";
                echo "<p>Prix par jour : " . $row['prix_par_jour'] . " €</p>";
                echo "<p>Description : " . $row['description'] . "</p>";
                echo "</div>";
            }
        } else {
            // Message si aucune annonce disponible
            echo "<p>Aucune annonce disponible pour le moment.</p>";
        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);
        ?>
    </section>

</main>

<footer>
    <?php include('includes/includes_footer.php'); ?>
</footer>

</body>
</html>
