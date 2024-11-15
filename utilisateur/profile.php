<?php
// utilisateur_dashboard.php
session_start();
require_once '../db/db_connection.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: profile.php");
    exit();
}

// Récupérez les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM utilisateur WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Utilisateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo $user['nom']; ?></h1>
    
    <section>
        <h2>Mes Réservations</h2>
        <!-- Code pour afficher les réservations de l'utilisateur -->
        <?php
        $reservations_query = "SELECT * FROM reservation WHERE user_id = $user_id";
        $reservations_result = mysqli_query($conn, $reservations_query);
        while ($reservation = mysqli_fetch_assoc($reservations_result)) {
            echo "<div class='reservation'>";
            echo "<h3>Réservation ID: {$reservation['id']}</h3>";
            echo "<p>Date de début: {$reservation['date_debut']}</p>";
            echo "<p>Date de fin: {$reservation['date_fin']}</p>";
            echo "</div>";
        }
        ?>
    </section>
    
    <section>
        <h2>Mes Annonces</h2>
        <!-- Code pour afficher les annonces de l'utilisateur -->
        <?php
        $annonces_query = "SELECT * FROM annonces WHERE user_id = $user_id";
        $annonces_result = mysqli_query($conn, $annonces_query);
        while ($annonce = mysqli_fetch_assoc($annonces_result)) {
            echo "<div class='annonce'>";
            echo "<h3>{$annonce['titre']}</h3>";
            echo "<p>{$annonce['description']}</p>";
            echo "</div>";
        }
        ?>
    </section>
    <section>
        <h2>Mes Informations</h2>
        <p>Nom : <?php echo $user['nom']; ?></p>
        <p>Email : <?php echo $user['email']; ?></p>
        <a href="profile.php" class="btn">Modifier mes informations</a>
    </section>
</body>
</html>