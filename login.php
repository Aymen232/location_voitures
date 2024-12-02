<?php
// Démarrer la session
session_start();

// Vérifier s'il y a un message d'erreur à afficher
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // Supprimer le message d'erreur de la session
    // Mettre en place un délai de 2 secondes avant la redirection
    header("Refresh: 2; url=login.php");
} else {
    $error_message = "";
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
    include("DB/db_connection.php");
    include("includes/includes_header.php");
    ?>
    <!-- Formulaire de connexion -->
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="/location_voitures/process/process_login.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <a href="reinitialiser_mdp.php">Mot de passe oublié?</a>
            <div class="form-group">
                <button type="submit" class="btn-submit">Se connecter</button>
            </div>
        </form>
    </div>
    <!-- Affichage du message d'erreur -->
    <?php
    if ($error_message) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>


</body>
</html>