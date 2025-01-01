<?php
include('../DB/db_connection.php');
session_start();

// Vérification si l'utilisateur est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    die("Accès refusé : Vous devez être un administrateur pour accéder à cette page.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $action = $_POST['action'];

    // Préparer la requête SQL selon l'action
    if ($action === 'valider') {
        $sql = "UPDATE annonces SET statut = 'validée', motif_refus = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    } elseif ($action === 'refuser') {
        $motif = isset($_POST['motif']) ? trim($_POST['motif']) : null;

        if (empty($motif)) {
            $_SESSION['error'] = "Vous devez fournir un motif de refus.";
            header("Location: gestion_annonces.php");
            exit();
        }

        $sql = "UPDATE annonces SET statut = 'refusée', motif_refus = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $motif, $id);
    } else {
        die("Action non valide.");
    }

    // Exécuter la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Annonce $action avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'action : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirection vers la page de gestion des annonces
    header("Location: gestion_annonces.php");
    exit();
}
