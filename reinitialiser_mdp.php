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
<div class="reset-password-container">
    <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
    </div>
    <div class="form-group">
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmez le mot de passe" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn-submit">Réinitialiser</button>
    </div>
</div>
</body>