<?php
// Inclure la connexion à la base de données
include('db/db_connection.php');

// Récupérer les données du formulaire
$marque = $_POST['marque'];
$modele = $_POST['modele'];
$prix = $_POST['prix'];
$description = $_POST['description'];

// Insérer les données dans la base de données
$sql_insert_annonce = "INSERT INTO voiture (marque, modele, prix_par_jour, description) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_annonce);
$stmt->bind_param("ssds", $marque, $modele, $prix, $description);

if ($stmt->execute()) {
    echo "Annonce déposée avec succès.";
    header("Location: annonces.php");  // Rediriger vers la page des annonces
    exit;
} else {
    echo "Erreur lors du dépôt de l'annonce : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>