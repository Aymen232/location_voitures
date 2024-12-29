<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: annonces.php");
    exit;
}
// Vérifier s'il y a un message d'erreur à afficher
$error_message = "";
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // Supprimer le message d'erreur de la session
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Inclure les fichiers nécessaires
    include("DB/db_connection.php");
    include("includes/includes_header.php");
    ?>
    <!-- Formulaire de connexion -->
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="/location_voitures/process/process_login.php" method="POST" class="form-signin">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Entrez votre email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" class="form-control" required>
            </div>
            <a href="reinitialiser_mdp.php" class="forgot-password">Mot de passe oublié?</a>
            <div class="form-group">
                <button type="submit" class="btn-submit">Se connecter</button>
            </div>
        </form>
    </div>

    <!-- Affichage du message d'erreur -->
    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
</body>
</html>
