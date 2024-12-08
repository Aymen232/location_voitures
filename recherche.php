<?php
// Connexion à la base de données
include 'DB/db_connection.php';

if (!isset($pdo)) {
    die("Erreur : La connexion à la base de données n'est pas établie.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $location = $_POST['location'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Requête SQL pour trouver les annonces correspondantes
    $query = "SELECT * FROM annonce WHERE location = ? AND start_date = ? AND end_date = ? AND start_time = ? AND end_time = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$location, $startDate, $endDate, $startTime, $endTime]);

    // Affiche les résultats
    echo "<h2>Résultats de la recherche</h2>";
    
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $annonce) {
            echo "<div class='annonce'>";
            echo "<h3>{$annonce['titre']}</h3>";
            echo "<p>Description : {$annonce['description']}</p>";
            echo "<p>Lieu : {$annonce['location']}</p>";
            echo "<p>Date de début : {$annonce['start_date']}, Heure de début : {$annonce['start_time']}</p>";
            echo "<p>Date de fin : {$annonce['end_date']}, Heure de fin : {$annonce['end_time']}</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Pas d'annonces actuellement.</p>";
    }
}
?>
