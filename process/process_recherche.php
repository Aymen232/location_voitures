<?php
// Inclure le fichier de connexion
include '../DB/db_connection.php';

// Vérification que les données ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des données saisies dans la barre de recherche
    $lieu = trim($_POST['lieu'] ?? '');
    $date_debut = $_POST['date_debut'] ?? '';
    $heure_debut = $_POST['heure_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $heure_fin = $_POST['heure_fin'] ?? '';

    // Combinaison date et heure pour la comparaison si nécessaire
    $date_heure_debut = $date_debut . ' ' . ($heure_debut ?: '00:00:00');
    $date_heure_fin = $date_fin . ' ' . ($heure_fin ?: '23:59:59');

    // Requête SQL pour rechercher les annonces avec le statut "validée"
    $sql = "SELECT * FROM annonces
            WHERE location = ? 
            AND CONCAT(date_debut, ' ', heure_debut) <= ? 
            AND CONCAT(date_fin, ' ', heure_fin) >= ? 
            AND statut = 'validée'";

    // Exécution de la requête avec des paramètres préparés
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $lieu, $date_heure_debut, $date_heure_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification des résultats et affichage
    if ($result->num_rows > 0) {
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
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['marque']}</td>
                    <td>{$row['modele']}</td>
                    <td>{$row['prix_par_jour']} €</td>
                    <td>{$row['description']}</td>
                    <td>{$row['date_debut']}</td>
                    <td>{$row['heure_debut']}</td>
                    <td>{$row['date_fin']}</td>
                    <td>{$row['heure_fin']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune annonce similaire n'a été trouvée.</p>";
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Erreur : Données non reçues correctement.</p>";
}
?>
