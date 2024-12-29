<?php
// Démarrer la session si elle n'est pas encore active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier de connexion à la base de données
include('../DB/db_connection.php');

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: ../login.php");
    exit();
}

// Récupérer des statistiques sur les annonces
try {
    $stat_valides = $conn->query("SELECT COUNT(*) AS count FROM annonces WHERE statut = 'validée'")->fetch_assoc()['count'] ?? 0;
    $stat_refusees = $conn->query("SELECT COUNT(*) AS count FROM annonces WHERE statut = 'refusée'")->fetch_assoc()['count'] ?? 0;
    $stat_total = $conn->query("SELECT COUNT(*) AS count FROM annonces")->fetch_assoc()['count'] ?? 0;

    // Récupérer les annonces en attente
    $sql_annonces = "SELECT * FROM annonces WHERE statut = 'en attente'";
    $result_annonces = $conn->query($sql_annonces);
} catch (Exception $e) {
    $stat_valides = $stat_refusees = $stat_total = 0;
    $result_annonces = null;
    error_log("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administrateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <?php include('../includes/includes_header_dashboard.php'); ?>
</header>

<div class="status-connexion">
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Vous êtes connecté en tant qu'<strong>Administrateur</strong>: 
            <?php echo htmlspecialchars($_SESSION['prenom'] . " " . $_SESSION['nom']); ?></p>
    <?php else: ?>
        <p>Vous n'êtes pas connecté.</p>
    <?php endif; ?>
</div>

<main>
    <div class="header-container">
        <h1 class="align-left-middle">Tableau de bord - Annonces</h1>
    </div>

    <!-- Section des statistiques -->
    <section>
        <h2>Statistiques des annonces</h2>
        <p><strong>Total d'annonces :</strong> <?php echo htmlspecialchars($stat_total); ?></p>
        <p><strong>Annonces validées :</strong> <?php echo htmlspecialchars($stat_valides); ?></p>
        <p><strong>Annonces refusées :</strong> <?php echo htmlspecialchars($stat_refusees); ?></p>
    </section>

    <!-- Section des annonces en attente -->
    <section>
        <h2>Annonces en attente</h2>
        <?php if ($result_annonces && $result_annonces->num_rows > 0): ?>
            <div class="annonces-pending">
                <?php while ($annonce = $result_annonces->fetch_assoc()): ?>
                    <div class="annonce-card">
                        <h3><?= htmlspecialchars($annonce['marque']) . " " . htmlspecialchars($annonce['modele']) ?></h3>
                        <p><strong>Description :</strong> <?= htmlspecialchars($annonce['description']) ?></p>
                        <p><strong>Prix par jour :</strong> <?= htmlspecialchars($annonce['prix_par_jour']) ?> €</p>
                        <p><strong>Lieu :</strong> <?= htmlspecialchars($annonce['location']) ?></p>
                        <p><strong>Date début :</strong> <?= htmlspecialchars($annonce['date_debut']) ?> à <?= htmlspecialchars($annonce['heure_debut']) ?></p>
                        <p><strong>Date fin :</strong> <?= htmlspecialchars($annonce['date_fin']) ?> à <?= htmlspecialchars($annonce['heure_fin']) ?></p>
                        <form action="gestion_annonces.php" method="GET" style="text-align: center;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($annonce['id']) ?>">
                            <button type="submit">Gérer</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Aucune annonce en attente.</p>
        <?php endif; ?>
    </section>

    <!-- Section des actions rapides -->
    <section>
        <h2>Actions rapides</h2>
        <ul>
            <li><a href="gestion_de_utilisateur.php">Gérer les utilisateurs</a></li>
            <li><a href="exporter_statistiques.php">Exporter les statistiques</a></li>
        </ul>
    </section>
</main>

<footer>
    <p>© 2024 Location de Voitures. Tous droits réservés.</p>
</footer>
</body>
</html>
