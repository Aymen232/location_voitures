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
    include("db/db_connection.php");
    include("includes/includes_header.php");
    ?>
    <!-- Formulaire de connexion -->
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Se connecter</button>
            </div>
        </form>
    </div>

</body>
</html>