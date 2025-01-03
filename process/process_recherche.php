<?php
// Inclure la connexion à la base de données
include '../DB/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données des filtres
    $date_debut = $_POST['date_debut'] ?? '';
    $heure_debut = $_POST['heure_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $heure_fin = $_POST['heure_fin'] ?? '';

    // Combinaison des dates et heures pour la requête SQL
    $date_heure_debut = $date_debut . ' ' . ($heure_debut ?: '00:00:00');
    $date_heure_fin = $date_fin . ' ' . ($heure_fin ?: '23:59:59');

    // Construction de la requête SQL
    $sql = "SELECT * FROM annonces WHERE statut = 'validée' AND (
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) >= ? AND CONCAT(date_fin, ' ', heure_fin) <= ?)
            )";

    $params = [$date_heure_debut, $date_heure_debut, $date_heure_fin, $date_heure_fin, $date_heure_debut, $date_heure_fin];
    $types = 'ssssss';

    // Préparation et exécution de la requête
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur dans la préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    // Stockage des résultats
    $_SESSION['resultats'] = $result->fetch_all(MYSQLI_ASSOC);

    // Définir un message si aucun résultat
    if (empty($_SESSION['resultats'])) {
        $_SESSION['message'] = "Aucune annonce ne correspond à vos critères.";
    }

    $stmt->close();
    $conn->close();

    // Redirection vers la page des résultats
    header("Location: ../recherche.php");
    exit();
}
