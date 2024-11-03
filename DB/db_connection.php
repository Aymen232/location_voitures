<?php
// Informations de connexion à la base de données
$servername = "localhost";   // Nom de l'hôte, souvent "localhost"
$username = "root";          // Nom d'utilisateur MySQL
$password = "";              // Mot de passe MySQL
$dbname = "location_voitures";  // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Afficher un message si la connexion est réussie (pour le débogage)
// echo "Connexion réussie à la base de données";
?>
