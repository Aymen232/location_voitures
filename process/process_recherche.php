<?php
// Inclure la connexion à la base de données
include '../DB/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $lieu = trim($_POST['location'] ?? '');
    $date_debut = $_POST['date_debut'] ?? '';
    $heure_debut = $_POST['heure_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $heure_fin = $_POST['heure_fin'] ?? '';

    // Combinaison des dates et heures pour la requête SQL
    $date_heure_debut = $date_debut . ' ' . ($heure_debut ?: '00:00:00');
    $date_heure_fin = $date_fin . ' ' . ($heure_fin ?: '23:59:59');

    // Requête SQL pour inclure les annonces disponibles sur une partie ou toute la période
    $sql = "SELECT * FROM annonces
            WHERE LOWER(location) = LOWER(?)
            AND (
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) >= ? AND CONCAT(date_fin, ' ', heure_fin) <= ?)
            )
            AND statut = 'validée'";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur dans la préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param("sssssss", $lieu, $date_heure_debut, $date_heure_debut, $date_heure_fin, $date_heure_fin, $date_heure_debut, $date_heure_fin);

    // Exécution de la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Stocker les résultats dans la session
    $_SESSION['resultats'] = [];
    while ($row = $result->fetch_assoc()) {
        $_SESSION['resultats'][] = $row;
    }

    // Définir un message si aucun résultat n'est trouvé
    if (empty($_SESSION['resultats'])) {
        $_SESSION['message'] = "Pas d'annonces similaires.";
    } else {
        unset($_SESSION['message']);
    }

    // Fermeture des connexions
    $stmt->close();
    $conn->close();

    // Redirection vers recherche.php
    header("Location: ../recherche.php");
    exit();
}
