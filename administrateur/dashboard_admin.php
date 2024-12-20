<?php
session_start();
include('../DB/db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: ../login.php");
    exit();
}

$annonces_query = "SELECT a.*, u.email 
                   FROM annonces a 
                   JOIN utilisateurs u ON a.utilisateur_id = u.id 
                   WHERE a.statut = 'en attente' 
                   ORDER BY a.date_creation DESC";
$annonces_result = $conn->query($annonces_query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil: Location de voitures</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <?php include('../includes/includes_header_dashboard.php'); ?>
</header>
<div class="status-connexion">
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($_SESSION['prenom']) . " " . htmlspecialchars($_SESSION['nom']); ?></strong></p>
        <?php else: ?>
        <p>Vous n'êtes pas connecté</p>
    <?php endif; ?>
</div>
    <div class="header-container">
        <h1 class="align-left-middle">Annonces en attente</h1>
    </div>
    <?php if ($annonces_result && $annonces_result->num_rows > 0): ?>
        <?php while ($annonce = $annonces_result->fetch_assoc()): ?>
            <div class="annonce">
                <h3>Marque : <?php echo htmlspecialchars($annonce['marque']); ?></h3>
                <p>Description : <?php echo htmlspecialchars($annonce['description']); ?></p>
                <a href="gestion_annonces.php?id=<?php echo $annonce['id']; ?>">Gérer</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucune annonce en attente.</p>
    <?php endif; ?>
</body>
</html>
