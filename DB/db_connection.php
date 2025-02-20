<?php
$host = 'localhost'; // Hôte de la base de données
$user = 'root';      // Nom d'utilisateur MySQL
$password = '';      // Mot de passe MySQL
$dbname = 'location_voitures'; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($host, $user, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>
