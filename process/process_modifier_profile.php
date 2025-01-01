<?php
session_start();
require_once '../DB/db_connection.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];

// Validation basique des champs
if (empty($nom) || empty($prenom) || empty($email)) {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
    header("Location: modifier_profile.php");
    exit();
}

// Mise à jour des informations utilisateur
$stmt = $conn->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ? WHERE id = ?");
$stmt->bind_param("sssi", $nom, $prenom, $email, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Vos informations ont été mises à jour avec succès.";
    header("Location: ../utilisateur/profile.php");
} else {
    $_SESSION['error'] = "Erreur lors de la mise à jour des informations.";
    header("Location: ../utilisateur/modifier_profile.php");
}
exit();
