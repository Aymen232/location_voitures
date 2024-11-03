<?php
// dashboard_admin.php
session_start();
require_once '../db/db_connection.php';

// Vérifiez si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Récupérez les informations de l'administrateur
$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo $admin['nom']; ?></h1>
    
    <section>
        <h2>Annonces à Valider</h2>
        <!-- Code pour afficher les annonces en attente de validation -->
        <?php
        $annonces_query = "SELECT * FROM annonces WHERE status = 'en attente'";
        $annonces_result = mysqli_query($conn, $annonces_query);
        while ($annonce = mysqli_fetch_assoc($annonces_result)) {
            echo "<div class='annonce'>";
            echo "<h3>{$annonce['titre']}</h3>";
            echo "<p>{$annonce['description']}</p>";
            echo "<a href='gestion_annonces.php?id={$annonce['id']}'>Valider cette annonce</a>";
            echo "</div>";
        }
        ?>
    </section>
    
    <section>
        <h2>Informations Administrateur</h2>
        <p>Nom : <?php echo $admin['nom']; ?></p>
        <p>Email : <?php echo $admin['email']; ?></p>
        <a href="profile.php" class="btn">Modifier mes informations</a>
    </section>
</body>
</html>
