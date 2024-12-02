<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription: Location de Voitures</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers ta feuille de style -->
</head>
<body>
    <?php include("includes/includes_header.php"); ?> 
    <!-- Conteneur principal du formulaire d'inscription -->
    <div class="register-container">
        <h2>Inscription</h2>
        <form action="process/process_inscription.php" method="POST"> 
            <!-- Champ pour le nom -->
            <div class="form-group">
                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>
            </div>
            <!-- Champ pour le prénom -->
            <div class="form-group">
                <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
            </div>
            <!-- Champ pour l'email -->
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            </div>
            <!-- Champ pour le mot de passe -->
            <div class="form-group">
                <input type="password" id="password" name="mot_de_passe" placeholder="Entrez un mot de passe" required>
            </div>
            <!-- Champ pour confirmer le mot de passe -->
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirmer_mot_de_passe" placeholder="Confirmez le mot de passe" required>
            </div>
            <!-- Option de sélection du rôle (optionnel) -->
            <div class="form-group">
                <select id="role" name="role">
                    <option value="utilisateur">Utilisateur</option>
                    <option value="administrateur">Administrateur</option>
                </select>
            </div>
            <!-- Bouton de soumission -->
            <div class="form-group">
                <button type="submit" class="btn-submit">S'inscrire</button> 
            </div>
        </form>
    </div>
</body>
</html>
