<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="style.css"> <!-- Chargement du fichier CSS -->
</head>
<body>

<header>
    <?php include('includes/includes_header.php'); ?>
</header>

<div class="resultats-recherche">
    <?php if (!empty($_SESSION['resultats'])): ?>
        <h2 style="text-align:center;">Résultats de la recherche</h2>
        <div class="annonces-container">
            <?php foreach ($_SESSION['resultats'] as $annonce): ?>
                <div class="annonce-card">
                    <img src="<?= htmlspecialchars($annonce['photo'] ?? 'default-image.jpg') ?>" alt="Photo de <?= htmlspecialchars($annonce['marque']) ?>">
                    <div class="annonce-card-content">
                        <h3><?= htmlspecialchars($annonce['marque']) ?> <?= htmlspecialchars($annonce['modele']) ?></h3>
                        <p class="price"><?= htmlspecialchars($annonce['prix_par_jour']) ?> € / jour</p>
                        <p><?= htmlspecialchars($annonce['description']) ?></p>
                        <p class="availability">Disponible du <?= htmlspecialchars($annonce['date_debut']) ?> à <?= htmlspecialchars($annonce['heure_debut']) ?><br> 
                            au <?= htmlspecialchars($annonce['date_fin']) ?> à <?= htmlspecialchars($annonce['heure_fin']) ?>
                        </p>
                        <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                            <form action="process/process_reservation.php" method="POST">
                            <input type="hidden" name="annonce_id" value="<?= htmlspecialchars($annonce['id']) ?>">
                            <button type="submit" class="btn-reserver">Réserver</button>
                            </form>
                        <?php else: ?>
                            <p style="color: red; font-size: 14px;">Connectez-vous pour réserver</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($_SESSION['message'])): ?>
        <p class="message-erreur"><?= htmlspecialchars($_SESSION['message']) ?></p>
    <?php endif; ?>
</div>


<footer>
    <?php include('includes/includes_footer.php'); ?>
</footer>

</body>
</html>
