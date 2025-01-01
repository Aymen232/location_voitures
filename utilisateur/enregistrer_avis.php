<?php
session_start();
require_once '../DB/db_connection.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    $_SESSION['error'] = "Veuillez vous connecter pour donner un avis.";
    header("Location: ../login.php");
    exit();
}

// Récupérez les données du formulaire
$annonce_id = $_POST['annonce_id'];
$note = $_POST['note'];
$commentaire = $_POST['commentaire'];
$utilisateur_id = $_SESSION['user_id'];

if (!empty($annonce_id) && !empty($note) && !empty($commentaire)) {
    // Requête pour insérer un avis dans la table `avis`
    $stmt = $conn->prepare("INSERT INTO avis (utilisateur_id, annonce_id, note, commentaire) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $utilisateur_id, $annonce_id, $note, $commentaire);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Avis enregistré avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de l'enregistrement de l'avis.";
    }
} else {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
}

header("Location: profile.php");
exit();
