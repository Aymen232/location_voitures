<?php
// Inclure la connexion à la base de données
include('DB/db_connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    // Insérer les données dans la base de données
    $sql_insert_annonce = "INSERT INTO annonce (marque, modele, prix_par_jour, description, location, start_date, end_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql_insert_annonce);

    // Exécuter la requête avec les valeurs récupérées
    if ($stmt->execute([$marque, $modele, $prix, $description, $location, $startDate, $endDate, $startTime, $endTime])) {
        // Stocker un message de confirmation dans la session
        $_SESSION['message'] = "Annonce ajoutée avec succès.";
        header("Location: annonces.php"); // Rediriger vers la page des annonces
        exit;
    } else {
        echo "Erreur lors du dépôt de l'annonce : " . $stmt->errorInfo()[2];
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
