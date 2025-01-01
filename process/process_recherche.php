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
    $marque = $_POST['marque'] ?? '';
    $modele = $_POST['modele'] ?? '';
    $tri = $_POST['tri'] ?? '';

    // Combinaison des dates et heures pour la requête SQL
    $date_heure_debut = $date_debut . ' ' . ($heure_debut ?: '00:00:00');
    $date_heure_fin = $date_fin . ' ' . ($heure_fin ?: '23:59:59');

    // Construction de la requête SQL avec les filtres
    $sql = "SELECT * FROM annonces WHERE statut = 'validée'";

    $params = [];
    $types = '';

    if (!empty($lieu)) {
        $sql .= " AND LOWER(location) = LOWER(?)";
        $params[] = $lieu;
        $types .= 's';
    }

    $sql .= " AND (
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) <= ? AND CONCAT(date_fin, ' ', heure_fin) >= ?)
                OR
                (CONCAT(date_debut, ' ', heure_debut) >= ? AND CONCAT(date_fin, ' ', heure_fin) <= ?)
            )";
    $params = array_merge($params, [$date_heure_debut, $date_heure_debut, $date_heure_fin, $date_heure_fin, $date_heure_debut, $date_heure_fin]);
    $types .= 'ssssss';

    // Ajouter le tri par prix
    if ($tri === 'prix_croissant') {
        $sql .= " ORDER BY prix_par_jour ASC";
    } elseif ($tri === 'prix_decroissant') {
        $sql .= " ORDER BY prix_par_jour DESC";
    }

    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur dans la préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres dynamiquement
    $stmt->bind_param($types, ...$params);

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
        $_SESSION['message'] = "Aucune annonce ne correspond à vos critères.";
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
