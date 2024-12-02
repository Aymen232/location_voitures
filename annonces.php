<?php
// Inclure la connexion à la base de données
include('DB/db_connection.php');

// Démarrer la session
session_start();

// Vérifier que la connexion est bien établie
if (!isset($conn)) {
    die("Erreur : La connexion à la base de données n'a pas été initialisée.");
}

// Récupérer les annonces validées depuis la base de données
$sql_select_annonces = "SELECT * FROM annonce WHERE statut = 'validée' ORDER BY date_creation DESC";
$result = $conn->query($sql_select_annonces);

if ($result) {
    $annonces = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("Erreur lors de la récupération des annonces : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annonces</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <?php include('includes/includes_header.php'); ?>
</header>
<body>
    <div class="container">
        <h1>Liste des annonces</h1>

        <!-- Bouton pour déposer une nouvelle annonce -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="deposer_annonce.php" class="btn-deposer-annonce">Déposer une annonce</a>
        <?php else: ?>
            <p><a href="login.php">Connectez-vous</a> pour déposer une annonce.</p>
        <?php endif; ?>

        <!-- Afficher les annonces -->
        <?php if (!empty($annonces)): ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="annonce">
                    <h3><?php echo htmlspecialchars($annonce['marque'] . " " . $annonce['modele']); ?></h3>
                    <p>Prix par jour : <?php echo htmlspecialchars($annonce['prix_par_jour']); ?> €</p>
                    <p>Description : <?php echo htmlspecialchars($annonce['description']); ?></p>
                    <p>Lieu : <?php echo htmlspecialchars($annonce['location']); ?></p>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune annonce disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
