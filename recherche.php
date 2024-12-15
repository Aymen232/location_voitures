<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche d'Annonces</title>
</head>
<body>
    <h1>Rechercher une Annonce</h1>
    <!-- Formulaire de recherche -->
    <form action="process_recherche.php" method="POST">
        <label for="lieu">Lieu de prise en charge :</label>
        <input type="text" name="lieu" required><br>

        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" required><br>

        <label for="heure_debut">Heure de début :</label>
        <input type="time" name="heure_debut"><br>

        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" required><br>

        <label for="heure_fin">Heure de fin :</label>
        <input type="time" name="heure_fin"><br>

        <button type="submit">Rechercher</button>
    </form>

    <!-- Affichage des résultats -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p>{$_SESSION['message']}</p>";
    } elseif (!empty($_SESSION['recherche_resultats'])) {
        echo "<h2>Résultats trouvés :</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Prix par jour</th>
                    <th>Description</th>
                    <th>Date début</th>
                    <th>Heure début</th>
                    <th>Date fin</th>
                    <th>Heure fin</th>
                </tr>";
        foreach ($_SESSION['recherche_resultats'] as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['marque']) . "</td>
                    <td>" . htmlspecialchars($row['modele']) . "</td>
                    <td>" . htmlspecialchars($row['prix_par_jour']) . " €</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['date_debut']) . "</td>
                    <td>" . htmlspecialchars($row['heure_debut']) . "</td>
                    <td>" . htmlspecialchars($row['date_fin']) . "</td>
                    <td>" . htmlspecialchars($row['heure_fin']) . "</td>
                  </tr>";
        }
        echo "</table>";
    }
    // Nettoyer les résultats après affichage
    unset($_SESSION['recherche_resultats']);
    unset($_SESSION['message']);
    ?>
</body>
</html>
