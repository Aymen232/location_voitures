<?php
include('../DB/db_connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour déposer une annonce.";
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $utilisateur_id = $_SESSION['user_id'];
    $statut = 'en attente';

    $sql_insert = "INSERT INTO annonces (marque, modele, prix_par_jour, description, location, start_date, end_date, date_creation, statut, utilisateur_id) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $conn->prepare($sql_insert);

    if ($stmt) {
        $stmt->bind_param("ssdsssssi", $marque, $modele, $prix, $description, $location, $start_date, $end_date, $statut, $utilisateur_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Annonce déposée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur : " . $stmt->error;
        }
    } else {
        $_SESSION['error'] = "Erreur SQL : " . $conn->error;
    }
    header("Location: ../annonces.php");
    exit();
}
?>
