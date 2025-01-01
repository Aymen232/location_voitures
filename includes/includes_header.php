<?php
// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil: Location de voitures</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Image principale -->
    <div class="image-container">
        <img src="images/renault-stock-home.webp" alt="Renault Stock" class="image_voiture">
    </div>

    <!-- Barre de navigation -->
    <header class="top-bar">
        <div class="logo">
            L<img src="images/roue.jpg" alt="Roue" class="logo-wheel">CAR
        </div>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="annonces.php">Annonces</a>
            <a href="reservations.php">Mes Réservations</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Si l'utilisateur est connecté -->
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <!-- Si l'utilisateur n'est pas connecté -->
                <a href="inscription.php">Inscription</a>
                <a href="login.php">Connexion</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Message de connexion/déconnexion -->
    <div class="status-connexion">
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($_SESSION['prenom']) . " " . htmlspecialchars($_SESSION['nom']); ?></strong></p>
        <?php else: ?>
            <p>Vous n'êtes pas connecté</p>
        <?php endif; ?>
    </div>
</body>
</html>
