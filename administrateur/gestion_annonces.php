<?php
include('../DB/db_connection.php');
session_start();

// Vérification si l'utilisateur est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    die("Accès refusé : Vous devez être un administrateur pour accéder à cette page.");
}

// Récupérer les annonces en attente
$sql_annonces = "SELECT * FROM annonces WHERE statut = 'en attente'";
$result = $conn->query($sql_annonces);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des annonces</title>
    <link rel="stylesheet" href="../style.css"> <!-- Chemin relatif vers votre fichier CSS -->
</head>
<body>
    <h2>Gestion des annonces en attente</h2>

    <!-- Affichage des annonces -->
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Description</th>
                    <th>Prix par jour</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($annonce = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($annonce['id']) ?></td>
                        <td><?= htmlspecialchars($annonce['marque']) ?></td>
                        <td><?= htmlspecialchars($annonce['modele']) ?></td>
                        <td><?= htmlspecialchars($annonce['description']) ?></td>
                        <td><?= htmlspecialchars($annonce['prix_par_jour']) ?> €</td>
                        <td>
                            <form action="traiter_annonce.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $annonce['id'] ?>">
                                <button type="submit" name="action" value="valider">Valider</button>
                            </form>
                            <form action="traiter_annonce.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $annonce['id'] ?>">
                                <button type="submit" name="action" value="refuser">Refuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune annonce en attente.</p>
    <?php endif; ?>

    <!-- Lien pour retourner au tableau de bord -->
    <a href="dashboard_admin.php">Retour au tableau de bord</a>
</body>
</html>
