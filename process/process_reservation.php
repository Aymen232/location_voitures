<?php
session_start();
include '../DB/db_connection.php'; // Assurez-vous que ce fichier contient les détails de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $annonce_id = $_POST['annonce_id'] ?? null;

    if ($annonce_id) {
        // Mettre à jour la colonne est_reservee pour passer à 'réservée'
        $sql = "UPDATE annonces SET est_reservee = 'réservée' WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $annonce_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $_SESSION['success_message'] = "Réservation réussie !";
            } else {
                $_SESSION['error_message'] = "Erreur lors de la réservation.";
            }

            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Erreur dans la préparation de la requête.";
        }
    } else {
        $_SESSION['error_message'] = "Aucune annonce sélectionnée.";
    }

    // Redirection vers la page des annonces
    header('Location: ../annonces.php');
    exit();
}
?>
